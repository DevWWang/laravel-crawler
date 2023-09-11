<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreURLRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "url" => [
                "required",
                "url",
                Rule::unique("url_requests")->where(function ($query) {
                    return $query->where("status_code", Response::HTTP_OK);
                })
            ]
        ];
    }

    /**
     * Custom message for validation
     * 
     * @return  array
     */
    public function messages()
    {
        return [
            "url.required" => "The url field is required.",
            "url.unique" => "Request to crawl the given url is already processed. Please refer to the history.",
        ];
    }
}
