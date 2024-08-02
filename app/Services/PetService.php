<?php

namespace App\Services;

use App\Repositories\PetRepository;
use Exception;
use Illuminate\Support\Collection;

class PetService
{
    protected $petRepository;

    public function __construct(PetRepository $petRepository)
    {
        $this->petRepository = $petRepository;
    }


    /**
     * Find pets by statuses.
     *
     * @param array $statuses
     * @return Collection
     */
    public function findPetsByStatuses(array $statuses)
    {
        return $this->petRepository->findPetsByStatuses($statuses);
    }

    /**
     * Get a pet by ID.
     *
     * @param int $id
     * @return array
     */
    public function getPet($id)
    {
        return $this->handleResponse($this->petRepository->getPet($id), null, 'Pet not found');
    }

    /**
     * Add a new pet.
     *
     * @param array $data
     * @return array
     */
    public function addPet(array $data)
    {
        try {
            $response = $this->petRepository->addPet($data);
            return $this->handleResponse($response, 'Pet created successfully', 'Error creating pet');
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Update an existing pet.
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function updatePet($id, array $data)
    {
        try {
            $response = $this->petRepository->updatePet($id, $data);
            return $this->handleResponse($response, 'Pet updated successfully', 'Error updating pet');
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Add an image to a pet.
     *
     * @param int $petId
     * @param string $imagePath
     * @param string|null $additionalMetadata
     * @return array
     */
    public function addPetImage($petId, $imagePath, $additionalMetadata = null): Collection
    {
        try {
            $response = $this->petRepository->addPetImage($petId, $imagePath, $additionalMetadata);
            return $this->handleResponse($response, 'Image uploaded successfully', 'Error uploading image');
        } catch (Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete a pet by ID.
     *
     * @param int $id
     * @return array
     */
    public function deletePet($id)
    {
        return $this->handleResponse($this->petRepository->deletePet($id), 'Pet deleted successfully', 'Error deleting pet');
    }

    /**
     * Handle API response.
     *
     * @param Collection $response
     * @param string|null $successMessage
     * @param string $errorMessage
     * @return array
     */
    protected function handleResponse($response, $successMessage = null, $errorMessage = 'An error occurred')
    {
        if (isset($response['code']) && $response['code'] >= 400) {
            return ['error' => true, 'message' => $response['message'] ?? $errorMessage];
        }
        if ($successMessage) {
            return ['success' => true, 'message' => $successMessage, 'data' => $response];
        }
        return $response;
    }


}
