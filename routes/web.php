<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

    return "Cache cleared successfully";
 });

 Route::get('/optimize', function () {
     \Artisan::call('optimize');
     return 'Optimization complete!';
 });
 Route::get('/config-cache', function() {
      $exitCode = Artisan::call('config:cache');
      return 'Config cache cleared';
  });


Route::get('admin/login',[AdminController::class,'index']);
Route::post('admin/auth',[AdminController::class,'auth'])->name('admin.auth');
Route::get('admin/backup',[AdminController::class,'backup']);


    Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    
    
    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->forget('ADMIN_GROUP_ID');
        session()->forget('ADMIN_GROUP_NAME');
        
        return redirect('admin/login')->with('message','Logout Successfully');
    });

