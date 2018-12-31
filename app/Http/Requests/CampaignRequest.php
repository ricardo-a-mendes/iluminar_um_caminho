<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (Auth::user() && Auth::user()->is_admin == 1);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $startsAt = $this->post('starts_at');

        return [
            'name' => [
                'required',
                'min:3',
            ],
            'description' => 'required',
            'starts_at' => 'required',
            'ends_at' => [
                'required',
                function ($attribute, $value, $fail) use ($startsAt) {
                    $startsAt = new Carbon($startsAt);
                    $endsAt = new Carbon($value);
                    if ($startsAt->getTimestamp() > $endsAt->getTimestamp()) {
                        $fail('Data de encerramento deve ser maior do que a data de início.');
                    }
                },
            ],
            'suggested_donation' => 'required',
            'target_amount' => 'required',
        ];
    }
}
