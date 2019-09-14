<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['web', 'admin'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {

    Route::get('/', 'AdminController@findUser')->name('admin-home');
    Route::get('/user/find', 'AdminController@findUser')->name('user-find');
    Route::any('/user/detail', 'AdminController@detailUser')->name('user-detail');
    Route::get('/user/logas', 'AdminController@logasUser')->name('user-logas');
    Route::post('/user/reset-pass', 'AdminController@resetPass')->name('user-reset-pass');
    Route::post('/user/band', 'AdminController@bandUser')->name('user-band');
    Route::post('/user/unband', 'AdminController@unbandUser')->name('user-unband');
    Route::post('/user/message', 'AdminController@messageUser')->name('user-message');
    Route::get('/user/activity/test', 'AdminController@testActivity')->name('event.test');
    Route::post('/user/activity/test/topup', 'AdminController@fakeTopup')->name('event.test.topup');
    Route::post('/user/activity/test/recharge', 'AdminController@fakeRecharge')->name('event.test.recharge');
    
    Route::get('/balance', 'AdminController@balanceInfo')->name('balance-info');
    Route::post('/balance/add', 'AdminController@addBalance')->name('balance-add');
    Route::post('/balance/history', 'AdminController@balanceHistory')->name('balance-history');
    
    Route::get('/server', 'AdminController@serverInfo')->name('server-info');
    Route::post('/server/remove', 'AdminController@removeServer')->name('server-remove');
    Route::post('/server/add', 'AdminController@addServer')->name('server-add');

    Route::get('/site', 'SiteController@status')->name('site-status');
    Route::post('/site/down', 'SiteController@down')->name('site-down');
    Route::post('/site/up', 'SiteController@up')->name('site-up');
    
   
});

/*
Route::middleware(['web', 'permission:statistics'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {
    
});

Route::middleware(['web', 'permission:manage_user'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('user-find');
    })->name('admin-home');
    
    Route::get('/user/find', 'AdminController@findUser')->name('user-find');
    Route::any('/user/detail', 'AdminController@detailUser')->name('user-detail');
    Route::get('/user/logas', 'AdminController@logasUser')->name('user-logas');
    Route::post('/user/reset-pass', 'AdminController@resetPass')->name('user-reset-pass');
    Route::post('/user/band', 'AdminController@bandUser')->name('user-band');
    Route::post('/user/unband', 'AdminController@unbandUser')->name('user-unband');
    Route::post('/user/message', 'AdminController@messageUser')->name('user-message');
    
    Route::get('/balance', 'AdminController@balanceInfo')->name('balance-info');
    Route::post('/balance/add', 'AdminController@addBalance')->name('balance-add');
    Route::post('/balance/history', 'AdminController@balanceHistory')->name('balance-history');
});
    
Route::middleware(['web', 'permission:manage_server'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {
    Route::get('/server', 'AdminController@serverInfo')->name('server-info');
    Route::post('/server/remove', 'AdminController@removeServer')->name('server-remove');
    Route::post('/server/add', 'AdminController@addServer')->name('server-add');
});

Route::middleware(['web', 'permission:manage_gift'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {

});

Route::middleware(['web', 'permission:manage_content'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {
    
});

Route::middleware(['web', 'permission:manage_site'])
->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {
    Route::get('/site', 'SiteController@status')->name('site-status');
    Route::post('/site/down', 'SiteController@down')->name('site-down');
    Route::post('/site/up', 'SiteController@up')->name('site-up');
});*/
