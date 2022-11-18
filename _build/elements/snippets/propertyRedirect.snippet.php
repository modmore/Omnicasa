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

$propertyId = !empty($_GET['property']) ? (int)$_GET['property'] : 0;
$property = $modx->getObject(ocProperty::class, [
    'oc_ID' => $propertyId,
]);

if ($property) {
    $url = rtrim($detailPrefix, '/') . '/' . $property->get('alias');
    $modx->sendRedirect($url);
}

$modx->sendErrorPage();