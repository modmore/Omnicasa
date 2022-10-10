<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $scriptProperties
 */

use modmore\Omnicasa\Model\ocProperty;
use \modmore\Omnicasa\Omnicasa;

/** @var Omnicasa $omnicasa */
$omnicasa = $modx->services->get(Omnicasa::class);

$tpl = $modx->getOption('tpl', $scriptProperties, '');

$sortby = $modx->getOption('sortby', $scriptProperties,'WebIDName');
$sortdir = $modx->getOption('sortdir', $scriptProperties,'ASC');
$where = $modx->getOption('where', $scriptProperties,'');
$where = !empty($where) ? json_decode($where, true, 512) : false;

$cache = (bool)$modx->getOption('cache', $scriptProperties,true);

// Prepare a query for the locally-stored properties
$c = $modx->newQuery(ocProperty::class);
$c->groupby('WebID');
$c->groupby('WebIDName');
$c->select($modx->getSelectColumns(ocProperty::class, 'ocProperty', '', ['WebID', 'WebIDName']));
$c->select([
    'COUNT(id) as Count',
]);

// Allow generic &where to filter results
if (is_array($where)) {
    $c->andCondition($where);
}

$c->sortby($sortby, $sortdir);

$cacheKey = 'propertyTypes';

$active = !empty($_GET['WebID']) ? (int)$_GET['WebID'] : '';
$cacheKey .= !empty($active) ? '/' . $active : '';
if (is_array($where) && !empty($where)) {
    $cacheKey .= '_' . sha1(json_encode($where, JSON_INVALID_UTF8_IGNORE));
}

if ($cache) {
    $cached = $modx->cacheManager->get($cacheKey, $omnicasa::$cacheOptions);
    if (!empty($cached)) {
        return $cached;
    }
}



$out = [];
/** @var ocProperty $property */
$idx = 0;
foreach ($modx->getIterator(ocProperty::class, $c) as $property) {
    $a = $property->toArray('', false, true);
    $a['selected'] = (int)$active === $a['WebID'] ? '1' : '';
    $out[] = $modx->getChunk($tpl, $a);
    $idx++;
}


$out = implode("\n", $out);
if ($cache) {
    $modx->cacheManager->set($cacheKey, $out, 0, $omnicasa::$cacheOptions);
}
return $out;