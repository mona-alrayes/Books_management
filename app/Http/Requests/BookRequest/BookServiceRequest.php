<?php

namespace App\Http\Requests\BookRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Common validation rules.
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['string', 'min:3', 'max:255'],
            'author' => ['string', 'min:3', 'max:255'],
            'published_at' => ['date_format:d-m-Y'],
            'is_active' => ['boolean'],
        ];

        if ($this->isMethod('post')) {
            // Required for store request
            $rules['title'][] = 'required';
            $rules['author'][] = 'required';
            $rules['published_at'][] = 'required';
            $rules['is_active'][] = 'required';
        } else if ($this->isMethod('put')) {
            // Allow optional fields for update request
            $rules['title'][] = 'sometimes';
            $rules['author'][] = 'sometimes';
            $rules['published_at'][] = 'sometimes';
            $rules['is_active'][] = 'sometimes';
        }

        return $rules;
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب',
            'string' => 'حقل :attribute يجب أن يكون نصًا وليس أي نوع آخر',
            'max' => 'عدد محارف :attribute لا يجب أن يتجاوز 255 محرفًا',
            'min' => 'حقل :attribute يجب أن يكون 3 محارف على الأقل',
            'date_format' => 'حقل :attribute يجب أن يكون بصيغة تاريخ صحيحة مثل :format',
            'boolean' => 'حقل :attribute يجب ان يكون اما نشط او غير نشط'
        ];
    }

    /**
     * Custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'title' => 'العنوان',
            'author' => 'المؤلف',
            'published_at' => 'تاريخ النشر',
            'is_active' => 'حالة الكتاب',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => ucwords(strtolower($this->input('title'))),
            'author' => ucwords(strtolower($this->input('author'))),
            'is_active' => $this->input('is_active') === 'نشط' ? 1 : ($this->input('is_active') === 'غير نشط' ? 0 : $this->input('is_active')),
        ]);
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'خطأ',
            'message' => 'فشلت عملية التحقق من صحة البيانات.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
