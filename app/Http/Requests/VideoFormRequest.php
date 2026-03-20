<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VideoFormRequest extends Request
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
                    $video_unique = '';
                    if ($id > 0) {
                        $video_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "",
                        "lang" => "required",
                        "video_title" => "required|unique:videos$video_unique",
                        "video_text" => "required",
                        "video_link" => "required",
                        "is_default" => "required",
                        "video_id" => "required_if:is_default,0",
                        "is_active" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'lang.required' => 'Lütfen dil seçin.', 'video.required' => 'Video zorunludur.', 'is_default.required' => 'Bu Video varsayılan mı?', 'video_id.required_if' => 'Lütfen varsayılan/yedek Video seçin.', 'is_active.required' => 'Bu Video aktif mi?',
        ];
    }

}
