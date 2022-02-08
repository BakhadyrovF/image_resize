<?php

use Illuminate\Http\Request;
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
*/

Route::get("/form", function()
{
    return view("form");
});

Route::post("/form_proccess", function(Request $request)
{
    // Storage::put($request->image, $request->image);
    // $request->image->storeAs("test1", $request->image->extension());
    return $request->image;



});
