<?php

namespace App\ApiClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    private HttpClientInterface $httpClient;

    /**
     * ApiClient constructor.
     *
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Make an API request.
     *
     * @param string $method HTTP method (GET, POST, etc.).
     * @param string $url The full URL to make the request to.
     * @param array $queryParams Optional query parameters.
     * @param array $headers Optional request headers.
     * @return array
     * @throws \Exception
     */
    public function request(string $method, string $url, array $queryParams = [], array $headers = []): array
    {
        $response = $this->httpClient->request($method, $url, [
            'headers' => $headers,
            'query' => $queryParams,
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Failed to fetch data from the API. Status Code: ' . $response->getStatusCode());
        }

        return $response->toArray();
    }
}
