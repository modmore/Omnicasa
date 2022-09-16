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


            $corePath = $modx->getOption('core_path').'components/omnicasa/';
            require_once $corePath . 'vendor/autoload.php';
            $level = $modx->setLogLevel(\xPDO\xPDO::LOG_LEVEL_ERROR);

            $modx->addPackage('modmore\\Omnicasa\\Model', $corePath . 'src/Model/');
            $manager = $modx->getManager();

            $manager->createObjectContainer(ocProperty::class);

            $modx->setLogLevel($level);

            break;
    }
}
return true;