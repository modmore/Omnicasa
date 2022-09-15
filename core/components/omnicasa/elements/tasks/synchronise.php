<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var sTask $task
 * @var sTaskRun $run
 * @var array $data
 */

use modmore\Omnicasa\Model\ocProperty;
use modmore\Omnicasa\Omnicasa;

// Direct invocation (i.e. executed from the CLI)
if (!isset($modx)) {
    require_once dirname(__DIR__, 5) . '/config.core.php';
    require_once MODX_CORE_PATH . 'vendor/autoload.php';
    $modx = new \MODX\Revolution\modX();
    $modx->initialize('mgr');
    $data = [
        'type' => 'full',
    ];
}

// Re-schedule self recursively in incremental mode
if ($task instanceof sTask) {
    $task->schedule('+30 minutes', [
        'type' => 'incremental',
    ]);
}

/** @var Omnicasa $omnicasa */
$omnicasa = $modx->services->get(Omnicasa::class);
$properties = $omnicasa->properties();
$log = [];
$ids = [];

$batchSize = 25;
$start = 0;
$total = $properties->total();

$log[] = "Starting synchronisation of {$total} rows in batches of {$batchSize}";

while ($start < $total) {
    $until = $start + $batchSize;
    $startReal = $start + 1;
    $log[] = "Loading {$startReal}-{$until}";

    $list = $properties->list([
        'Limit1' => $startReal,
        'Limit2' => $until,
    ]);

    foreach ($list->getItems() as $apiProperty) {
        /** @var ocProperty $dbProperty */
        $dbProperty = $modx->getObject(ocProperty::class, [
            'oc_ID' => $apiProperty->ID,
        ]);
        $new = false;
        if (!$dbProperty) {
            $dbProperty = $modx->newObject(ocProperty::class);
            $new = true;
        }

        $apiProperty->populate($dbProperty);

        $alias = $dbProperty->get('alias');
        if (empty($alias)) {
            $alias = str_replace([
                '{City}',
                '{TypeDescription}',
                '{Street}',
                '{HouseNumber}',
            ], [
                $modx->filterPathSegment($apiProperty->City),
                $modx->filterPathSegment($apiProperty->TypeDescription),
                $modx->filterPathSegment($apiProperty->Street),
                $modx->filterPathSegment($apiProperty->HouseNumber),
            ], '{City}/{TypeDescription}/{Street}-{HouseNumber}');
            $alias = str_replace('//', '/', $alias);
            $alias = trim($alias, '/-');

            // Avoid duplicate aliases; append the Omnicasa ID
            if ($modx->getObject(ocProperty::class, [
                'alias' => $alias,
                'id:!=' => $dbProperty->get('id'),
            ])) {
                $alias .= '-' . $apiProperty->ID;
            }

            $dbProperty->set('alias', $alias);
        }

        $dbProperty->save();
        $log[] = "\t" . ($new ? 'new' : 'upd') . "\t$alias";

        $ids[] = $apiProperty->ID;
    }

    $start += $batchSize;

    sleep(3);
//    break;
}

if ($data['type'] === 'full') {
    $cleaned = $modx->removeCollection(ocProperty::class, [
        'oc_ID:NOT IN' => $ids,
    ]);
    $log[] = "Removed $cleaned no longer available properties";
}

$modx->getCacheManager()->refresh(['omnicasa' => []]);
$log[] = "Emptied cache";

$output = "- " . implode("\n- ", $log) . "\n";

// Return if executed through Scheduler
if ($run instanceof sTaskRun) {
    return $output;
}
// Otherwise echo and end
echo $output;
exit();
