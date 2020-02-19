<?php


namespace Ampeco\OmnipayEcpay\SDK;


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
     * @return \Psr\Http\Message\ResponseInterface|void
     */
    public function post($uri, array $options = [])
    {
        $body =  http_build_query($options);
        $options = ['body' => $body];
        return parent::post($uri, $options);
    }
}
