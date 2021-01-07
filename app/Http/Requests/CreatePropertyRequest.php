<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property_type_id' => 'required',
            'county' => 'required|max:255',
            'country' => 'required|max:255',
            'town' => 'required|max:255',
            'description' => 'required|min:20',
            'address' => 'required|max:255|min:10',
            'num_bedrooms' => 'required',
            'num_bathrooms' => 'required',
            'price' => 'required|regex:/^([0-9]+)$/',
            'type' => 'required',
            'image' => 'mimes:jpeg,jpg|max:1000000'
        ];
    }
}
