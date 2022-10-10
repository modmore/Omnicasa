<?php
/* Get the core config */

use modmore\Omnicasa\Model\ocProperty;
use MODX\Revolution\modDashboardWidget;

$componentPath = dirname(__DIR__);
if (!file_exists($componentPath.'/config.core.php')) {
    die('ERROR: missing '.$componentPath.'/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once $componentPath . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error','error.modError', '', '');
$modx->setLogTarget('HTML');

/* Namespace */
if (!createObject('modNamespace',array(
    'name' => 'omnicasa',
    'path' => $componentPath.'/core/components/omnicasa/',
    'assets_path' => $componentPath.'/assets/components/omnicasa/',
),'name', false)) {
    echo "Error creating namespace omnicasa.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', array(
    'key' => 'omnicasa.core_path',
    'value' => $componentPath.'/core/components/omnicasa/',
    'xtype' => 'textfield',
    'namespace' => 'omnicasa',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating omnicasa.core_path setting.\n";
}

if (!createObject('modSystemSetting', array(
    'key' => 'omnicasa.assets_path',
    'value' => $componentPath.'/assets/components/omnicasa/',
    'xtype' => 'textfield',
    'namespace' => 'omnicasa',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating omnicasa.assets_path setting.\n";
}

/* Fetch assets url */
$requestUri = $_SERVER['REQUEST_URI'] ?: __DIR__ . '/_bootstrap/index.php';
$bootstrapPos = strpos($requestUri, '_bootstrap/');
$requestUri = rtrim(substr($requestUri, 0, $bootstrapPos), '/').'/';
$assetsUrl = "{$requestUri}assets/components/omnicasa/";

if (!createObject('modSystemSetting', array(
    'key' => 'omnicasa.assets_url',
    'value' => $assetsUrl,
    'xtype' => 'textfield',
    'namespace' => 'omnicasa',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating omnicasa.assets_url setting.\n";
}


if (!createObject('modSnippet', array(
    'name' => 'omnicasa.list',
    'static' => true,
    'static_file' => $componentPath . '/_build/elements/snippets/list.snippet.php',
), 'name', false)) {
    echo "Error creating modSnippet.\n";
}
if (!createObject('modSnippet', array(
    'name' => 'omnicasa.single',
    'static' => true,
    'static_file' => $componentPath . '/_build/elements/snippets/single.snippet.php',
), 'name', false)) {
    echo "Error creating modSnippet.\n";
}
if (!createObject('modSnippet', array(
    'name' => 'omnicasa.propertyTypes',
    'static' => true,
    'static_file' => $componentPath . '/_build/elements/snippets/propertyTypes.snippet.php',
), 'name', false)) {
    echo "Error creating modSnippet.\n";
}
if (!createObject('modSnippet', array(
    'name' => 'omnicasa.cities',
    'static' => true,
    'static_file' => $componentPath . '/_build/elements/snippets/cities.snippet.php',
), 'name', false)) {
    echo "Error creating modSnippet.\n";
}


$settings = include dirname(__DIR__) . '/_build/data/settings.php';
foreach ($settings as $key => $opts) {
    $val = $opts['value'];

    if (isset($opts['xtype'])) $xtype = $opts['xtype'];
    elseif (is_int($val)) $xtype = 'numberfield';
    elseif (is_bool($val)) $xtype = 'modx-combo-boolean';
    else $xtype = 'textfield';

    if (!createObject('modSystemSetting', array(
        'key' => 'omnicasa.' . $key,
        'value' => $opts['value'],
        'xtype' => $xtype,
        'namespace' => 'omnicasa',
        'area' => $opts['area'],
        'editedon' => time(),
    ), 'key', false)) {
        echo "Error creating omnicasa.".$key." setting.\n";
    }
}

$widgets = include $componentPath . '/_build/data/transport.dashboard_widgets.php';
if (empty($widgets)) $modx->log(modX::LOG_LEVEL_ERROR,'Could not create widgets.');
foreach ($widgets as $key => $obj) {
    /** @var modDashboardWidget $obj */
    if (!createObject(modDashboardWidget::class, $obj->toArray(), 'name', false)) {
        echo "Error creating ".$obj->get('name')." widget.\n";
    }
}

/** @var Scheduler $scheduler */
$path = $modx->getOption('scheduler.core_path', null, $modx->getOption('core_path') . 'components/scheduler/');
$scheduler = $modx->getService('scheduler', 'Scheduler', $path . 'model/scheduler/');
if (!$scheduler) {
    echo "Unable to create scheduler task\n";
}
elseif (!createObject('sFileTask', array(
    'class_key' => 'sFileTask',
    'content' => 'elements/tasks/synchronise.php',
    'namespace' => 'omnicasa',
    'reference' => 'synchronise',
    'description' => 'Synchronises properties from Omnicasa to MODX.'
), ['namespace', 'reference'])) {
    echo "Error saving Task\n";
}

// Make sure our module can be loaded. In this case we're using a composer-provided PSR4 autoloader.
include $componentPath . '/core/components/omnicasa/vendor/autoload.php';

new \modmore\Omnicasa\Omnicasa(
    $modx,
    $modx->services->get(\Psr\Http\Client\ClientInterface::class),
    $modx->services->get(\Psr\Http\Message\RequestFactoryInterface::class)
);

$manager = $modx->getManager();
$manager->createObjectContainer(\modmore\Omnicasa\Model\ocProperty::class);

$manager->addField(ocProperty::class, 'type_of_property', ['after' => 'oc_ID']);
$manager->addIndex(ocProperty::class, 'type_of_property');

// Clear the cache
$modx->cacheManager->refresh();

echo "Done.";


/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject ($className = '', array $data = array(), $primaryField = '', $update = true) {
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        if (is_array($primaryField)) {
            $condition = array();
            foreach ($primaryField as $key) {
                $condition[$key] = $data[$key];
            }
        }
        else {
            $condition = array($primaryField => $data[$primaryField]);
        }
        $object = $modx->getObject($className, $condition);
        if ($object instanceof $className) {
            if ($update) {
                $object->fromArray($data);
                return $object->save();
            } else {
                $condition = $modx->toJSON($condition);
                echo "Skipping {$className} {$condition}: already exists.\n";
                return true;
            }
        }
    }

    /* Create new object if it doesn't exist */
    if (!$object) {
        $object = $modx->newObject($className);
        $object->fromArray($data, '', true);
        return $object->save();
    }

    return false;
}
