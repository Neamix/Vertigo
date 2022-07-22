<?php

use App\Mail\DefaultEmail;
use App\Models\User;
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
use App\Exports\UsersExport;
use App\Models\File;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
Route::get('/', function () {
    $user = User::find(22);
    dd($user);
    // // Creating a token without scopes...
    // $token = $user->createToken('Token Name')->accessToken;

    // return $token;
});

Route::get('/demo', function () {
    return Excel::download(new UsersExport, 'users.xlsx');
});

Route::get('/download/{file}',function($file){
    File::create([
        'file' => $file
    ]);

    return response()->download(storage_path() . '/app/files/'.$file)->deleteFileAfterSend(true);
});

