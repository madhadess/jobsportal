<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileSkillFormRequest extends Request
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                return [
                    "skill_name" => "required|string|max:255",
                    "job_skill_id" => "nullable",
                    "job_experience_id" => "nullable",
                ];
            }
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'skill_name.required' => 'Lütfen bir yetenek adı girin.',
        ];
    }

}
