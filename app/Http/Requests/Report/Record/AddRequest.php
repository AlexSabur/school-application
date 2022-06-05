<?php

namespace App\Http\Requests\Report\Record;

use App\Models\Student\Classroom;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $classroom = $this->route('classroom', new Classroom);
        //
        // if ($classroom->exisst) {
        // # code...
        // }

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
            //
        ];
    }
}
