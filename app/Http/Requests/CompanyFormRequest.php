<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CompanyFormRequest extends Request
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
                    $unique_id = ($id > 0) ? ',' . $id : '';
                    $password = ($id > 0) ? "" : "required";
                    $logo = ($id > 0) ? "" : ""; // Logo geçici olarak zorunlu değil
                    return [
                        "id" => "",
                        "name" => "required",
                        "email" => "required",
                        "password" => $password,
                        //"ceo" => "required",
                        "industry_id" => "required",
                        "ownership_type_id" => "required",
                        "description" => "required",
                        "location" => "required",
                        //"map" => "required",
                        "no_of_offices" => "required",
                        "website" => "required|url",
                        "no_of_employees" => "required",
                        "established_in" => "required",
                        //"fax" => "required",
                        //"phone" => "required",
                        "logo" => $logo,
                        "country_id" => "required",
                        "state_id" => "required",
                        "city_id" => "required",
                        "is_active" => "required",
                        "is_featured" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Şirket Adı zorunludur',
            'email.required' => 'Şirket E-postası zorunludur',
            'password.required' => 'Şifre zorunludur',
            //'ceo.required' => 'Company\'s CEO name is required',
            'industry_id.required' => 'Lütfen sektör seçin',
            'ownership_type_id.required' => 'Lütfen mülkiyet tipi seçin',
            'description.required' => 'Şirket detayları zorunludur',
            'location.required' => 'Şirket konumu zorunludur',
            'map.required' => 'Şirket Google Harita konumu zorunludur',
            'no_of_offices.required' => 'Ofis sayısı zorunludur',
            'website.required' => 'Şirket web sitesi zorunludur',
            'website.url' => 'Şirket web sitesinin tam URL adresi zorunludur',
            'no_of_employees.required' => 'Çalışan sayısı zorunludur',
            'established_in.required' => 'Şirketin kuruluş yılı zorunludur',
            //'fax.required' => 'Fax number required',
            //'phone.required' => 'Phone number required',
            'logo.required' => 'Şirket logosu zorunludur',
            'country_id.required' => 'Lütfen ülke seçin',
            'state_id.required' => 'Lütfen eyalet seçin',
            'city_id.required' => 'Lütfen şehir seçin',
            'is_active.required' => 'Bu şirket aktif mi?',
            'is_featured.required' => 'Bu şirket öne çıkan mı?',
        ];
    }

}
