<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Package extends Model
{

    protected $table = 'packages';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function getPackagePriceAttribute($value)
    {
        // Intercept price if payment_bypass is active
        try {
            $setting = \App\SiteSetting::getPrimary();
            if (isset($setting->payment_bypass) && $setting->payment_bypass) {
                return 0;
            }
        } catch (\Exception $e) {
            // Log error or ignore if settings can't be loaded (e.g. during migration)
        }

        return $value;
    }

}
