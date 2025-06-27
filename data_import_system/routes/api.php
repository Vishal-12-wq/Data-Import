<?php


use App\Models\DataItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImportController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('upload', [ImportController::class, 'uplode'])->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->get('/user', 
    function (Request $request)
    {
        return $request->user();
    }
);

Route::middleware('auth:sanctum')->get('/data', 
    function ()
    {
        return DataItem::paginate(10);
    }
);


Route::middleware('auth:sanctum')->get('/tree-data', 
    function ()
    {
        return DataItem::all();
    }
);
