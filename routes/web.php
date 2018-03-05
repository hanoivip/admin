<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->namespace('Hanoivip\Admin\Controllers')->prefix('admin')->group(function () {
    
    Route::get('/user/find', 'AdminController@findUser')->name('user-find');
    Route::any('/user/detail', 'AdminController@detailUser')->name('user-detail');
    Route::get('/user/logas', 'AdminController@logasUser')->name('user-logas');
    Route::post('/user/reset-pass', 'AdminController@resetPass')->name('user-reset-pass');
    Route::post('/user/band', 'AdminController@bandUser')->name('user-band');
    Route::post('/user/unband', 'AdminController@unbandUser')->name('user-unband');
    Route::post('/user/message', 'AdminController@messageUser')->name('user-message');
    
    Route::any('/all/message', 'AdminController@messageAll')->name('spam');
    
    //Route::get('/gift');
    
    Route::get('/site', 'SiteController@status');
    Route::get('/site/down', 'SiteController@down');
    Route::get('/site/up', 'SiteController@up');
});