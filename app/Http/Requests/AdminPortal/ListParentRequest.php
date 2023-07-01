<?php

namespace App\Http\Requests\AdminPortal;

use App\Enums\AResponses;
use App\Enums\Currencies;
use App\Enums\DataProviders;
use App\Enums\DataProviderStatuses;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListParentRequest extends FormRequest
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
            'provider' => 'nullable|string|in:' . DataProviders::DATA_PROVIDER_X . ',' .DataProviders::DATA_PROVIDER_Y,
            'statusCode' => 'nullable|string|in:' . DataProviderStatuses::AUTHORIZED . ','. DataProviderStatuses::DECLINE . ',' . DataProviderStatuses::REFUNDED,
            'balanceMax' => 'numeric|min:1',
            'balanceMin' => 'numeric|min:0',
            'offset' => 'required|integer|min:0',
            'limit' => 'required|integer|min:10|max:50',
            'currency' => 'nullable|in:' . Currencies::USD . ',' . Currencies::AED
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' =>$validator->errors()->first(),
            'data' => null,
        ], AResponses::VALIDATION_ERR));
    }
}
