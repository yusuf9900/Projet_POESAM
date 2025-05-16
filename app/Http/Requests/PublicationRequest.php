<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicationRequest extends FormRequest
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
            'titre' => 'required|max:50',
            'contenu' => 'required',
            'categorie' => 'nullable|max:50',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240',
            'est_anonyme' => 'nullable|boolean',
        ];
    }
}
