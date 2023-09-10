<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseRequest extends FormRequest
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
            'house_id' => 'required|exists:houses,id',
            'house_state' => 'required|exists:states,id',
            'floors.*.id' => 'required|exists:floors,id',
            'floors.*.apartments_no' => 'required|numeric|min:0|max:4',
            'floors.*.entrances' => 'required|numeric|min:0|max:4',
        ];
    }

    public function messages()
    {
        return [
            'state.required' => 'House state is required'
        ];
    }
}
