<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SeoFormRequest extends Request
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
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keywords' => 'required',
            'page_title' => 'required|unique:seo,page_title,' . $this->route('id') . ',id',
            'slug' => 'nullable|unique:seo,slug,' . $this->route('id') . ',id',
        ];
    }

    public function messages()
    {
        return [
            'seo_title.required' => 'Please enter SEO title.',
            'seo_description.required' => 'Please enter SEO description.',
            'seo_keywords.required' => 'Please enter SEO keywords.',
        ];
    }

}
