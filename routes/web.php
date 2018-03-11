<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'admin'])->namespace('Hanoivip\Admin\Controllers')->prefix('ecmin')->group(function () {
    
    Route::get('/', function () {
        return redirect()->route('user-find');
    });
    
    Route::get('/user/find', 'AdminController@findUser')->name('user-find');
    Route::any('/user/detail', 'AdminController@detailUser')->name('user-detail');
    Route::get('/user/logas', 'AdminController@logasUser')->name('user-logas');
    Route::post('/user/reset-pass', 'AdminController@resetPass')->name('user-reset-pass');
    Route::post('/user/band', 'AdminController@bandUser')->name('user-band');
    Route::post('/user/unband', 'AdminController@unbandUser')->name('user-unband');
    Route::post('/user/message', 'AdminController@messageUser')->name('user-message');
    
    Route::get('/balance', 'AdminController@balanceInfo')->name('balance-info');
    Route::post('/balance/add', 'AdminController@addBalance')->name('balance-add');
    Route::get('/balance/history', 'AdminController@balanceHistory')->name('balance-history');
    
    Route::get('/server', 'AdminController@serverInfo')->name('server-info');
    Route::post('/server/remove', 'AdminController@removeServer')->name('server-remove');
    Route::post('/server/add', 'AdminController@addServer')->name('server-add');
    
    //Route::get('/gift');
    
    Route::get('/site', 'SiteController@status')->name('site-status');
    Route::get('/site/down', 'SiteController@down')->name('site-down');
    Route::get('/site/up', 'SiteController@up')->name('site-up');
});