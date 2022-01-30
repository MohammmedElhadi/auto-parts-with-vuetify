<?php

use App\Http\Controllers\Api\LoginController;
use api\TypeController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\DemandeController;
use App\Http\Controllers\api\EtatController;
use App\Http\Controllers\api\MarqueController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\SubcategoryController;
use App\Http\Controllers\api\TypeController as ApiTypeController;
use App\Http\Controllers\api\WilayaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('type',ApiTypeController::class);
Route::controller(MarqueController::class)->group(function () {
    Route::get('marque/{id}/modeles','modeles')->name('marque.modeles');
});
Route::controller(CategoryController::class)->group(function () {
    Route::get('category/{id}/subcategories','getSubCategories')->name('category.subcategories');
});
Route::controller(SubcategoryController::class)->group(function () {
    Route::get('subcategory/{id}/subcategory2s','getSubSubCategories')->name('subcategory.subcategory2s');
});
Route::resource('marque',MarqueController::class);
Route::resource('category', CategoryController::class);
Route::resource('wilaya', WilayaController::class);
Route::resource('demande', DemandeController::class);
Route::resource('etat', EtatController::class);
Route::resource('notification', NotificationController::class);


