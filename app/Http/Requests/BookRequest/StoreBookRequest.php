<?php

namespace App\Http\Requests\BookRequest;


class StoreBookRequest extends BookServiceRequest
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
