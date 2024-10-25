<?php


namespace Ampeco\OmnipayEcpay\SDK;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

class HttpClient extends \GuzzleHttp\Client
{

    public function __construct(array $config = [])
    {

        $options = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            ]
        ];
        parent::__construct(array_merge($config, $options));
    }

    /**
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface|null|void
     */
    public function post($uri, array $options = []): ResponseInterface
    {
        $body =  http_build_query($options);
        $options = ['body' => $body];

        try {
            return parent::post($uri, $options);
        } catch (ConnectException|ServerException $exception) {
            return null;
        }
    }
}
