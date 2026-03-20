<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\Front\UserFrontRegisterFormRequest;
use Illuminate\Auth\Events\Registered;
use App\Events\UserRegistered;

class RegisterController extends Controller
{
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
    protected $redirectTo = '/home';
    protected $userTable = 'users';
    protected $redirectIfVerified = '/home';
    protected $redirectAfterVerification = '/verification-success';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError', 'notVerified']]);
    }

    public function showMemberRegistrationForm()
    {
        return view('auth.member_register');
    }

    public function register(UserFrontRegisterFormRequest $request)
    {
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->user_type = $request->input('user_type', User::TYPE_CANDIDATE);
        $parentOccupationId = $request->input('parent_occupation_id');
        $user->occupation_group_id = !empty($parentOccupationId) ? [(int) $parentOccupationId] : null;
        $user->is_active = 1;
        $user->verified = 1; // E-posta doğrulama DEVRE DIŞI

        // Handle Video Upload (Now optional during reg, will be mandatory on verification screen)
        if ($request->hasFile('video_file')) {
            $video = $request->file('video_file');
            $fileName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('uploads/videos'), $fileName);
            $user->video_link = $fileName;
        }

        $user->save();

        // Handle CV Upload (Now optional during reg, will be mandatory on verification screen)
        if ($request->hasFile('cv_file')) {
            $cv = $request->file('cv_file');
            $fileName = \App\Helpers\ImgUploader::UploadDoc('cvs', $cv, 'Varsayılan CV');

            $profileCv = new \App\ProfileCv();
            $profileCv->user_id = $user->id;
            $profileCv->title = 'Varsayılan CV';
            $profileCv->cv_file = $fileName;
            $profileCv->is_default = 1;
            $profileCv->save();
        }
        /*         * *********************** */
        $user->name = $user->getName();
        $user->update();
        /*         * *********************** */
        event(new Registered($user));
        event(new UserRegistered($user));
        $this->guard()->login($user);
        // E-posta doğrulama DEVRE DIŞI
        // UserVerification::generate($user);
        // UserVerification::send($user, 'E-posta Doğrulama', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    public function notVerified()
    {
        return view('vendor.laravel-user-verification.resend-user-verification');
    }



    protected function registered(Request $request, $user)
    {
        // Check for guest service request ID (New Flow)
        if (session()->has('guest_service_request_id')) {
            $requestId = session('guest_service_request_id');
            $serviceRequest = \App\ServiceRequest::find($requestId);

            if ($serviceRequest && $serviceRequest->user_id === null) {
                $serviceRequest->user_id = $user->id;
                $serviceRequest->save();

                session()->forget('guest_service_request_id');
                return redirect()->route('home-services.my-requests')->with('success', 'Kaydınız tamamlandı ve hizmet talebiniz hesabınıza eklendi!');
            }
        }

        // Fallback for old flow (just in case, though likely unused now)
        if (session()->has('pending_service_request')) {
            $data = session('pending_service_request');
            \App\Http\Controllers\HomeServiceController::createServiceRequestForUser($user, $data);
            session()->forget('pending_service_request');
            return redirect()->route('home-services.my-requests')->with('success', 'Kaydınız tamamlandı ve hizmet talebiniz oluşturuldu!');
        }

        // Force redirect to profile verification
        return redirect()->route('verify.profile');
    }
}
