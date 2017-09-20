<?php

Route::group([
    'namespace'    =>   'AccessManager\Prepaid\Http\Controllers',
    'prefix'        =>  'prepaid',
    'middleware'    =>      'auth',
], function(){

    Route::get('vouchers',[
        'as'    =>  'vouchers.index',
        'uses'  =>  function(){
            return redirect()->route('vouchers.unused');
        },
    ]);

    Route::get('vouchers/unused', [
        'as'    =>  'vouchers.unused',
        'uses'  =>  'VouchersController@getUnused',
    ]);

    Route::get('vouchers/used', [
        'as'    =>  'vouchers.used',
        'uses'  =>  'VouchersController@getUsed',
    ]);

    Route::get('vouchers/generate', [
        'as'    =>  'vouchers.generate',
        'uses'  =>  'VouchersController@getGenerate',
    ]);

    Route::post('vouchers/generate', [
        'as'    =>  'vouchers.generate.post',
        'uses'  =>  'VouchersController@postGenerate',
    ]);

    Route::get('recharge-account', [
        'as'    =>  'prepaid.recharge',
        'uses'  =>  'PrepaidController@getRechargeAccount',
    ]);

    Route::post('recharge-account', [
        'as'    =>  'prepaid.recharge.post',
        'uses'  =>  'PrepaidController@postRechargeAccount',
    ]);
});