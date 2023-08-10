<?php

Route::group(['middleware' => config('laravel-cm.middleware'), 'namespace' => 'Flobbos\LaravelCM\Controllers', 'prefix' => 'laravel-cm', 'as' => 'laravel-cm::'], function () {
    Route::get('clever-reach', CleverReach::class)->name('clever-reach');
    Route::get('clever-reach-groups', CleverReachGroups::class)->name('clever-reach-groups');
    Route::get('clever-reach-forms', CleverReachForms::class)->name('clever-reach-forms');
    Route::get('clever-reach-newsletters', CleverReachNewsletters::class)->name('clever-reach-newsletters');
    Route::get('clever-reach-subscribers', CleverReachSubscribers::class)->name('clever-reach-subscribers');
});
