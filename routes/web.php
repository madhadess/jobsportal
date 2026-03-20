<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ImportController;

Route::get('make-login/{guard}', 'IndexController@login')->name('make.login');

// Yetkilendirme güncelleme script'i (tarayıcıdan çalıştırma - passthru yok, doğrudan include)
// Kullanım: https://site.com/run-permissions-update
// İsteğe bağlı: .env RUN_UPDATE_KEY=xxx tanımlayıp ?key=xxx ile çağırın.
Route::get('run-permissions-update', function (\Illuminate\Http\Request $request) {
    $envKey = env('RUN_UPDATE_KEY', '');
    if ($envKey !== '' && $request->get('key') !== $envKey) {
        return response('<html><body><p>Yetkisiz. .env RUN_UPDATE_KEY ile ?key= değerini kullanın.</p></body></html>', 403);
    }
    $script = storage_path('app/legacy_scripts/update_permissions_once.php');
    if (!is_file($script)) {
        return response('<html><body><p>update_permissions_once.php bulunamadı.</p></body></html>', 404);
    }
    ob_start();
    try {
        require $script;
    } catch (Throwable $e) {
        ob_end_clean();
        return response('<html><body><pre>Hata: ' . htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString()) . '</pre></body></html>', 500);
    }
    $output = ob_get_clean();
    $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Yetkilendirme güncellemesi</title></head><body><pre>' . htmlspecialchars($output) . '</pre><p><strong>İşlem bitti.</strong> Güvenlik için bu rotayı kaldırabilirsiniz.</p></body></html>';
    return response($html, 200, ['Content-Type' => 'text/html; charset=utf-8']);
})->name('run.permissions.update');

// Route::post('company/email/resend', 'Company\CompanyVerificationController@resend')->name('company.verification.resend');
include_once(__DIR__ . '/seo_routes.php');
$real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'front_routes' . DIRECTORY_SEPARATOR;
Route::get('jobs-autocomplete', function (\Illuminate\Http\Request $request) {
  $term = $request->get('term', '');
  // Fetch job titles from the 'jobs' table where the title matches the search term
  $results = DB::table('jobs')
    ->where('search', 'LIKE', '%' . $term . '%')
    ->pluck('title');
  // Return the results as a JSON response
  return response()->json($results);
})->name('jobs.autocomplete');
/* * ******** IndexController ************ */
Route::get('/', 'IndexController@index')->name('index');




Route::get('/check-time', 'IndexController@checkTime')->name('check-time');
Route::post('set-locale', 'IndexController@setLocale')->name('set.locale');
/* * ******** HomeController ************ */
Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('home', 'HomeController@index')->name('home');
Route::get('all-categories', 'IndexController@allCategories')->name('all-categories');
/* * ******** TypeAheadController ******* */
Route::get('typeahead-currency_codes', 'TypeAheadController@typeAheadCurrencyCodes')->name('typeahead.currency_codes');
/* * ******** FaqController ******* */
Route::get('faq', 'FaqController@index')->name('faq');
/* * ******** CronController ******* */
Route::get('check-package-validity', 'CronController@checkPackageValidity');
/* * ******** Verification ******* */
Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');
Route::get('not-verified', 'Auth\RegisterController@notVerified')->name('not-verified');
Route::get('company-email-verification/error', 'Company\Auth\RegisterController@getVerificationError')->name('company.email-verification.error');
Route::get('company-email-verification/check/{token}', 'Company\Auth\RegisterController@getVerification')->name('company.email-verification.check');
Route::get('verification-success', function () {
  return view('auth.verification_success');
})->name('verification.success');

/* Profile Verification (Post-Registration) */
Route::get('verify-profile', 'VerificationController@showVerificationForm')->name('verify.profile')->middleware('auth');
Route::post('verify-profile', 'VerificationController@submitVerification')->name('verify.profile.submit')->middleware('auth');
/* * ***************************** */
// Sociallite Start
// OAuth Routes
Route::get('login/jobseeker/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('company-login', 'Auth\LoginController@companyLogin');
Route::get('company-register', 'Auth\LoginController@companyRegister');
Route::get('login/jobseeker/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('login/employer/{provider}', 'Company\Auth\LoginController@redirectToProvider');
Route::get('login/employer/{provider}/callback', 'Company\Auth\LoginController@handleProviderCallback');

Route::post('/import-records', [ImportController::class, 'store'])->name('import');



// Sociallite End
/* * ***************************** */
Route::get('/for-employers', function () {
  return view('for_employers');
});
Route::get('/for-jobseekers', function () {
  return view('for_jobseekers');
});
Route::post('tinymce-image_upload-front', 'TinyMceController@uploadImage')->name('tinymce.image_upload.front');
Route::get('cronjob/send-alerts', 'AlertCronController@index')->name('send-alerts');
Route::post('subscribe-newsletter', 'SubscriptionController@getSubscription')->name('subscribe.newsletter');
/* * ******** OrderController ************ */
include_once($real_path . 'order.php');
/* * ******** CmsController ************ */
include_once($real_path . 'cms.php');
/* * ******** JobController ************ */
include_once($real_path . 'job.php');
/* * ******** ContactController ************ */
include_once($real_path . 'contact.php');
/* * ******** CompanyController ************ */
include_once($real_path . 'company.php');
/* * ******** AjaxController ************ */
include_once($real_path . 'ajax.php');
/* * ******** UserController ************ */
include_once($real_path . 'site_user.php');
/* * ******** HomeServiceController - Evine Hizmet Al ************ */
include_once($real_path . 'home_services.php');
/* * ******** JobPostController / ApplicationController - İlanlar & Başvurular ************ */
include_once($real_path . 'job_listings.php');
/* * ******** User Auth ************ */
Route::get('member-register', 'Auth\RegisterController@showMemberRegistrationForm')->name('member.register');
Auth::routes();
/* * ******** Company Auth ************ */
include_once($real_path . 'company_auth.php');
/* * ******** Admin Auth ************ */
include_once($real_path . 'admin_auth.php');
if (!Route::has('blogs')) {
  Route::get('blog', 'BlogController@index')->name('blogs');
}
Route::get('blog/search', 'BlogController@search')->name('blog-search');
Route::get('blog/{slug}', 'BlogController@details')->name('blog-detail');
Route::get('/blog/category/{blog}', 'BlogController@categories')->name('blog-category');
Route::get('/company-change-message-status', 'CompanyMessagesController@change_message_status')->name('company-change-message-status');
Route::get('list-users', ['as' => 'list.users', 'uses' => 'Admin\UserController@index']);
Route::get('create-user', ['as' => 'create.user', 'uses' => 'Admin\UserController@createUser']);
Route::post('store-user', ['as' => 'store.user', 'uses' => 'Admin\UserController@storeUser']);
Route::get('edit-user/{id}', ['as' => 'edit.user', 'uses' => 'Admin\UserController@editUser']);
Route::put('update-user/{id}', ['as' => 'update.user', 'uses' => 'Admin\UserController@updateUser']);
Route::delete('delete-user-video/{id}', ['as' => 'delete.user.video', 'uses' => 'Admin\UserController@deleteUserVideo']);
Route::get('/seeker-change-message-status', 'Job\SeekerSendController@change_message_status')->name('seeker-change-message-status');
Route::post('/api/users', 'AjaxController@create');
Route::get('/sitemap/companies', 'SitemapController@companies');
Route::get('job8', 'Job8Controller@job8')->name('job8');
Route::get('cronjob/delete-jobs', 'Job8Controller@delete_jobs')->name('delete-jobs');
Route::get('cronjob/amend-jobs', 'Job8Controller@amend_jobs')->name('amend-jobs');
Route::get('cronjob/set-count-industry', 'Job8Controller@set_count_industry')->name('set_count_industry');
Route::get('cronjob/set-total-count', 'Job8Controller@set_total_count')->name('set_total_count');
Route::get('cronjob/set-total-country', 'Job8Controller@set_count_country')->name('set_count_country');
Route::get('cronjob/set-total-companies', 'Job8Controller@set_count_company')->name('set_count_company');
Route::get('cronjob/set-total-jobType', 'Job8Controller@set_count_jobType')->name('set_count_jobType');
Route::get('cronjob/remove-duplicates', 'Job8Controller@remove_duplicates')->name('remove_duplicates');
Route::get('cronjob/set-count-company', 'Job8Controller@set_count_company')->name('set_count_company');
Route::get('cronjob/remove-duplicate-companies', 'Job8Controller@remove_duplicates')->name('remove-duplicate-companies');
Route::get('cronjob/recover-companies', 'Job8Controller@recover_companies')->name('recover-companies');
Route::get('cronjob/recover-jobs', 'Job8Controller@recover_jobs')->name('recover-jobs');
Route::get('set-location', 'Job8Controller@set_location')->name('set_location');
Route::post('ajax_upload_file', 'FilerController@upload')->name('filer.image-upload');
Route::post('ajax_remove_file', 'FilerController@fileDestroy')->name('filer.image-remove');
Route::get('/update-db-bypass', function () {
  if (!\Illuminate\Support\Facades\Schema::hasColumn('site_settings', 'payment_bypass')) {
    \Illuminate\Support\Facades\Schema::table('site_settings', function (\Illuminate\Database\Schema\Blueprint $table) {
      $table->boolean('payment_bypass')->default(0);
    });
    return 'Column payment_bypass added successfully.';
  }
  return 'Column payment_bypass already exists.';
});
Route::get('/clear-cache', function () {
  $exitCode = Artisan::call('config:clear');
  $exitCode = Artisan::call('cache:clear');
  $exitCode = Artisan::call('config:cache');
  return 'DONE'; //Return anything
});

/* Personnel Automation Routes */
Route::get('my-assignments', 'PersonnelAutomationController@myAssignments')->name('personnel.assignments');
Route::get('work-preferences', 'PersonnelAutomationController@workPreferences')->name('personnel.preferences');
Route::post('work-preferences', 'PersonnelAutomationController@updatePreferences')->name('personnel.update_preferences');
Route::get('assignment/{id}', 'PersonnelAutomationController@assignmentDetails')->name('personnel.assignment_details');
Route::post('assignment/{id}/accept', 'PersonnelAutomationController@acceptAssignment')->name('personnel.accept_assignment');
Route::post('assignment/{id}/reject', 'PersonnelAutomationController@rejectAssignment')->name('personnel.reject_assignment');


Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
  Route::get('service-questions/{categoryId}', 'Admin\ServiceQuestionController@index')->name('admin.service-questions.index');
  Route::post('service-questions/{categoryId}', 'Admin\ServiceQuestionController@store')->name('admin.service-questions.store');
  Route::delete('service-questions/{id}', 'Admin\ServiceQuestionController@destroy')->name('admin.service-questions.destroy');
});
