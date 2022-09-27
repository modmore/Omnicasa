<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $scriptProperties
 */

use modmore\Omnicasa\Model\ocProperty;
use \modmore\Omnicasa\Omnicasa;

/** @var Omnicasa $omnicasa */
$omnicasa = $modx->services->get(Omnicasa::class);

$tpl = $modx->getOption('tpl', $scriptProperties, 'propertyTpl');

$totalVar = $modx->getOption('totalVar', $scriptProperties, 'total');
$limit = $modx->getOption('limit', $scriptProperties,10);
$offset = $modx->getOption('offset', $scriptProperties,0);
$sortby = $modx->getOption('sortby', $scriptProperties,'CreatedDate');
$sortdir = $modx->getOption('sortdir', $scriptProperties,'desc');
$acceptFromUrl = $modx->getOption('acceptFromUrl', $scriptProperties,'');
$acceptFromUrl = array_filter(array_map('trim', explode(',', $acceptFromUrl)));
$where = $modx->getOption('where', $scriptProperties,'');
$where = !empty($where) ? json_decode($where, true, 512) : false;
$cache = (bool)$modx->getOption('cacheOutput', $scriptProperties,true);
$detailPrefix = $modx->getOption('detailPrefix', $scriptProperties, '');
if (empty($detailPrefix) && isset($modx->resource)) {
    $detailPrefix = $modx->makeUrl($modx->resource->get('id'), '', '', 'abs');
}


// Prepare a query for the locally-stored properties
$c = $modx->newQuery(ocProperty::class);

// Allow generic &where to filter results
if (is_array($where)) {
    $c->andCondition($where);
}

$filterParams = [];

// Allow URL parameters/POST values to be used for simple filtering
foreach ($acceptFromUrl as $param) {
    if (array_key_exists($param, $_REQUEST) && !empty($_REQUEST[$param])) {
        $filterParams[$param] = (string)$_REQUEST[$param];
        switch ($param) {
            case 'Price_min':
                $c->andCondition([
                    "Price:>=" => $_REQUEST[$param],
                ]);
                break;
            case 'Price_max':
                $c->andCondition([
                    "Price:<=" => $_REQUEST[$param],
                ]);
                break;

            default:
                $c->andCondition([
                    "$param:=" => $_REQUEST[$param],
                ]);
        }
    }
}


$total = $modx->getCount(ocProperty::class, $c);
$modx->setPlaceholder($totalVar,$total);
$c->limit($limit,$offset);

$c->sortby($sortby, $sortdir);

$c->prepare();
$q = $c->toSQL();
$cacheKey = 'requests/' . sha1(sha1($q).sha1($tpl).sha1($modx->getChunk($tpl)).sha1(json_encode($filterParams)));

if ($cache) {
    $cached = $modx->cacheManager->get($cacheKey, $omnicasa::$cacheOptions);
    if (!empty($cached)) {
        return $cached;
    }
}



$out = [];
/** @var ocProperty $property */
$idx = 0;
$suffix = strpos($detailPrefix, '?') === false ? '?' : '&';
$suffix .= http_build_query(['filter' => $filterParams]);
foreach ($modx->getIterator(ocProperty::class, $c) as $property) {
    $url = rtrim($detailPrefix, '/') . '/' . $property->get('alias') . $suffix;
    $a = array_merge($property->get('all_data'), $property->toArray(), [
        'idx' => $idx,
        'url' => $url,
    ]);
    unset($a['all_data']);
    $a['dump'] = '<pre><code>' . htmlentities(print_r($a, true)) . '</code></pre>';

    $out[] = $modx->getChunk($tpl, $a);
    $idx++;
}


$out = implode("\n", $out);
if ($cache) {
    $modx->cacheManager->set($cacheKey, $out, 0, $omnicasa::$cacheOptions);
}
return $out;