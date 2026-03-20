<?php

namespace App\Http\Controllers;

use Auth;
use Config;
use App\Package;
use App\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\CompanyPackageTrait;
use App\Traits\JobSeekerPackageTrait;
use Razorpay\Api\Api as RazorpayApi;

class RazorpayOrderController extends Controller
{
    use CompanyPackageTrait;
    use JobSeekerPackageTrait;

    private $redirectTo = 'home';

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('company')->check()) {
                $this->redirectTo = 'company.home';
            }
            return $next($request);
        });
    }

    /**
     * Show Razorpay payment form.
     */
    public function razorpayOrderForm($id, $new_or_upgrade)
    {
        $package = Package::findOrFail($id);
        $siteSetting = SiteSetting::getPrimary();

        return view('order.pay_with_razorpay')
            ->with('package', $package)
            ->with('package_id', $id)
            ->with('new_or_upgrade', $new_or_upgrade)
            ->with('siteSetting', $siteSetting);
    }

    /**
     * Verify Razorpay payment and activate package.
     */
    public function razorpayOrderPackage(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'razorpay_payment_id' => 'required|string',
        ]);

        $package = Package::findOrFail($request->package_id);

        $key = Config::get('services.razorpay.key');
        $secret = Config::get('services.razorpay.secret');

        if (empty($key) || empty($secret)) {
            flash(__('Razorpay is not configured.'))->error();
            return Redirect::route($this->redirectTo);
        }

        try {
            $api = new RazorpayApi($key, $secret);
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if ($payment->status === 'captured' || $payment->status === 'authorized') {
                if (Auth::guard('company')->check()) {
                    $company = Auth::guard('company')->user();
                    if ($package->package_for == 'cv_search') {
                        $this->addCompanySearchPackage($company, $package, 'Razorpay');
                    } else {
                        $this->addCompanyPackage($company, $package, 'Razorpay');
                    }
                }
                if (Auth::check()) {
                    $user = Auth::user();
                    $this->addJobSeekerPackage($user, $package);
                }

                flash(__('You have successfully subscribed to selected package'))->success();
                return Redirect::route($this->redirectTo);
            }
        } catch (\Exception $e) {
            flash($e->getMessage() ?: __('Payment verification failed.'))->error();
            return Redirect::route($this->redirectTo);
        }

        flash(__('Package subscription failed'))->error();
        return Redirect::route($this->redirectTo);
    }

    /**
     * Verify Razorpay payment (alternative callback / API verification).
     */
    public function verifyRazorpayPayment(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'razorpay_payment_id' => 'required|string',
        ]);

        return $this->razorpayOrderPackage($request);
    }
}
