<?php

namespace App\Http\Requests\Report\Record;

use App\Models\Report\Violation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'message' => [
                'nullable',
                'string',
                'max:255',
            ],
            'violation_id' => [
                'required',
                Rule::exists(Violation::class, 'id'),
            ],
        ];
    }
}
