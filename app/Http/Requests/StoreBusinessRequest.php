<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
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
            // Bussiness
            'name'              => 'required',
            'image_url'         => 'required',
            'open_time'         => 'required',
            'close_time'        => 'required',
            'url'               => 'required',
            'latitude'          => 'required',
            'longitude'         => 'required',
            'price'             => 'required',
            'phone'             => 'required',
            'display_phone'     => 'required',
            'transaction'       => 'required',
            
            // Bussiness Location
            'address1'          => 'sometimes',
            'address2'          => 'sometimes',
            'address3'          => 'sometimes',
            'city'              => 'required',
            'zip_code'          => 'required',
            'country'           => 'required',
            'state'             => 'required',
            'display_address'   => 'required|array',
            'display_address.*' => 'required',

            // Bussiness Category
            'business_category' => 'required|array',
            'business_category.*' => 'required'

        ];
    }
}
