<?php
use Illuminate\Support\Facades\Route;
// TODO: api admin guard?
Route::middleware([])->namespace('Hanoivip\Admin\Controllers')
    ->prefix('ecmin/api')
    ->group(function () {
    //Route::post('/recharge', 'OpsController@recharge');
});