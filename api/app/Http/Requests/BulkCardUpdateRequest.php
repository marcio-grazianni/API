<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkCardUpdateRequest extends FormRequest
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
            'cards' => 'array',
            'cards.*.id' => 'integer|required',
            'cards.*.title' => 'string',
            'cards.*.description' => 'string|nullable',
            'cards.*.column_id' => 'integer|exists:columns,id',
            'cards.*.order' => 'integer'
        ];
    }
}
