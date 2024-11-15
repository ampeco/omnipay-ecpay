<?php


namespace Ampeco\OmnipayEcpay\SDK;


use Psr\Http\Message\ResponseInterface;
use function GuzzleHttp\Psr7\parse_query;

trait LoadsHttpClient
{
    protected $httpClient = null;
    protected $httpClientOptions = [];
    protected $usesMock = false;

    protected function getHttpClient(){
        if ($this->httpClient != null){
            return $this->httpClient;
        }

        $this->httpClient = new HttpClient($this->httpClientOptions);

        return $this->httpClient;
    }

    protected function setHttpClientOptions($options){
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
