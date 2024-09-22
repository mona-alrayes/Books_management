<?php

namespace App\Http\Requests\BookRequest;
use Illuminate\Foundation\Http\FormRequest;


class StoreBookRequest extends FormRequest
{
    /**
     * Additional or overridden rules for storing a book.
     */
    public function rules(): array
    {
        $rules = parent::rules();
        return $rules;
    }
}
