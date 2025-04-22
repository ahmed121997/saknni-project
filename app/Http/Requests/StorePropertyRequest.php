<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
            'type_property_id'=> 'required|numeric',
            'list_section'=> 'required|string',
            'area'=> 'required|numeric|min:40|max:5000',
            'city_id' =>'required|numeric',
            'num_bathroom'=>'required|numeric|min:1|max:50',
            'num_rooms'=>'required|numeric|min:1|max:100',
            'list_view_id'=>'required|numeric',
            'num_floor'=> 'required|numeric|min:0|max:100',
            'type_finish_id'=> 'required|numeric',
            'location'=> 'required|string',
            'type_payment_id'=>'required|numeric',
            'price'=>'required|numeric',
            'link_youtube'=>'required',
            'title'=>'required:string|max:255',
            'details'=>'required:string',
        ];
    }
}
