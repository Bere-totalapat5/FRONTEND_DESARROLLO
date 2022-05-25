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

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::middleware([ "middle_entorno",
                    "middle_webService", "middle_sesion"])->group(function(){
    //Login
    Route::get('/','login\control_login@vista_login') ->  name('login.principal');
    Route::post('/','login\control_login@action_login');
    Route::get('logout','logout\LogoutController@logout') -> name('logout');
    //app
    // include 'routes_l.php';
    Route::middleware([ "middle_elementos_front"])->group(function(){
        include 'web_r.php';
        include 'web_h.php';
        include 'web_a.php';

        include 'web_promujer_a.php';
        include 'web_c.php';
    });

});
