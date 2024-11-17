<?php

use App\Http\Controllers\DashbourdController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\PlacesController;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use App\Http\Controllers\OrganizedController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PriceControlleق;
use App\Http\Middleware\TokenMiddleware;
use App\Http\Middleware\Authenticate;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

include 'Dash.php';

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post("showone/organized",[DashbourdController::class,"ShowById"]);


// done
Route::post('register/organized',[OrganizedController::class,"register"]);
Route::post("login/organized",[OrganizedController::class,"login"]);

Route::get("showall/event",[EventController::class,"ShowAll"]);
Route::post("showone/event",[EventController::class,"ShowById"]);

Route::get("showcategory/part",[PartController::class,"showCategory"]);
Route::get('/search-by-part', [PartController::class, 'searchByTypeLike_part']);//جديد
Route::get('/search-by-part-price', [PartController::class, 'searchByPriceLessThanOrEqual']);//جديد
Route::post("showByCategory/part",[PartController::class,"ShowByCategory"]);

Route::post("showByCategory/part_id",[PartController::class,"showByCategory_id"]);
Route::post("showById/part",[PartController::class,"showById"]);


Route::get("showcategory/place",[PlacesController::class,"showCategory"]);
Route::post("showByCategory/place",[PlacesController::class,"ShowByCategory"]);
Route::post("showById/place",[PlacesController::class,"showById"]);


Route::get('/search-by-place', [PlacesController::class, 'searchByTypeLike_place']);//جديد
Route::get('/search-by-place-assessment', [PlacesController::class, 'searchByPriceLessThanOrEqual_place']);//جديد

Route::group(['middleware' => ['auth:api','role:user']], function ()
{
Route::post("add/event",[EventController::class,"Add"]);

});

Route::group(['middleware' => ['auth:api','role:user','checkyour:user']], function ()
{   //done
    Route::post("addImg/organized",[OrganizedController::class,"editImg"]);
    Route::post("editProfile/organized",[OrganizedController::class,"editProfile"]);
    Route::post("delete/organized",[OrganizedController::class,"delete"]);
    Route::post("showstatus/event",[EventController::class,"showBystatus"]);
    Route::post("add/event",[EventController::class,"Add"]);
});
Route::group(['middleware' => ['auth:api','checkyour:event']], function ()
{
    Route::post("delete/event",[EventController::class,"delete"]);
    Route::post("edit/event",[EventController::class,"edit"]);
    Route::post("addImg/event",[EventController::class,"addImge"]);

});

Route::prefix('owner')->name('owner.')->controller(OwnerController::class)->middleware('auth:api')->group(function () {
    Route::get('all_owner', 'index');
    Route::post('add_owner', 'store');
    Route::post('update_owner/{id}', 'update');
    Route::post('destroy_owner/{id}', 'destroy');
});//جديد

Route::prefix('price')->name('price.')->controller(PriceController::class)->middleware('auth:api')->group(function () {
    Route::get('all_price', 'index');
});//جديد

Route::get('/search-by-type', [EventController::class, 'searchByTypeLike']);//جديد
