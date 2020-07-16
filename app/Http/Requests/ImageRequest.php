<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'group_id' => 'integer',
            'group_task_id' => 'integer',
            'ext' => 'string|max:255',
            'path' => 'string|max:255',
            'mime' => 'string|max:255',
        ];
    }
}
