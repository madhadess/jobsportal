<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StateFormRequest extends Request
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
                    $state_unique = '';
                    if ($id > 0) {
                        $state_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "", "lang" => "required", "country_id" => "required", "state" => "required", "is_default" => "required", "state_id" => "required_if:is_default,0", "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Lütfen dil seçin.', 'country_id.required' => 'Lütfen ülke seçin.', 'state.required' => 'Lütfen Eyalet Adı girin.', 'is_default.required' => 'Bu eyalet varsayılan/yedek mi?', 'state_id.required_if' => 'Lütfen varsayılan/yedek Eyalet seçin.', 'is_active.required' => 'Bu Eyalet aktif mi?',
        ];
    }

}
