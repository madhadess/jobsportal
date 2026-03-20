<?php

namespace App\Http\Controllers\Company\Auth;

use Auth;
use App\Company;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\Front\CompanyFrontRegisterFormRequest;
use Illuminate\Auth\Events\Registered;
use App\Events\CompanyRegistered;
use Illuminate\Support\Str;
use App\SiteSetting;
use App\Package;
use App\Traits\CompanyPackageTrait;

class RegisterController extends Controller
{
    use CompanyPackageTrait;
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/company-home';
    protected $userTable = 'companies';
    protected $redirectIfVerified = '/company-home';
    protected $redirectAfterVerification = '/verification-success?role=company';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company.guest');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
    }

    public function register(CompanyFrontRegisterFormRequest $request)
    {
        $settings = SiteSetting::getPrimary();
        $company = new Company();
        $company->name = $request->input('name');
        $company->email = $request->input('email');
        $company->password = bcrypt($request->input('password'));
        if ($settings->auto_approval_company == 1) {
            $company->is_active = 1;
        } else {
            $company->is_active = 0;
        }

        $company->verified = 1; // E-posta doğrulama DEVRE DIŞI
        $company->save();
        /*         * ******************** */
        $company->slug = Str::slug($company->name, '-') . '-' . $company->id;
        $company->update();
        /*         * ******************** */

        // Assign Free Package (ID: 7 or dynamic)
        $freePackage = Package::where('package_title', 'Ücretsiz Paket')->first();
        if ($freePackage) {
            $this->addCompanyPackage($company, $freePackage, 'Free');
        }

        event(new Registered($company));
        event(new CompanyRegistered($company));
        $this->guard()->login($company);
        // E-posta doğrulama DEVRE DIŞI
        // UserVerification::generate($company);
        // UserVerification::send($company, 'Şirket E-posta Doğrulama', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        return $this->registered($request, $company) ?: redirect($this->redirectPath());
    }

}
