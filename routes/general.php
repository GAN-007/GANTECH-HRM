<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;





// Route::get('/documentation-attendance-device-addon', function() {
//     return File::get(public_path() . '/documentation/attendance_device_addon/index.php');
// });

Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/documentation', function() {
    return view('documentation.index');
});

Route::get('/documentation-attendance-device-addon', function() {
    // return view('documentation/attendance_device_addon/index');
    return view('documentation.attendance_device_addon.index');
});

Route::get('/optimize', function() {
    Artisan::call('optimize:clear');
    return redirect()->back();
});

Route::get('/db-seed', function() {
    Artisan::call('db:seed --class=NameSeeder');
    return 'DB Seeding Successfully';
});

Route::get('/migrate', function() {
    Artisan::call('migrate');
    return 'Successfully Migrated';
});

Route::get('/maintainance-down', function() {
    Artisan::call('down');
    return redirect()->back();
});

Route::get('/maintainance-up', function() {
    Artisan::call('up');
    return redirect()->back();
});




// Route::group(['middleware' => ['auth']], function () {

    // Route::group(['prefix' => 'auth/google'], function () {
    //     Route::controller(GoogleAuthController::class)->group(function () {
    //         Route::get('/redirect', 'redirect')->name('auth.redirect.google');
    //         Route::get('/callback', 'callback');
    //     });
    // });
// });


