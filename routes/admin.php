<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login','Auth\LoginController@showLoginForm')->name('login');

Route::group([ 'middleware' => ['auth', 'allow_permissions'] ],function(){

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::group([ 'namespace' => 'Admin' ],function(){

        Route::get('dashboard', 'HomeController@index')->name('dashboard');

        Route::get('todo','TodoController@index')->name('todo.index');
        Route::get('todo/show/{id}','TodoController@show')->name('todo.show');
        Route::post('todo/store','TodoController@store')->name('todo.store');
        Route::put('todo/edit/{id}','TodoController@update')->name('todo.update');
        Route::delete('todo/delete/{id}','TodoController@destroy')->name('todo.destroy');


    });

});
