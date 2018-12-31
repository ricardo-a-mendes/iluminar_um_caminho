<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::user()->registration_completed == 1);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'creditCardToken' => 'required',
            'campaign_id' => 'required|exists:campaigns,id',
            'campaign_name' => 'required',
            'donationAmount' => 'required',
            'creditCardHolderName' => 'required',
            'creditCardHolderCPF' => 'required',
        ];
    }
}
