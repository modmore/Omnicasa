<?php

use modmore\Omnicasa\Omnicasa;

class OmnicasaDashboardWidget extends \MODX\Revolution\modDashboardWidgetInterface
{

    public function render(): string
    {
        $this->modx->services->get(Omnicasa::class);

        $this->widget->set('name', $this->getTitleBar());
        $syncPlanned = $this->checkForSync();

        $this->controller->addHtml(<<<HTML

<style>
#dashboard-block-{$this->widget->get('id')} {
    background: #d9eefe;
    background: linear-gradient(120deg, #d9eefe 0%, rgb(134,204,255) 34%, rgb(153,210,255) 85%); 
    position: relative;
    display: flex;
    flex-direction: column;
}
#dashboard-block-{$this->widget->get('id')}:after {
    position: absolute;
    content: ' ';
    background: url('/Omnicasa/assets/components/omnicasa/omnicasa.svg') no-repeat bottom;
    background-size: contain;
    right: 2em;
    bottom: 2em;
    width: 200px;
    height: 100px;
}
#dashboard-block-{$this->widget->get('id')} .body {
    display: flex;
    flex-direction: column;
    flex: 1;
}
#dashboard-block-{$this->widget->get('id')} .title-wrapper {background: #fff;}

.omnicasa-widget {
    display: flex;
    flex-direction: column;
    justify-content: center;
    flex: 1;
}
.omnicasa-widget .oc-sync-form, .omnicasa-widget .oc-sync-planned {
    text-align: center;
    font-size: 1rem;
    margin-bottom: 1.5rem;
}
.omnicasa-widget .oc-sync-planned span {
    background: #6CB24A;
    color: #fff;
    border-radius: 3px;
    padding: 10px 15px 10px 15px;
}
.omnicasa-widget .oc-split {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin: 2rem 0;
}
.omnicasa-widget .oc-synced_properties, .omnicasa-widget .oc-last-sync {
    text-align: center;
}
.omnicasa-widget .oc-stat {
    font-size: 3rem;
    line-height: 1em;
    display: block;
    color: #234368;
}
.omnicasa-widget .oc-label {
    display: block;
    font-size: 0.9rem;
    text-transform: uppercase;
    padding: 0.5em;
    font-weight: bold;
    color: rgba(35, 67, 104, 0.88);
}
.oc-connected_as {
    margin-left: 1em;
    font-weight: normal;
}
</style>

<script>
Ext.onReady(function() {
    Ext.applyIf(MODx.lang, {$this->modx->toJSON($this->modx->lexicon->loadCache('omnicasa'))});
});
</script>
HTML
        );

        $numProperties = $this->getPropertiesCount();
        $lastSync = $this->getLastSync();
        $lastSync = $lastSync > 0 ? $this->timeSince(time() - $lastSync) : $this->modx->lexicon('omnicasa.never');

        $sync = $syncPlanned
            ? '<p class="oc-sync-planned"><span>' . $this->modx->lexicon('omnicasa.sync_planned') . '</span></p>'
            : <<<HTML
    <form action="" method="post" class="oc-sync-form">
        <input type="hidden" name="omnicasa_do_sync" value="1">
        <button type="submit" class="x-btn primary-button">
            <i class="icon icon-refresh"></i>
            {$this->modx->lexicon('omnicasa.sync_now')}
        </button>
    </form>
HTML;

        return <<<HTML
<div id="omnicasa-widget-{$this->widget->get('id')}" class="omnicasa-widget" 
    data-id="{$this->widget->get('id')}"
>
    <div class="oc-split">
        <div class="oc-synced_properties">
            <span class="oc-stat">{$numProperties}</span>
            <span class="oc-label">{$this->modx->lexicon('omnicasa.synced_properties')}</span>
        </div>
        <div class="oc-last-sync">
            <span class="oc-stat">{$lastSync}</span>
            <span class="oc-label">{$this->modx->lexicon('omnicasa.last_sync')}</span>
        </div>
    </div>
    
    {$sync}
</div>
HTML;
    }


    private function getConnectedName(): string
    {
        return (string)$this->modx->getOption('omnicasa.customerName');
    }

    private function getPropertiesCount(): int
    {
        return (int)$this->modx->getCount(\modmore\Omnicasa\Model\ocProperty::class);
    }

    private function getLastSync()
    {
        $c = $this->modx->newQuery(\modmore\Omnicasa\Model\ocProperty::class);
        $c->sortby('SynchronisedDate', 'DESC');
        $c->select([
            'id', 'SynchronisedDate'
        ]);
        $c->limit(1);

        $o = $this->modx->getObject(\modmore\Omnicasa\Model\ocProperty::class, $c);

        return $o ? strtotime($o->get('SynchronisedDate')) : 0;
    }

    private function timeSince($since): string
    {
        $this->modx->lexicon->load('filters');

        $chunks = array(
            array(60 * 60 * 24 * 365 , 'year'),
            array(60 * 60 * 24 * 30 , 'month'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hour'),
            array(60 , 'minute'),
            array(1 , 'second')
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }

        $print = ($count == 1) ? '1 '. $this->modx->lexicon('ago_' . $name) : "$count {$this->modx->lexicon('ago_' . $name . 's')}";

        return $this->modx->lexicon('ago', ['time' => $print]);
    }

    private function getTitleBar(): string
    {
        return <<<HTML
    {$this->modx->lexicon($this->widget->get('name'))}
    <span class="oc-connected_as">{$this->getConnectedName()}</span>
HTML;

    }

    private function checkForSync()
    {
        if (!isset($_POST) || !isset($_POST['omnicasa_do_sync'])) {
            return false;
        }


        /** @var Scheduler $scheduler */
        $path = $this->modx->getOption('scheduler.core_path', null, $this->modx->getOption('core_path') . 'components/scheduler/');
        $scheduler = $this->modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');
        if (!$scheduler) {
            $this->modx->log(\MODX\Revolution\modX::LOG_LEVEL_ERROR, 'Error scheduling Omnicasa sync: Scheduler not found');
            return false;
        }

        $task = $scheduler->getTask('omnicasa', 'synchronise');
        if ($task) {
            $task->schedule(time() - 2, [
                'type' => 'onetime',
                'requested_by' => $this->modx->user->get('username'),
            ]);
            return true;
        }
        $this->modx->log(\MODX\Revolution\modX::LOG_LEVEL_ERROR, 'Error scheduling Omnicasa sync: task omnicasa:synchronise not found');
        return false;
    }
}

return OmnicasaDashboardWidget::class;

