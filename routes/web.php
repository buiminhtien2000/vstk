<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'App\Http\Controllers\API\StatisticAPI@page_customer');
Route::get('dang-nhap', 'App\Http\Controllers\API\UserAPI@page_login')->name('page_login');
Route::get('quen-mat-khau', 'App\Http\Controllers\API\UserAPI@page_reset_pass')->name('page_reset_pass');
Route::get('tao-mat-khau-moi/{code}', 'App\Http\Controllers\API\UserAPI@page_create_new_pass')->name('page_create_new_pass');
Route::get('khach-hang', 'App\Http\Controllers\API\StatisticAPI@page_customer')->name('khach-hang');
Route::get('config-field', 'App\Http\Controllers\AppBitrix\Config@page_config_filed')->name('page_config_filed');
Route::get('logout', 'App\Http\Controllers\API\UserAPI@logout')->name('logout');
