<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $scriptProperties
 */

use modmore\Omnicasa\Model\ocProperty;
use \modmore\Omnicasa\Omnicasa;

/** @var Omnicasa $omnicasa */
$omnicasa = $modx->services->get(Omnicasa::class);
$detailPrefix = $modx->getOption('detailPrefix', $scriptProperties, '');
if (empty($detailPrefix) && isset($modx->resource)) {
    $detailPrefix = $modx->makeUrl($modx->resource->get('parent'), '', '', 'abs');
}

if (empty($_GET['slug']) || !is_string($_GET['slug'])) {
    $modx->sendErrorPage();
    return;
}

// Prepare a query for the locally-stored properties
$c = $modx->newQuery(ocProperty::class);
$c->where([
    'alias' => (string)$_GET['slug'],
]);

/** @var ocProperty $property */
$property = $modx->getObject(ocProperty::class, $c);
if (!$property) {
    $modx->sendErrorPage();
    return;
}

$a = array_merge($property->get('all_data'), $property->toArray(), [
    'url' => rtrim($detailPrefix, '/') . '/' . $property->get('alias'),
]);
unset($a['all_data']);
$json = json_encode($a, JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR);
$a['dump'] = '<pre><code>' . htmlentities(print_r($a, true)) . '</code></pre>';
$a['json'] = $json;

$modx->toPlaceholders($a, 'property');

return;
