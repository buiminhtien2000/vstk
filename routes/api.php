<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| 
*/
  
Route::post('login', 'App\Http\Controllers\API\UserAPI@login')->name('login');
Route::post('check_email_user', 'App\Http\Controllers\API\UserAPI@check_email_user')->name('check_email_user');
Route::post('link_reset', 'App\Http\Controllers\API\UserAPI@create_link_reset')->name('link_reset');
Route::post('confirm_reset', 'App\Http\Controllers\API\UserAPI@confirm_reset')->name('confirm_reset');
Route::post('create_password', 'App\Http\Controllers\API\UserAPI@create_password')->name('create_password');

    Route::post('save_config_field', 'App\Http\Controllers\AppBitrix\Config@save_config_field')->name('save_config_field');
    Route::post('get_config_field', 'App\Http\Controllers\AppBitrix\Config@get_config_field')->name('get_config_field');
    Route::post('save_config_commission', 'App\Http\Controllers\AppBitrix\Config@save_config_commission')->name('save_config_commission');
    Route::post('get_config_commission', 'App\Http\Controllers\AppBitrix\Config@get_config_commission')->name('get_config_commission');
    Route::post('get_deal_field', 'App\Http\Controllers\AppBitrix\Config@get_deal_field')->name('get_deal_field');
    Route::post('get_pipeline', 'App\Http\Controllers\API\CustomerAPI@get_pipeline')->name('get_pipeline');
    Route::post('get_pipeline_by_user', 'App\Http\Controllers\API\StatisticAPI@get_pipeline_by_user')->name('get_pipeline_by_user');
    Route::post('sum_customer', 'App\Http\Controllers\API\StatisticAPI@sum_customer')->name('sum_customer');
    Route::post('sum_commission', 'App\Http\Controllers\API\StatisticAPI@sum_commission')->name('sum_commission');
    Route::post('filter_customer', 'App\Http\Controllers\API\CustomerAPI@filter_customer')->name('filter_customer');
    Route::post('search_customer', 'App\Http\Controllers\API\CustomerAPI@search_customer')->name('search_customer');
    Route::post('get_customer', 'App\Http\Controllers\API\CustomerAPI@get_customer')->name('get_customer');
    Route::post('parseImport', 'App\Http\Controllers\API\CustomerAPI@parseImport')->name('parseImport');
    Route::post('update_customer', 'App\Http\Controllers\API\CustomerAPI@update_customer')->name('update_customer');
    Route::post('get_customer_by_id', 'App\Http\Controllers\API\CustomerAPI@get_customer_by_id')->name('get_customer_by_id');
    Route::post('get_contact_customer', 'App\Http\Controllers\API\CustomerAPI@get_contact_customer')->name('get_contact_customer');
    Route::post('get_stage', 'App\Http\Controllers\API\DealAPI@get_stage')->name('get_stage');
    Route::post('get_deal', 'App\Http\Controllers\API\DealAPI@get_deal')->name('get_deal');
    Route::post('save_config', 'App\Http\Controllers\AppBitrix\ConfigField@save')->name('save_config');
    Route::post('get_config', 'App\Http\Controllers\API\ConfigField@get_config')->name('get_config');
    
   