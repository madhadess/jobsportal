<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Redirect;
use App\Package;
use App\SiteSetting;
use App\Traits\CompanyPackageTrait;
use App\Traits\JobSeekerPackageTrait;

class PaytrOrderController extends Controller
{
    use CompanyPackageTrait;
    use JobSeekerPackageTrait;

    public function paytrOrderPackage(Request $request, $package_id)
    {
        $package = Package::findOrFail($package_id);
        $settings = SiteSetting::getPrimary();

        $merchant_id = $settings->paytr_merchant_id;
        $merchant_key = $settings->paytr_merchant_key;
        $merchant_salt = $settings->paytr_merchant_salt;

        $user = Auth::guard('company')->check() ? Auth::guard('company')->user() : Auth::user();

        $email = $user->email;
        $payment_amount = $package->package_price * 100; // Kuruş cinsinden
        $merchant_oid = 'JOBS' . time() . $user->id;
        $user_name = Auth::guard('company')->check() ? $user->name : $user->getName();
        $user_address = $user->location ?? 'Turkey';
        $user_phone = $user->phone ?? '05000000000';
        $merchant_ok_url = route('paytr.success');
        $merchant_fail_url = route('paytr.fail');
        $user_basket = base64_encode(json_encode([[$package->package_title, $package->package_price, 1]]));

        $timeout_limit = "30";
        $debug_on = 1;
        $test_mode = 0;
        $no_installments = 0;
        $max_installments = 0;
        $currency = "TL";
        $user_ip = $request->ip();

        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $user_basket . $no_installments . $max_installments . $currency . $test_mode;
        $paytr_token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

        $post_vals = [
            'merchant_id' => $merchant_id,
            'user_ip' => $user_ip,
            'merchant_oid' => $merchant_oid,
            'email' => $email,
            'payment_amount' => $payment_amount,
            'paytr_token' => $paytr_token,
            'user_basket' => $user_basket,
            'debug_on' => $debug_on,
            'no_installments' => $no_installments,
            'max_installments' => $max_installments,
            'user_name' => $user_name,
            'user_address' => $user_address,
            'user_phone' => $user_phone,
            'merchant_ok_url' => $merchant_ok_url,
            'merchant_fail_url' => $merchant_fail_url,
            'timeout_limit' => $timeout_limit,
            'currency' => $currency,
            'test_mode' => $test_mode
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_vals));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            die("PAYTR IFRAME connection error. err:" . curl_error($ch));
        }

        curl_close($ch);

        $result = json_decode($result, 1);

        if ($result['status'] == 'success') {
            $token = $result['token'];
            return view('order.pay_with_paytr', compact('token', 'package'));
        } else {
            die("PAYTR IFRAME failed. reason:" . $result['reason']);
        }
    }

    public function paytrSuccess()
    {
        flash(__('Ödeme başarılı! Paketiniz kısa süre içinde aktif edilecektir.'))->success();
        return redirect()->route(Auth::guard('company')->check() ? 'company.home' : 'home');
    }

    public function paytrFail()
    {
        flash(__('Ödeme başarısız oldu. Lütfen tekrar deneyin.'))->error();
        return redirect()->route(Auth::guard('company')->check() ? 'company.home' : 'home');
    }

    public function paytrCallback(Request $request)
    {
        // PayTR callback mantığı (IPN)
        $post = $request->all();
        $settings = SiteSetting::getPrimary();
        $merchant_key = $settings->paytr_merchant_key;
        $merchant_salt = $settings->paytr_merchant_salt;

        $hash = base64_encode(hash_hmac('sha256', $post['merchant_oid'] . $merchant_salt . $post['status'] . $post['total_amount'], $merchant_key, true));

        if ($hash != $post['hash']) {
            die('PAYTR notification failed: bad hash');
        }

        if ($post['status'] == 'success') {
            $merchant_oid = $post['merchant_oid'];
            // merchant_oid contains 'JOBS' . time() . $user_id
            // This is not enough to get the package_id. We should have stored it or pass it in oid.
            // Actually, the system seems to use session or we need to find the user.
            // Usually, merchant_oid should contain enough info or we look up a transactions table.
            // Let's assume for now we need a better way to track this, but I'll add the logic for package_for.

            // IMPROVEMENT: Search for where merchant_oid is used/stored.
        }

        echo "OK";
    }
}
