<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;

/* Get All recipes with filter & paginate
**/
Route::get('/recipes', [RecipeController::class, 'index']);
// get single recipe
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);
// update single recipe
Route::patch('/recipes/{recipe}', [RecipeController::class, 'update']);
// Delete single recipe
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);
// Create single recipe
Route::post('new/recipes/', [RecipeController::class, 'store']);
//upload
Route::post('/recipes/upload', [RecipeController::class, 'upload']);

/**
 * Get All category
 */
Route::get('categories',[CategoryController::class , 'index']);
