<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
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
        $validation = [
            'name' => [
                'required',
                function($attribute, $value, $fail) {
                    $wordCount = explode(' ', $value);

                    if (count($wordCount) < 2) {
                        $fail('Por favor informe seu nome completo.');
                    }
                }
            ],
            'cpf' => 'required',

            'street_number' => 'required',
            'street_name' => 'required',
            'district' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'complement' => 'required',

            'area_code' => 'required',
            'phone_number' => 'required',
        ];

        if ($this->has('password') && $this->post('password') > 0) {
            $validation['password'] = 'confirmed|min:6';
        }

        return $validation;
    }
}
