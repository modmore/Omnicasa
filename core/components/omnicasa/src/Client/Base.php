<?php

namespace modmore\Omnicasa\Client;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use SoapClient;

class Base {
    private static string $endpoint = 'https://newapi.omnicasa.com/1.13/OmnicasaService.svc/';
    private string $username;
    private string $password;
    private ClientInterface $httpClient;
    private RequestFactoryInterface $httpRequestFactory;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $httpRequestFactory, string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->httpClient = $httpClient;
        $this->httpRequestFactory = $httpRequestFactory;
    }

    protected function call(string $method, array $data, string $resultClass)
    {
        $data['customerName'] = $this->username;
        $data['customerPassword'] = $this->password;
        
        $param = json_encode($data, JSON_INVALID_UTF8_SUBSTITUTE | JSON_THROW_ON_ERROR);

        $url = self::$endpoint . $method . '?' . http_build_query(['json' => $param]);
        
        $request = $this->httpRequestFactory->createRequest(
            'GET',
            $url
        );

        $response = $this->httpClient->sendRequest($request);

        $result = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $key = $method . 'Result';
        if (array_key_exists($key, $result)) {
            $result = $result[$key];
        }

        if (method_exists($resultClass, 'fromResponse')) {
            return $resultClass::fromResponse($result);
        }
        else {
            echo "$resultClass::fromResponse doesn't exist";
        }
        return $result;

        exit();

    }
}