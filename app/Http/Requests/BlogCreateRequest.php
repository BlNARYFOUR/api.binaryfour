<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'location' => 'required|string',
            'duration' => 'required|numeric',
            'title' => 'required|string',
            'body' => 'required|string',
            'goal_audience' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tag' => 'numeric|nullable',
        ];
    }
}
