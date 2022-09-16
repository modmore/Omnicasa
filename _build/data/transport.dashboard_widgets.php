<?php
/**
 * @var modX $modx
 * @var string $componentPath
 */

$widgets = [];

// Use different base paths if we're bootstrapping rather than building.
if (isset($componentPath)) {
    $basePath = $componentPath . '/core/';
}
else {
    $basePath = '[[++core_path]]';
}

$widgets[0]= $modx->newObject(\MODX\Revolution\modDashboardWidget::class);
$widgets[0]->fromArray([
    'name' => 'omnicasa.widget_name',
    'description' => 'omnicasa.widget_desc',
    'type' => 'file',
    'size' => 'one-third',
    'content' => $basePath . 'components/omnicasa/elements/widgets/omnicasa.class.php',
    'namespace' => 'omnicasa',
    'lexicon' => 'omnicasa:default',
], '', true, true);

return $widgets;