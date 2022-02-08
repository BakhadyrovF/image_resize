<?php

use App\Http\Controllers\V1\AlbumController;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\ImageManipulationController;
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

Route::prefix("v1")->group(function()
{
    Route::middleware("guest")->group(function()
    {
        Route::post("/login", [AuthController::class, "login"]);
        Route::post("/register", [AuthController::class, "register"]);
    });

    Route::middleware("auth:sanctum")->group(function()
    {
        Route::get("/logout", [AuthController::class, "logout"]);
        Route::apiResource("album", AlbumController::class);
        Route::get("/image", [ImageManipulationController::class, "index"]);
        Route::get("/image/by-album/{album}", [ImageManipulationController::class, "byAlbum"]);
        Route::get("/image/{id}", [ImageManipulationController::class, "show"]);
        Route::post("/image/resize", [ImageManipulationController::class, "resize"]);
        Route::delete("image/{id}", [ImageManipulationController::class, "destroy"]);

    });

});
