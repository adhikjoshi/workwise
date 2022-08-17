<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticalRequest extends FormRequest
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
        //Update Article PUT and PATCH rule
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'name' => ['required','min:5'],
                'author' => ['required','min:5'],
                'content' => ['required','min:100'],
                'publication_date' => ['required','date_format:Y-m-d H:i:s'],
            ];
        } else {
            return [
                'name' => ['sometimes','min:5'],
                'tags' => ['sometimes','min:2'],
                'author' => ['sometimes','min:5'],
                'content' => ['sometimes','min:100'],
                'publication_date' => ['sometimes','date_format:Y-m-d H:i:s'],
            ];
        }
        
        
    }
}
