<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TestimonialFormRequest extends Request
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
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);
                    $testimonial_unique = '';
                    if ($id > 0) {
                        $testimonial_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "",
                        "lang" => "required",
                        "testimonial_by" => "required",
                        "testimonial" => "required",
                        "company" => "required",
                        "is_default" => "required",
                        "testimonial_id" => "required_if:is_default,0",
                        "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Lütfen dil seçin.',
            'testimonial_by.required' => 'Referans veren zorunludur.',
            'testimonial.required' => 'Referans metni zorunludur.',
            'company.required' => 'Şirket zorunludur.',
            'is_default.required' => 'Bu Referans varsayılan mı?',
            'testimonial_id.required_if' => 'Lütfen varsayılan/yedek Referans seçin.',
            'is_active.required' => 'Bu Referans aktif mi?',
        ];
    }

}
