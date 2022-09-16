<?php
/**
 * @var modX $modx
 * @var xPDOTransport $transport
 * @var array $options
 */

use modmore\Omnicasa\Model\ocProperty;
use xPDO\Transport\xPDOTransport;

if ($transport->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            $modx =& $transport->xpdo;


            /** @var Scheduler $scheduler */
            $path = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/');
            $scheduler = $modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');
            if (!$scheduler) {
                $modx->log(\xPDO\xPDO::LOG_LEVEL_ERROR, 'Can\'t set up Scheduler task, as Scheduler can\'t be loaded. Please make sure Scheduler is installed, and then reinstall Omnicasa.');
                return true;
            }

            if (!$modx->getObject('sFileTask', [
                'namespace' => 'omnicasa',
                'reference' => 'synchronise'
            ])) {
                $task = $modx->newObject('sFileTask');
                $task->fromArray([
                    'class_key' => 'sFileTask',
                    'content' => 'elements/tasks/synchronise.php',
                    'namespace' => 'omnicasa',
                    'reference' => 'synchronise',
                    'description' => 'Synchronises properties from Omnicasa to MODX.'
                ]);
                if ($task->save()) {
                    $modx->log(\xPDO\xPDO::LOG_LEVEL_INFO, 'Created Scheduler task');
                }
            }
            break;
    }
}
return true;