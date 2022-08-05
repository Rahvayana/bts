<?php

use App\Http\Controllers\DiscountCategoryController;
use App\Http\Controllers\RevenueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix'=>'api'], function () {
    Route::post('users/signin',[UserController::class, 'login']);
    Route::post('users/signup',[UserController::class, 'register']);
    
    Route::group(['middleware' => ['api_auth']], function () {
        Route::get('users',[UserController::class, 'index']);

        //Shopping Request
        Route::post('shopping',[ShoppingController::class, 'store']);
        Route::delete('shopping/{id}',[ShoppingController::class, 'destroy']);
        Route::post('shopping/{id}',[ShoppingController::class, 'update']);
        Route::get('shopping',[ShoppingController::class, 'index']);
        Route::get('shopping/{id}',[ShoppingController::class, 'show']);
    });
});
