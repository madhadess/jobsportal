<?php

Route::get('cms/{slug}', 'CmsController@getPage')->name('cms');
Route::get('terms-of-use', 'CmsController@termsOfUse')->name('terms.of.use');
if (!Route::has('contact.us')) {
    Route::get('iletisim', 'ContactController@index')->name('contact.us');
}
Route::post('contact-us', 'ContactController@postContact')->name('contact.us.store');
Route::get('contact-us', function () {
    return redirect()->route('contact.us', [], 301);
});
Route::get('contact-us-thanks', 'ContactController@thanks')->name('contact.us.thanks');
