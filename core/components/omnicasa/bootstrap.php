<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

require_once __DIR__ . '/vendor/autoload.php';

$modx->services->add(\modmore\Omnicasa\Omnicasa::class, function(\Psr\Container\ContainerInterface $c) use ($modx) {
    return new \modmore\Omnicasa\Omnicasa(
        $modx,
        $c->get(\Psr\Http\Client\ClientInterface::class),
        $c->get(\Psr\Http\Message\RequestFactoryInterface::class)
    );
});

