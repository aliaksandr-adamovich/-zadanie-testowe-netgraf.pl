<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PetRepository
{
    protected $baseUrl;
    protected $requestHeaders;

    public function __construct()
    {
        $this->baseUrl = config('pet.base_url') . '/v2';
        $this->requestHeaders = [
            'Accept' => 'application/json'
        ];
    }

    /**
     * Send an HTTP request.
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param bool $expectJsonResponse
     * @return Collection|Http\Response
     * @throws Exception
     */
    private function sendRequest($method, $uri, $data = [], $expectJsonResponse = true): Collection|Http\Response
    {
        try {
            $url = $this->baseUrl . $uri;

            $headers = $this->requestHeaders;

            $response = match ($method) {
                'get' => Http::withHeaders($headers)->get($url, $data['query'] ?? []),
                'post' => Http::withHeaders($headers)->post($url, $data),
                'put' => Http::withHeaders($headers)->put($url, $data),
                'delete' => Http::withHeaders($headers)->delete($url, $data),
                'postMultipart' => Http::withHeaders($headers)->asMultipart()->post($url, $data),

                default => throw new Exception("Unsupported HTTP method: {$method}"),
            };

            if ($response->failed()) {
                throw new Exception("HTTP request failed with status {$response->status()}");
            }


            return $expectJsonResponse ? collect($response->json()) : $response;
        } catch (Exception $e) {
            throw new Exception("An error occurred: " . $e->getMessage());
        }
    }

    /**
     * Find pets by statuses.
     *
     * @param array $statuses
     * @return Collection
     */
    public function findPetsByStatuses(array $statuses): Collection
    {
        $queryParams = ['status' => implode(',', $statuses)];
        $response = $this->sendRequest('get', "/pet/findByStatus", ['query' => $queryParams]);


        return $response;
    }

    /**
     * Add a new pet.
     *
     * @param array $data
     * @return Collection
     * @throws Exception
     */
    public function addPet(array $data): Collection
    {
        $response = $this->sendRequest('post', '/pet', $data);

        if (!$response->has('id')) {
            throw new Exception("Error creating pet");
        }
        return $response;
    }

    /**
     * Update an existing pet.
     *
     * @param int $id
     * @param array $data
     * @return Collection
     * @throws Exception
     */

    public function updatePet($id, array $data): Collection
    {
        $data['id'] = $id;
        $response = $this->sendRequest('put', "/pet", $data);

        if (!$response->has('code') || $response->get('code') !== 200) {
            throw new Exception("Error updating pet");
        }

        return $response;
    }


    public function getPet($id): Collection
    {
        return $this->sendRequest('get', "/pet/{$id}");
    }

    /**
     * Delete a pet by ID.
     *
     * @param int $id
     * @return Collection
     * @throws Exception
     */

    public function deletePet($id): Collection
    {
        $response = $this->sendRequest('delete', "/pet/{$id}");

        if (!$response->has('code') || $response->get('code') !== 200) {
            throw new Exception("Error deleting pet");
        }

        return $response;
    }

    /**
     * Add an image to a pet.
     *
     * @param int $petId
     * @param string $imagePath
     * @param string|null $additionalMetadata
     * @return Collection
     * @throws Exception
     */

    public function addPetImage($petId, $imagePath, $additionalMetadata = null): Collection
    {
        $multipart = [
            [
                'name' => 'file',
                'contents' => fopen($imagePath, 'r'),
                'filename' => basename($imagePath)
            ]
        ];

        if ($additionalMetadata) {
            $multipart[] = [
                'name' => 'additionalMetadata',
                'contents' => $additionalMetadata
            ];
        }

        return $this->sendRequest('postMultipart', "/pet/{$petId}/uploadImage", $multipart);
    }
}
