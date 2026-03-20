<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SiteSetting extends Model
{

    protected $table = 'site_settings';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get the primary/default site setting (ID 1272 or first record).
     * Throws an HTTP exception with a clear message if no setting exists.
     *
     * @return self
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public static function getPrimary()
    {
        $setting = static::find(1272) ?? static::first();
        if (!$setting) {
            throw new HttpException(500, 'Site ayarları bulunamadı. Lütfen site_settings tablosunda kayıt olduğundan emin olun.');
        }
        return $setting;
    }

}
