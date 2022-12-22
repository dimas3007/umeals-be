<?php

use App\Http\Controllers\Api\InstructionController;
use App\Http\Controllers\Api\MealIngredientController;
use App\Http\Controllers\Api\NutritionValueController;
use App\Http\Controllers\Api\UtensilsController;
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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::resource('/posts', \App\Http\Controllers\Api\PostController::class);
    Route::resource('/address', \App\Http\Controllers\Api\AddressController::class);
    Route::resource('/cart', \App\Http\Controllers\Api\CartController::class);
    Route::resource('/ingredient', \App\Http\Controllers\Api\IngredientController::class);
    Route::resource('/order', \App\Http\Controllers\Api\OrderController::class);

    Route::resource('/meal', \App\Http\Controllers\Api\MealController::class);

    Route::get('/meal-ingredient/data/{meal}', [MealIngredientController::class, 'getMealIngredients']);
    Route::resource('/meal-ingredient', \App\Http\Controllers\Api\MealIngredientController::class);

    Route::get('/nutrition/data/{nutrition}', [NutritionValueController::class, 'getMealNutrition']);
    Route::resource('/nutrition', \App\Http\Controllers\Api\NutritionValueController::class);

    Route::get('/utensil/data/{meal}', [UtensilsController::class, 'getMealUtensils']);
    Route::resource('/utensil', \App\Http\Controllers\Api\UtensilsController::class);

    Route::get('/instruction/data/{meal}', [InstructionController::class, 'getMealInstructions']);
    Route::resource('/instruction', \App\Http\Controllers\Api\InstructionController::class);

});