<?php



namespace App\Providers;



use App\SiteSetting;

use App\Language;

use Illuminate\Support\ServiceProvider;



class CustomConfigServiceProvider extends ServiceProvider
{



    /**

     * Bootstrap any application services.

     *

     * @return void

     */

    public function boot()
    {
        try {
            $settings = SiteSetting::getPrimary();
            config([
                'mail.default' => $settings->mail_driver,
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $settings->mail_host,
                'mail.mailers.smtp.port' => $settings->mail_port,
                'mail.mailers.smtp.encryption' => $settings->mail_encryption,
                'mail.mailers.smtp.username' => $settings->mail_username,
                'mail.mailers.smtp.password' => $settings->mail_password,
                'mail.mailers.smtp.verify_peer' => false,
                'mail.mailers.smtp.timeout' => null,
                'mail.mailers.smtp.local_domain' => env('MAIL_EHLO_DOMAIN'),
                'mail.from.address' => $settings->mail_from_address,
                'mail.from.name' => $settings->mail_from_name,
                'mail.recieve_to.address' => $settings->mail_to_address,
                'mail.recieve_to.name' => $settings->mail_to_name,

                'services.mailgun.domain' => $settings->mailgun_domain,
                'services.mailgun.secret' => $settings->mailgun_secret,
                'services.mandrill.secret' => $settings->mandrill_secret,
                'services.sparkpost.secret' => $settings->sparkpost_secret,
                'services.ses.key' => $settings->ses_key,
                'services.ses.secret' => $settings->ses_secret,
                'services.ses.region' => $settings->ses_region,

                'captcha.sitekey' => $settings->nocaptcha_sitekey,
                'captcha.secret' => $settings->nocaptcha_secret,
                'captcha.options' => ['timeout' => 2.0],

                'services.facebook.client_id' => $settings->facebook_app_id,
                'services.facebook.client_secret' => $settings->facebeek_app_secret,
                'services.facebook.redirect' => url('login/jobseeker/facebook/callback'),

                'services.twitter.client_id' => $settings->twitter_app_id,
                'services.twitter.client_secret' => $settings->twitter_app_secret,
                'services.twitter.redirect' => url('login/jobseeker/twitter/callback'),

                'services.google.client_id' => $settings->google_app_id,
                'services.google.client_secret' => $settings->google_app_secret,
                'services.google.redirect' => url('login/jobseeker/google/callback'),

                'paypal.client_id' => env('PAYPAL_CLIENT_ID', $settings->paypal_client_id),
                'paypal.secret' => env('PAYPAL_SECRET', $settings->paypal_secret),
                'paypal.settings.mode' => env('PAYPAL_MODE', $settings->paypal_live_sandbox),
                'paypal.settings.http.ConnectionTimeOut' => 1000,
                'paypal.settings.log.LogEnabled' => true,
                'paypal.settings.log.FileName' => storage_path() . '/logs/paypal.log',
                'paypal.settings.log.LogLevel' => 'ERROR',

                'stripe.stripe_key' => env('stripe_key', $settings->stripe_key),
                'stripe.stripe_secret' => env('stripe_secret', $settings->stripe_secret),

                'jobseeker.is_jobseeker_package_active' => $settings->is_jobseeker_package_active,
                'company.is_company_package_active' => $settings->is_company_package_active,

                'newsletter.apiKey' => $settings->mailchimp_api_key,
                'newsletter.defaultListName' => $settings->mailchimp_list_name,
                'newsletter.lists.subscribers.id' => $settings->mailchimp_list_id,
            ]);
        } catch (\Throwable $e) {
            // Site settings not available (e.g. fresh install); config remains from config files
        }

        $this->app['config']['default_lang'] = 'en';

        if (null !== $lang = Language::where('is_default', '=', 1)->first()) {

            if ($lang !== null) {

                $this->app['config']['default_lang'] = $lang->iso_code;

            }

        }

    }



    /**

     * Register any application services.

     *

     * @return void

     */

    public function register()
    {

        //

    }



}

