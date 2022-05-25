<?php

use Illuminate\Http\Request;
//use Illuminate\Routing\Route;
use Illuminate\SupportFacadesRoute;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

require 'api_externos.php';

Route::middleware([ "middle_entorno",
                    "middle_webService"])->group(function(){

    Route::post("login","control_login@action_login");

    Route::post("logout","control_login@action_logout");


        include 'api_i.php';
        include 'api_r.php';
        include 'api_h.php';
        include 'api_a.php';

        include 'api_promujer_a.php';
        include 'api_c.php';
        
        include 'api_sivep.php';
        //FechaApelacion
        
});

    
