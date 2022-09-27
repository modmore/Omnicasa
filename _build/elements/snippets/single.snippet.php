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
$thumbnailTpl = $modx->getOption('thumbnailTpl', $scriptProperties, '');
$imageTpl = $modx->getOption('imageTpl', $scriptProperties, '');

// Filter and ordering properties related to the prev/next functionality
$sortby = $modx->getOption('sortby', $scriptProperties,'CreatedDate');
$sortdir = $modx->getOption('sortdir', $scriptProperties,'desc');
$acceptFromUrl = $modx->getOption('acceptFromUrl', $scriptProperties,'');
$acceptFromUrl = array_filter(array_map('trim', explode(',', $acceptFromUrl)));
$where = $modx->getOption('where', $scriptProperties,'');
$where = !empty($where) ? json_decode($where, true, 512) : false;

if (empty($_GET['slug']) || !is_string($_GET['slug'])) {
    $modx->sendErrorPage();
    return;
}

$slug = (string)$_GET['slug'];
$slug = ltrim($slug, '/');
// Prepare a query for the locally-stored properties
$c = $modx->newQuery(ocProperty::class);
$c->where([
    'alias' => $slug,
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

if (!empty($thumbnailTpl)) {
    $a['Thumbnails'] = [];
    foreach ($a['MediumPictureItems'] as $smallPicture) {
        $a['Thumbnails'][] = $modx->getChunk($thumbnailTpl, $smallPicture);
    }
    $a['Thumbnails'] = implode("\n", $a['Thumbnails']);
}

if (!empty($imageTpl)) {
    $a['Images'] = [];
    foreach ($a['XLargePictureItems'] as $largePicture) {
        $a['Images'][] = $modx->getChunk($imageTpl, $largePicture);
    }
    $a['Images'] = implode("\n", $a['Images']);
}

$filter = (array)($_GET['filter'] ?? []);
$filterParams = [];
foreach ($acceptFromUrl as $key) {
    if (!empty($filter[$key])) {
        $filterParams[$key] = (string)$filter[$key];
        $where[$key] = (string)$filter[$key];
    }
}

$suffix = strpos($detailPrefix, '?') === false ? '?' : '&';
$suffix .= http_build_query(['filter' => $filterParams]);

$nc = $modx->newQuery(ocProperty::class);
if ($where) {
    $nc->where($where);
}
$nc->where([
    'id:!=' => $property->get('id'),
    $sortby . ':<=' => $property->get($sortby),
]);
$nc->sortby($sortby, $sortdir);
$nc->limit(1);

$next = $modx->getObject(ocProperty::class, $nc);
if ($next) {
    $a['next'] = $next->toArray();
    $a['next']['url'] = rtrim($detailPrefix, '/') . '/' . $next->get('alias') . $suffix;
}
$pc = $modx->newQuery(ocProperty::class);
if ($where) {
    $pc->where($where);
}
$pc->where([
    'id:!=' => $property->get('id'),
    $sortby . ':>=' => $property->get($sortby),
]);
$pc->sortby($sortby, strtoupper($sortdir) === 'DESC' ? 'ASC' : 'DESC');
$pc->limit(1);

$prev = $modx->getObject(ocProperty::class, $pc);
if ($prev) {
    $a['prev'] = $prev->toArray();
    $a['prev']['url'] = rtrim($detailPrefix, '/') . '/' . $prev->get('alias') . $suffix;
}

$json = json_encode($a, JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR);
$a['dump'] = '<pre><code>' . htmlentities(print_r($a, true)) . '</code></pre>';
$a['json'] = $json;
$modx->toPlaceholders($a, 'property');

return;