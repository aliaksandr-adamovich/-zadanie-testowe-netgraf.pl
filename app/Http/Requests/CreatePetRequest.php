<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'id' => 'required|integer',
            'category' => 'required|array',
            'category.id' => 'required|integer',
            'category.name' => 'required|string',
            'name' => 'required|string',
            'photoUrls' => 'required|array',
            'photoUrls.*' => 'required|string',
            'tags' => 'required|array',
            'tags.*.id' => 'required|integer',
            'tags.*.name' => 'required|string',
            'status' => 'required|string|in:available,pending,sold',
        ];
    }
}
