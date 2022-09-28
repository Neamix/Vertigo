<?php

use App\Mail\DefaultEmail;
use App\Models\Attending;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Models\File;
use App\Models\Priviledge;
use App\Models\Request;

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


Route::get('/', function () {
    $data['name'] = 'abdalrhman';
    $data['token'] = 'toekn';
    $data['email'] = 'abdalrhmanhussin@gmail.com';
    $data['type'] = 'Verify';
    $data['url']   = "reset?email=email&token=token&type=".$data['type'];
    $data['view'] = 'emails.forgetpassword';

    return new DefaultEmail($data);
});

Route::get('/demo', function () {
    // $users = User::all();

    // return view('export.users',[
    //     'users' => $users
    // ]);

    dd(Attending::find(1)->requests);
});

Route::get('/download/{file}',function($file){
    File::create([
        'file' => $file
    ]);

    return response()->download(storage_path() . '/app/files/'.$file)->deleteFileAfterSend(true);
});

