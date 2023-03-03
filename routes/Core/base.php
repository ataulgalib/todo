<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Core\UserManagementController;
use App\Http\Controllers\Core\LogsController;
use App\Http\Controllers\Core\RoleController;
use App\Http\Controllers\Core\RolePermissionController;


Route::controller(UserManagementController::class)
    ->prefix('user-management')
    ->name('user.')
    ->group(function(){
        Route::get('/','index')->name('index');
        Route::get('create','create')->name('create');
        Route::post('store','store')->name('store');
        Route::get('edit/{id}','edit')->name('edit');
        Route::put('update/{id}','update')->name('update');
        Route::delete('destroy/{id}','destroy')->name('destroy');
    });

Route::controller(LogsController::class)
    ->prefix('logs')
    ->name('logs.')
    ->group(function(){
        Route::get('/','index')->name('index');
    });

Route::controller(RolePermissionController::class)
    ->prefix('role-permission')
    ->name('role.permission.')
    ->group(function(){
        Route::get('create','create')->name('create');
        Route::match(['get','Post'],'get-role-permission-role-wise','getRolePermissionRoleWise')->name('get-role-wise');
        Route::post('store','store')->name('store');
    });

Route::controller(RoleController::class)
    ->prefix('role-management')
    ->name('role.')
    ->group(function(){
        Route::get('/','index')->name('index');
        Route::post('store','store')->name('store');
        Route::put('update/{id}','update')->name('update');
        Route::delete('destroy/{id}','destroy')->name('destroy');
    });


