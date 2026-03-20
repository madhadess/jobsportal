<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use Input;
use Config;
use App\Package;
use App\User;
use Carbon\Carbon;
use App\SiteSetting;
use Cake\Chronos\Chronos;
use App\Traits\CompanyPackageTrait;
use App\Traits\JobSeekerPackageTrait;
/** All Paypal Details class * */
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{

    use CompanyPackageTrait;
    use JobSeekerPackageTrait;

    private $_api_context;
    private $clientId;
    private $secret;
    private $paypal_url;
    private $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** setup PayPal api context * */
        $paypal_conf = Config::get('paypal');
        $settings = SiteSetting::getPrimary();
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->clientId = $settings->paypal_client_id;
        $this->secret = $settings->paypal_secret;
        if ($settings->paypal_live_sandbox == 'sandbox') {
            $this->paypal_url = 'https://api.sandbox.paypal.com';
        } else {
            $this->paypal_url = 'https://api.paypal.com';
        }
        // dd($this->_api_context);
        $this->_api_context->setConfig($paypal_conf['settings']);

        /*         * ****************************************** */
        $this->middleware(function ($request, $next) {
            if (Auth::guard('company')->check()) {
                $this->redirectTo = 'company.home';
            }
            return $next($request);
        });
        /*         * ****************************************** */
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function orderPackage(Request $request, $package_id)
    {
        $package = Package::findOrFail($package_id);
        $siteSetting = SiteSetting::getPrimary();

        return view('order.checkout_selection', compact('package', 'siteSetting'));
    }


    public function orderUpgradePackage(Request $request, $package_id)
    {
        $package = Package::findOrFail($package_id);
        $siteSetting = SiteSetting::getPrimary();

        return view('order.checkout_selection', compact('package', 'siteSetting'));
    }

    public function getUpgradePaymentStatus(Request $request, $package_id)
    {

        $package = Package::findOrFail($package_id);

        /** Get the payment ID before session clear * */
        $payment_id = $request->get('paymentId'); //Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            flash(__('Subscription failed'));
            return Redirect::route($this->redirectTo);
        }


        $accessToken = $this->getAccessToken();

        $paymentId = $request->input('paymentId');
        $token = $request->input('token');
        $payerId = $request->input('PayerID');

        if (empty($paymentId) || empty($token) || empty($payerId)) {
            // Handle invalid or missing parameters
            flash(__('Subscription failed'));
            return Redirect::route($this->redirectTo);
        }

        // Get access token
        $accessToken = $this->getAccessToken();

        $data = array(
            'payer_id' => $payerId
        );

        $payload = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->paypal_url/v1/payments/payment/{$paymentId}/execute",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accessToken",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseData = json_decode($response, true);

            // Check if execution was successful
            if (isset($responseData['state']) && $responseData['state'] === 'approved') {
                if (Auth::guard('company')->check()) {
                    $company = Auth::guard('company')->user();
                    if ($package->package_for == 'cv_search') {
                        $this->updateCompanySearchPackage($company, $package);
                    } elseif ($package->package_for == 'featured_job') {
                        $this->updateCompanyFeaturedJobPackage($company, $package);
                    } else {
                        $this->updateCompanyPackage($company, $package);
                    }

                }
                if (Auth::check()) {
                    $user = Auth::user();
                    $this->updateJobSeekerPackage($user, $package);
                }

                flash(__('You have successfully subscribed to selected package'))->success();
                return Redirect::route($this->redirectTo);
            } else {
                flash(__('Subscription failed'));
                return Redirect::route($this->redirectTo);
            }
        }
    }

    public function getPaymentStatus(Request $request, $package_id)
    {
        $package = Package::findOrFail($package_id);
        /*         * ******************************************* */

        /** Get the payment ID before session clear * */
        $payment_id = $request->get('paymentId'); //Session::get('paypal_payment_id');
        /** clear the session payment ID * */
        Session::forget('paypal_payment_id');
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            flash(__('Subscription failed'));
            return Redirect::route($this->redirectTo);
        }



        $accessToken = $this->getAccessToken();

        $paymentId = $request->input('paymentId');
        $token = $request->input('token');
        $payerId = $request->input('PayerID');

        if (empty($paymentId) || empty($token) || empty($payerId)) {
            // Handle invalid or missing parameters
            flash(__('Subscription failed'));
            return Redirect::route($this->redirectTo);
        }

        // Get access token
        $accessToken = $this->getAccessToken();

        $data = array(
            'payer_id' => $payerId
        );

        $payload = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "$this->paypal_url/v1/payments/payment/{$paymentId}/execute",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accessToken",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $responseData = json_decode($response, true);

            // Check if execution was successful
            if (isset($responseData['state']) && $responseData['state'] === 'approved') {

                /** it's all right * */
                /** Here Write your database logic like that insert record or value in database if you want * */
                if (Auth::guard('company')->check()) {
                    $company = Auth::guard('company')->user();
                    if ($package->package_for == 'cv_search') {
                        $this->addCompanySearchPackage($company, $package, 'Paypal');
                    } elseif ($package->package_for == 'featured_job') {
                        $this->addCompanyFeaturedJobPackage($company, $package, 'Paypal');
                    } else {
                        $this->addCompanyPackage($company, $package, 'Paypal');
                    }

                }
                if (Auth::check()) {
                    $user = Auth::user();
                    $this->addJobSeekerPackage($user, $package);
                }

                flash(__('You have successfully subscribed to selected package'))->success();
                return Redirect::route($this->redirectTo);

            } else {
                flash(__('Subscription failed'));
                return Redirect::route($this->redirectTo);
            }
        }
        flash(__('Subscription failed'));
        return Redirect::route($this->redirectTo);
    }

    public function orderFreePackage(Request $request, $package_id)
    {
        $package = Package::findOrFail($package_id);
        /*         * ******************************************* */
        /** it's all right * */
        /** Here Write your database logic like that insert record or value in database if you want * */
        if (Auth::guard('company')->check()) {
            $company = Auth::guard('company')->user();
            if ($package->package_for == 'cv_search') {
                $this->addCompanySearchPackage($company, $package, 'Paypal');
            } elseif ($package->package_for == 'featured_job') {
                $this->addCompanyFeaturedJobPackage($company, $package, 'Paypal');
            } else {
                $this->addCompanyPackage($company, $package, 'Paypal');
            }
        }
        if (Auth::check()) {
            $user = Auth::user();
            $this->addJobSeekerPackage($user, $package);
        }

        flash(__('You have successfully subscribed to selected package'))->success();
        return Redirect::route($this->redirectTo);
    }

}
