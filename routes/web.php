<?php

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

Route::get('/', function () {
/*
    $user = new App\User();
    $user->password = Hash::make('admin');
    $user->email = 'leandro.aroca.g@gmail.com';
    $user->name = 'leandro';
    $user->save();
*/
    //dd(\App\Location::all());

    return view('welcome');
});
