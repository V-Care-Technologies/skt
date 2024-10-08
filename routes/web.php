<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\YarnVendorController;
use App\Http\Controllers\admin\YarnProductController;
use App\Http\Controllers\admin\YarnPoController;
use App\Http\Controllers\admin\YarnInwardController;
use App\Http\Controllers\admin\YarnBillController;
use App\Http\Controllers\admin\RolaInwardController;
use App\Http\Controllers\admin\RolaOutwardController;
use App\Http\Controllers\admin\FabricProcessController;
use App\Http\Controllers\admin\FabricProductController;
use App\Http\Controllers\admin\FabricWeaverVendorController;
use App\Http\Controllers\admin\FabricProcessVendorController;
use App\Http\Controllers\admin\LeadsController;
use App\Http\Controllers\admin\TasksController;
 
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

Route::group(['middleware'=>'admin_auth'],function(){

    Route::get('admin/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
    
    Route::get('admin/user',[UserController::class,'index'])->name('admin.user');
    Route::get('admin/user/manage-user',[UserController::class,'manage_user'])->name('admin.manage-user');
    Route::get('admin/user/manage-user/{id}',[UserController::class,'manage_user']);
    Route::post('admin/user/manage-user-process',[UserController::class,'manage_user_process'])->name('user.manage-user-process');
    Route::post('admin/user/delete',[UserController::class,'delete']);
    Route::post('admin/user/check-phone', [UserController::class, 'checkPhone'])->name('admin.check-phone');

    Route::get('admin/vendor',[YarnVendorController::class,'index'])->name('admin.vendor');
    Route::get('admin/vendor/manage-vendor',[YarnVendorController::class,'manage_vendor'])->name('admin.manage-vendor');
    Route::get('admin/vendor/manage-vendor/{id}',[YarnVendorController::class,'manage_vendor']);
    Route::post('admin/vendor/manage-vendor-process',[YarnVendorController::class,'manage_vendor_process'])->name('vendor.manage-vendor-process');
    Route::post('admin/vendor/delete',[YarnVendorController::class,'delete']);
    Route::post('admin/vendor/deletefirm',[YarnVendorController::class,'deletefirm']);

    Route::get('admin/product',[YarnProductController::class,'index'])->name('admin.product');
    Route::get('admin/product/manage-product',[YarnProductController::class,'manage_product'])->name('admin.manage-product');
    Route::get('admin/product/manage-product/{id}',[YarnProductController::class,'manage_product']);
    Route::post('admin/product/manage-product-process',[YarnProductController::class,'manage_product_process'])->name('product.manage-product-process');
    Route::post('admin/product/delete',[YarnProductController::class,'delete']);
    Route::post('admin/product/deletevendor',[YarnProductController::class,'deletevendor']);
    Route::post('admin/product/deletevendordetail',[YarnProductController::class,'deletevendordetail']);


    Route::get('admin/yarnpo',[YarnPoController::class,'index']);
    Route::get('admin/yarnpo/manage-po',[YarnPoController::class,'manage_po']);
    Route::get('admin/yarnpo/manage-po/{id}',[YarnPoController::class,'manage_po']);
    Route::post('admin/yarnpo/getYarn',[YarnPoController::class,'getYarn']);
    Route::post('admin/yarnpo/getYarnDetails',[YarnPoController::class,'getYarnDetails']);
    Route::post('admin/yarnpo/manage-po-process',[YarnPoController::class,'manage_po_process']);
    Route::post('admin/yarnpo/delete',[YarnPoController::class,'delete']);
    Route::post('admin/yarnpo/deletepodetail',[YarnPoController::class,'deletepodetail']);

    Route::get('admin/yarninward',[YarnInwardController::class,'index']);
    Route::get('admin/yarninward/add-inward/{id}',[YarnInwardController::class,'add_inward']);
    Route::get('admin/yarninward/manage-inward',[YarnInwardController::class,'manage_inward']);
    Route::get('admin/yarninward/manage-inward/{id}',[YarnInwardController::class,'manage_inward']);
    Route::post('admin/yarninward/manage-inward-process',[YarnInwardController::class,'manage_inward_process']);
    Route::post('admin/yarninward/delete',[YarnInwardController::class,'delete']);
    Route::post('admin/yarninward/deleteinwarddetail',[YarnInwardController::class,'deleteinwarddetail']);
    
    Route::get('admin/yarnbill',[YarnBillController::class,'index']);
    Route::get('admin/yarnbill/manage-bill',[YarnBillController::class,'manage_bill']);
    Route::get('admin/yarnbill/manage-bill/{id}',[YarnBillController::class,'manage_bill']);
    Route::post('admin/yarnbill/getChallanDetails',[YarnBillController::class,'getChallanDetails']);
    Route::post('admin/yarnbill/getYarnPO',[YarnBillController::class,'getYarnPO']);
    Route::post('admin/yarnbill/manage-bill-process',[YarnBillController::class,'manage_bill_process']);
    Route::post('admin/yarnbill/delete',[YarnBillController::class,'delete']);

    Route::get('admin/rolainward',[RolaInwardController::class,'index']);
    Route::get('admin/rolainward/manage-rolainward',[RolaInwardController::class,'manage_rolainward']);
    Route::get('admin/rolainward/manage-rolainward/{id}',[RolaInwardController::class,'manage_rolainward']);
    Route::post('admin/rolainward/getChallanDetails',[RolaInwardController::class,'getChallanDetails']);
    Route::post('admin/rolainward/manage-rolainward-process',[RolaInwardController::class,'manage_rolainward_process']);
    Route::post('admin/rolainward/delete',[RolaInwardController::class,'delete']);

    Route::get('admin/rolaoutward',[RolaOutwardController::class,'index']);
    Route::get('admin/rolaoutward/manage-rolaoutward',[RolaOutwardController::class,'manage_rolaoutward']);
    Route::get('admin/rolaoutward/manage-rolaoutward/{id}',[RolaOutwardController::class,'manage_rolaoutward']);
    Route::post('admin/rolaoutward/getChallanDetails',[RolaOutwardController::class,'getChallanDetails']);
    Route::post('admin/rolaoutward/manage-rolaoutward-process',[RolaOutwardController::class,'manage_rolaoutward_process']);
    Route::post('admin/rolaoutward/delete',[RolaOutwardController::class,'delete']);

    Route::get('admin/rolaoutward/stock',[RolaOutwardController::class,'getStock']);
    Route::get('admin/rolaoutward/stockdetail/{id}',[RolaOutwardController::class,'getStockDetail']);

    Route::get('admin/fabricprocess',[FabricProcessController::class,'index']);
    Route::get('admin/fabricprocess/manage-fabricprocess',[FabricProcessController::class,'manage_fabricprocess']);
    Route::get('admin/fabricprocess/manage-fabricprocess/{id}',[FabricProcessController::class,'manage_fabricprocess']);
    Route::post('admin/fabricprocess/manage-fabricprocess-process',[FabricProcessController::class,'manage_fabricprocess_process']);
    Route::post('admin/fabricprocess/delete',[FabricProcessController::class,'delete']);
    
    Route::get('admin/fabricproduct',[FabricProductController::class,'index']);
    Route::get('admin/fabricproduct/manage-fabricproduct',[FabricProductController::class,'manage_fabricproduct']);
    Route::get('admin/fabricproduct/manage-fabricproduct/{id}',[FabricProductController::class,'manage_fabricproduct']);
    Route::post('admin/fabricproduct/manage-fabricproduct-process',[FabricProductController::class,'manage_fabricproduct_process']);
    Route::post('admin/fabricproduct/delete',[FabricProductController::class,'delete']);
    Route::post('admin/fabricproduct/deletepodetail',[FabricProductController::class,'deletepodetail']);

    Route::get('admin/fabricweavervendor',[FabricWeaverVendorController::class,'index']);
    Route::get('admin/fabricweavervendor/manage-vendor',[FabricWeaverVendorController::class,'manage_vendor']);
    Route::get('admin/fabricweavervendor/manage-vendor/{id}',[FabricWeaverVendorController::class,'manage_vendor']);
    Route::post('admin/fabricweavervendor/manage-vendor-process',[FabricWeaverVendorController::class,'manage_vendor_process']);
    Route::post('admin/fabricweavervendor/delete',[FabricWeaverVendorController::class,'delete']);
    Route::post('admin/fabricweavervendor/deletefirm',[FabricWeaverVendorController::class,'deletefirm']);

    Route::get('admin/fabricprocessvendor',[FabricProcessVendorController::class,'index']);
    Route::get('admin/fabricprocessvendor/manage-vendor',[FabricProcessVendorController::class,'manage_vendor']);
    Route::get('admin/fabricprocessvendor/manage-vendor/{id}',[FabricProcessVendorController::class,'manage_vendor']);
    Route::post('admin/fabricprocessvendor/manage-vendor-process',[FabricProcessVendorController::class,'manage_vendor_process']);
    Route::post('admin/fabricprocessvendor/delete',[FabricProcessVendorController::class,'delete']);
    Route::post('admin/fabricprocessvendor/deletefirm',[FabricProcessVendorController::class,'deletefirm']);

    Route::get('admin/leads',[LeadsController::class,'index']);
    Route::get('admin/leads/manage-leads',[LeadsController::class,'manage_leads']);
    Route::get('admin/leads/manage-leads/{id}',[LeadsController::class,'manage_leads']);
    Route::get('admin/leads/view-leads/{id}',[LeadsController::class,'view_leads']);
    Route::post('admin/leads/manage-leads-process',[LeadsController::class,'manage_leads_process']);
    Route::post('admin/leads/delete',[LeadsController::class,'delete']);
    Route::post('admin/leads/deleteleadslogs',[LeadsController::class,'deleteleadslogs']);
    Route::post('admin/leads/next-followup',[LeadsController::class,'next_followup']);

    Route::get('admin/tasks',[TasksController::class,'index']);
    Route::get('admin/tasks/manage-tasks',[TasksController::class,'manage_tasks']);
    Route::get('admin/tasks/manage-tasks/{id}',[TasksController::class,'manage_tasks']);
    Route::get('admin/tasks/view-tasks/{id}',[TasksController::class,'view_tasks']);
    Route::post('admin/tasks/manage-tasks-process',[TasksController::class,'manage_tasks_process']);
    Route::post('admin/tasks/delete',[TasksController::class,'delete']);

    Route::get('admin/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->forget('ADMIN_GROUP_ID');
        session()->forget('ADMIN_GROUP_NAME');
        
        return redirect('admin/login')->with('message','Logout Successfully');
    });

});