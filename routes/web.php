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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/gerar', 'CertificadoController@store')->name('gerar');

Route::post('/certificado/login', 'Auth\LoginController@loginCertificado')->name('certificado.login');

Route::get('/novacarta', 'LettersController@create')->name('escrever');

Route::post('/criarcarta', 'LettersController@store')->name('criarCarta');