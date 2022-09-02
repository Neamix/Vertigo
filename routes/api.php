<?php

use App\Http\Controllers\FileController;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::group(['middleware' => 'auth:api'],function(){
    Route::get('/download/{file}',function($file){
        File::create([
            'file' => $file
        ]);
    
        return Storage::download('files/'.$file);
    });
});

