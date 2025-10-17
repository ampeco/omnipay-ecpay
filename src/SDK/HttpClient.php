<?php


namespace Ampeco\OmnipayEcpay\SDK;

use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

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

    public function handlePostRequest(UriInterface|string $uri, array $options = []): ?ResponseInterface
    {
        try {
            $body =  http_build_query($options);
            $options = ['body' => $body];

            return parent::post($uri, $options);
        } catch (BadResponseException $exception) {
            return $exception->getResponse();
        }
    }

    public function reInit($options = [])
    {
        $config = $this->getConfig();
        parent::__construct(array_merge($config, $options));
        return $this;
    }
}
