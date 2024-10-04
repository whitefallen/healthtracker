<?php

namespace App\ApiClient\Api\Oura;

use App\ApiClient\Client;

class OuraClient
{
    private const BASE_URL_V2 = 'https://api.ouraring.com/v2/usercollection';
    private Client $apiClient;
    private string $accessToken;

    /**
     * OuraApiClient constructor.
     *
     * @param Client $apiClient
     * @param string $accessToken
     */
    public function __construct(Client $apiClient, string $accessToken)
    {
        $this->apiClient = $apiClient;
        $this->accessToken = $accessToken;
    }

    /**
     * Fetch user profile information.
     *
     * @return array
     * @throws \Exception
     */
    public function getUserInfo(): array
    {
        return $this->apiClient->request('GET', self::BASE_URL_V2 . '/personal_info', [], $this->getAuthorizationHeaders());
    }

    /**
     * Fetch sleep data from Oura.
     *
     * @param string|null $start The start date for sleep data (e.g., '2023-01-01').
     * @param string|null $end The end date for sleep data (e.g., '2023-01-31').
     * @return array
     * @throws \Exception
     */
    public function getSleepData(?string $start = null, ?string $end = null): array
    {
        $queryParams = $this->buildQueryParams($start, $end);
        return $this->apiClient->request('GET', self::BASE_URL_V2 . '/sleep', $queryParams, $this->getAuthorizationHeaders());
    }

    /**
     * Fetch activity data from Oura.
     *
     * @param string|null $start The start date for activity data.
     * @param string|null $end The end date for activity data.
     * @return array
     * @throws \Exception
     */
    public function getActivityData(?string $start = null, ?string $end = null): array
    {
        $queryParams = $this->buildQueryParams($start, $end);
        return $this->apiClient->request('GET', self::BASE_URL_V2 . '/activity', $queryParams, $this->getAuthorizationHeaders());
    }

    /**
     * Fetch readiness data from Oura.
     *
     * @param string|null $start The start date for readiness data.
     * @param string|null $end The end date for readiness data.
     * @return array
     * @throws \Exception
     */
    public function getReadinessData(?string $start = null, ?string $end = null): array
    {
        $queryParams = $this->buildQueryParams($start, $end);
        return $this->apiClient->request('GET', self::BASE_URL_V2 . '/readiness', $queryParams, $this->getAuthorizationHeaders());
    }

    /**
     * Build query parameters for start and end dates.
     *
     * @param string|null $start
     * @param string|null $end
     * @return array
     */
    private function buildQueryParams(?string $start, ?string $end): array
    {
        $queryParams = [];

        if ($start) {
            $queryParams['start_date'] = $start;
        }

        if ($end) {
            $queryParams['end_date'] = $end;
        }

        return $queryParams;
    }

    /**
     * Get the authorization headers with the access token.
     *
     * @return array
     */
    private function getAuthorizationHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
        ];
    }
}
