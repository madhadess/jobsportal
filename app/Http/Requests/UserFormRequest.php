<?php

namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class UserFormRequest extends Request
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
        $id = (int) $this->input('id', 0);
        $password = 'required|min:6';
        $id_str = '';
        if ($id > 0) {
            $id_str = ',' . $id;
            $password = '';
        }
        return [
            'first_name' => 'required',
            //'middle_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email' . $id_str . '|email',
            'password' => $password,
           // 'father_name' => 'required',
            'date_of_birth' => 'required',
           // 'gender_id' => 'required',
            //'marital_status_id' => 'required',
            'nationality_id' => 'required',
            //'national_id_card_number' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'phone' => 'required',
           // 'mobile_num' => 'required',
           // 'job_experience_id' => 'required',
           // 'career_level_id' => 'required',
            'industry_id' => 'required',
            'functional_area_id' => 'required',
           // 'current_salary' => 'required',
            //'expected_salary' => 'required',
            //'salary_currency' => 'required',
            'street_address' => 'required',
            'image' => 'image',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Ad zorunludur',
            //'middle_name.required' => 'Middle Name is required',
            'last_name.required' => 'Soyad zorunludur',
            'email.required' => 'E-posta zorunludur',
            'email.email' => 'E-posta geçerli bir e-posta adresi olmalıdır.',
            'email.unique' => 'Bu E-posta zaten alınmış.',
            'password.required' => 'Şifre zorunludur',
            'password.min' => 'Şifre en az 6 karakter uzunluğunda olmalıdır.',
            //'father_name.required' => 'Father Name is required',
            'date_of_birth.required' => 'Doğum tarihi zorunludur',
            //'gender_id.required' => 'Please select gender',
            //'marital_status_id.required' => 'Please select marital status',
            'nationality_id.required' => 'Lütfen uyruk seçin',
            //'national_id_card_number.required' => 'national ID card# required',
            'country_id.required' => 'Lütfen ülke seçin',
            'state_id.required' => 'Lütfen eyalet seçin',
            'city_id.required' => 'Lütfen şehir seçin',
            'phone.required' => 'Lütfen telefon girin',
           // 'mobile_num.required' => 'Please enter mobile number',
            //'job_experience_id.required' => 'Please select experience',
            //'career_level_id.required' => 'Please select career level',
            'industry_id.required' => 'Lütfen sektör seçin',
            'functional_area_id.required' => 'Lütfen fonksiyonel alan seçin',
            //'current_salary.required' => 'Please enter current salary',
            //'expected_salary.required' => 'Please enter expected salary',
            //'salary_currency.required' => 'Please select salary currency',
            'street_address.required' => 'Lütfen cadde adresi girin',
            'image.image' => 'Sadece resim dosyaları yüklenebilir.',
        ];
    }

}
