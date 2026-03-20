<?php
use App\Http\Controllers\OrderController;


/* * ******** OrderController ************ */
Route::get('order-free-package/{package_id}', 'OrderController@orderFreePackage')->name('order.free.package');

Route::get('order-package/{package_id}', 'OrderController@orderPackage')->name('order.package');
// PayTR Routes
Route::get('paytr-order-package/{package_id}', 'PaytrOrderController@paytrOrderPackage')->name('paytr.order.package');
Route::post('paytr-callback', 'PaytrOrderController@paytrCallback')->name('paytr.callback');
Route::get('paytr-success', 'PaytrOrderController@paytrSuccess')->name('paytr.success');
Route::get('paytr-fail', 'PaytrOrderController@paytrFail')->name('paytr.fail');

// Bank Transfer Route
Route::get('bank-transfer-order-package/{package_id}', function ($package_id) {
    $package = App\Package::findOrFail($package_id);
    $siteSetting = App\SiteSetting::findOrFail(1272);
    return view('order.pay_with_bank', compact('package', 'siteSetting'));
})->name('bank.transfer.order.package');
Route::get('order-upgrade-package/{id}', 'OrderController@orderUpgradePackage')->name('order.upgrade.package');
Route::get('paypal-payment-status/{id}', 'OrderController@getPaymentStatus')->name('payment.status');
Route::get('paypal-upgrade-payment-status/{id}', 'OrderController@getUpgradePaymentStatus')->name('upgrade.payment.status');

Route::get('/paypal/order', [OrderController::class, 'createOrder']);
Route::post('/paypal/order/{orderId}/capture', [OrderController::class, 'captureOrder'])->name('captureOrder.payment');



Route::get('stripe-order-form/{id}/{new_or_upgrade}', 'StripeOrderController@stripeOrderForm')->name('stripe.order.form');
Route::post('stripe-order-package', 'StripeOrderController@stripeOrderPackage')->name('stripe.order.package');
Route::post('stripe-order-upgrade-package', 'StripeOrderController@stripeOrderUpgradePackage')->name('stripe.order.upgrade.package');

Route::get('razorpay-order-form/{id}/{new_or_upgrade}', 'RazorpayOrderController@razorpayOrderForm')->name('razorpay.order.form');
Route::post('razorpay-order-package', 'RazorpayOrderController@razorpayOrderPackage')->name('razorpay.order.package');
Route::post('razorpay-verify-payment', 'RazorpayOrderController@verifyRazorpayPayment')->name('razorpay.verify.payment');