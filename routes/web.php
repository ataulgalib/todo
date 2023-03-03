<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Core\ImplementationController;

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

Route::get('/config/{parameter}', function ($parameter) {
    $command = string_replace('-', ':', $parameter);
    Artisan::call($command);
    return __('php artisan ').$command. __(' run successfully');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::match(['get', 'post'], 'implementation/{params?}', [ImplementationController::class, 'newImplementation']);



Auth::routes();

// FRONT END ROUTES 


