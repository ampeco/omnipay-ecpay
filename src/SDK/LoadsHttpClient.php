<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Omnipay\Common\Http\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\parse_query;

trait LoadsHttpClient
{
    protected $omnipayClient = null;
    protected $baseUri = '';
    protected $usesMock = false;
    protected $httpClient = null;
    protected $httpClientOptions = [];

    protected function setOmnipayClient(ClientInterface $client)
    {
        $this->omnipayClient = $client;
    }

    protected function setBaseUri(string $baseUri)
    {
        $this->baseUri = rtrim($baseUri, '/') . '/';
    }

    protected function getBaseUri()
    {
        return $this->baseUri;
    }

    protected function handlePostRequest($endpoint, array $data = []): ?ResponseInterface
    {
        if ($this->usesMock || $this->omnipayClient === null) {
            return $this->getHttpClient()->handlePostRequest($endpoint, $data);
        }

        $url = $this->baseUri . ltrim($endpoint, '/');
        $body = http_build_query($data);

        return $this->omnipayClient->request(
            'POST',
            $url,
            ['Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'],
            $body,
        );
    }

    protected function getHttpClient()
    {
        if ($this->httpClient != null){
            return $this->httpClient;
        }

        $this->httpClient = new HttpClient($this->httpClientOptions);

        return $this->httpClient;
    }

    protected function setHttpClientOptions($options)
    {
        $this->httpClientOptions = $options;
        $this->httpClient = null;
    }

    /**
     * @param ResponseInterface|null $response
     * @return array
     */
    protected function parseResponse($response) {
        return $response ? parse_query($response->getBody()->getContents()) : [];
    }

    public function setMockClient(HttpClient $client)
    {
        $this->usesMock = true;

        $this->httpClient = $client->reInit($this->httpClientOptions);
    }
}
