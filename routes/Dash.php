<?php

use App\Http\Controllers\DashbourdController;
use App\Http\Controllers\EventFormatController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// */

// Route::get('/a', function () {
//     return" view('welcome');";
// });


Route::post("login/Dashbourd", [DashbourdController::class, "login"]);

Route::group(['middleware' => ['auth:api']], function () {

    Route::get("showcategory/part", [PartController::class, "showCategory"]);//done

    Route::post("addcategory/part", [PartController::class, "addCategory"]);//done

    Route::post("deletecategory/part", [PartController::class, "deleteCategory"]);//done

    Route::post("editcategory/part", [PartController::class, "editCategory"]);//done

    Route::get("showBycategory/allParts", [PartController::class, "ShowAllPart"]);

    Route::post("showById/part", [PartController::class, "showById"]);
    Route::post("addpart/part", [PartController::class, "addPart"]);
    Route::post("editpart/part", [PartController::class, "editPart"]);
    Route::post("deletepart/part", [PartController::class, "deletePart"]);

    Route::get("showByCategory/place", [PlacesController::class, "showCategory"]);
    Route::post("addcategory/place", [PlacesController::class, "addCategory"]);
    Route::post("deletecategory/place", [PlacesController::class, "deleteCategory"]);
    Route::post("editcategory/place", [PlacesController::class, "editCategory"]);

    Route::get("showByCategory/allPlaces", [PlacesController::class, "ShowAllPlaces"]);
    Route::post("addplace/place", [PlacesController::class, "addPlace"]);
    Route::post("editplace/place", [PlacesController::class, "editPlace"]);
    Route::post("deleteplace/place", [PlacesController::class, "deletePlace"]);

    Route::get("showall/event",[EventController::class,"ShowAll"]);
    Route::post("showone/event",[EventController::class,"ShowById"]);

    Route::post("show/eventFormat", [EventFormatController::class, "show"]);
    Route::post("add/eventFormat", [EventFormatController::class, "add"]);
    Route::post("edit/eventFormat", [EventFormatController::class, "edit"]);
    Route::post("delete/eventFormat", [EventFormatController::class, "delete"]);
    Route::post("deleteLine/eventFormat", [EventFormatController::class, "deleteLine"]);

    Route::post("editeStatuse/part",[DashbourdController::class,"editeStatuse"]);

    Route::get("/showall",[DashbourdController::class,"showall"]);
    Route::post("/ShowById",[DashbourdController::class,"ShowById"]);

});

//Route::get("showBycategory/allParts", [PartController::class, "ShowByCategory"]);
//    Route::post("showById/place", [PlacesController::class, "showById"]);
//    Route::get("showByCategory/allParts", [PartController::class, "ShowByCategory"]);
