<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\DashbourdController;
use App\Http\Controllers\EventController;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Http\Controllers\OrganizedController;
use App\Http\Middleware\TokenMiddleware;
use App\Http\Middleware\Authenticate;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

// Route::get('/a', function () {
//     return" view('welcome');";
// });  
// Route::post("login/Dashbourd",[DashbourdController::class,"login"]);

// Route::group(['middleware' => 'auth:api'], function () 
// { 
//  /////part   
//     Route::get("showcategory/part",[PartController::class,"showCategory"]);
//     Route::post("addcategory/part",[PartController::class,"addCategory"]);
//     Route::post("deletecategory/part",[PartController::class,"deleteCategory"]);
//     Route::post("editcategory/part",[PartController::class,"editCategory"]); 

//     Route::post("showByCategory/part",[PartController::class,"ShowByCategory"]);
//     Route::post("showById/part",[PartController::class,"showById"]);
//     Route::post("addpart/part",[PartController::class,"addPart"]);
//     Route::post("editpart/part",[PartController::class,"editPart"]);
//     Route::post("deletepart/part",[PartController::class,"deletePart"]);
// ///place 
//     Route::get("showcategory/place",[PlacesController::class,"showCategory"]);
//     Route::post("addcategory/place",[PlacesController::class,"addCategory"]);
//     Route::post("deletecategory/place",[PlacesController::class,"deleteCategory"]);
//     Route::post("editcategory/place",[PlacesController::class,"editCategory"]); 

//     Route::post("showByCategory/place",[PlacesController::class,"ShowByCategory"]);
//     Route::post("showById/place",[PlacesController::class,"showById"]);
//     Route::post("addplace/place",[PlacesController::class,"addPlace"]);
//     Route::post("editplace/place",[PlacesController::class,"editPlace"]);
//     Route::post("deleteplace/place",[PlacesController::class,"deletePlace"]);

//     Route::post("editeStatuse/part",[DashbourdController::class,"editeStatuse"]);

// });