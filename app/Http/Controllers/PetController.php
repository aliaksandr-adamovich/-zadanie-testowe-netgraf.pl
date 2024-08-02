<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePetRequest;
use App\Http\Requests\PetImageRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Services\PetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetController extends Controller
{
    protected $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request) : View
    {
        $statuses = ['all', 'available', 'pending', 'sold'];
        $selectedStatus = $request->input('status', 'all');

        if ($selectedStatus === 'all') {
            $pets = $this->petService->findPetsByStatuses(['available', 'pending', 'sold']);
        } else {
            $pets = $this->petService->findPetsByStatuses([$selectedStatus]);
        }


        return view('pets.index', compact('pets', 'statuses', 'selectedStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create() : View
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePetRequest $request
     * @return RedirectResponse
     */
    public function store(CreatePetRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $response = $this->petService->addPet($data);

        if (isset($response['error'])) {
            return redirect()->route('pets.index', ['status' => $request->input('status', 'all')])->withErrors(['msg' => $response['message']]);
        }

        return redirect()->route('pets.index', ['status' => $request->input('status', 'all')])->with('success', 'Pet created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePetRequest $request
     * @param int $id
     * @return RedirectResponse
     */

    public function update(UpdatePetRequest $request, $id): RedirectResponse
    {
        $data = $request->validated();

        $response = $this->petService->updatePet($id, $data);

        if (isset($response['error'])) {
            return redirect()->route('pets.index', ['status' => $request->input('status', 'all')])->withErrors(['msg' => $response['message']]);
        }

        return redirect()->route('pets.index', ['status' => $request->input('status', 'all')])->with('success', 'Pet updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */

    public function show($id):View
    {
        $response = $this->petService->getPet($id);

        if (isset($response['error'])) {
            abort(404, 'Pet not found');
        }

        return view('pets.show', ['pet' => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $response = $this->petService->getPet($id);

        if (isset($response['error'])) {
            abort(404, 'Pet not found');
        }

        return view('pets.edit', ['pet' => $response]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $response = $this->petService->deletePet($id);

        if (isset($response['error'])) {
            return redirect()->route('pets.index', ['status' => request()->status])->withErrors(['msg' => $response['message']]);
        }

        return redirect()->route('pets.index', ['status' => request()->status])->with('success', 'Pet deleted successfully');
    }

    /**
     * Upload an image for the specified pet.
     *
     * @param PetImageRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function uploadImage(PetImageRequest $request, $id): RedirectResponse
    {
        $imagePath = $request->file('file')->path();
        $additionalMetadata = $request->input('additionalMetadata');

        $response = $this->petService->addPetImage($id, $imagePath, $additionalMetadata);
        if (isset($response['error'])) {
            return redirect()->route('pets.show', $id)->withErrors(['msg' => $response['message']]);
        }

        return redirect()->route('pets.show', $id)->with('success', 'Image uploaded successfully');
    }

}
