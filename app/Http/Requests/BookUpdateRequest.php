<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:author,id',
            'publisher_id' => 'required|exists:publisher,id',
            'isbn' => 'required|integer|max:20',
            'publication_year' => 'required|integer',
            'stock' => 'required|integer',
        ];
    }
}
