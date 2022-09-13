<?php

namespace modmore\Omnicasa;

use modmore\Omnicasa\Client\Properties;
use MODX\Revolution\modX;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use xPDO\xPDOException;

class Omnicasa {

    public modX $modx;
    private ClientInterface $httpClient;
    private RequestFactoryInterface $httpRequestFactory;

    private static ?Properties $properties = null;

    /**
     * @throws InvalidAPIKeyException|xPDOException
     */
    public function __construct(modX $modx, ClientInterface $client, RequestFactoryInterface $requestFactory)
    {
        $this->modx = $modx;
        $this->modx->lexicon->load('omnicasa:default');

        // Load xPDO package
        if (!$this->modx->addPackage('modmore\\Omnicasa\\Model', __DIR__ . '/Model/', null, 'My\\Component\\')) {
            throw new xPDOException('Unable to load Omnicasa xPDO package!');
        }

        $this->httpClient = $client;
        $this->httpRequestFactory = $requestFactory;
    }


    public function properties()
    {
        if (!self::$properties) {
            self::$properties = new Properties(
                $this->httpClient, $this->httpRequestFactory,
                (string)$this->modx->getOption('omnicasa.customerName'),
                (string)$this->modx->getOption('omnicasa.customerPassword'),
            );
        }

        return self::$properties;
    }


}
