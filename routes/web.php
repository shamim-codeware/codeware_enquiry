<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\EnqueryController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\ShowRoomController;
use App\Http\Controllers\UpazillaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DueEnquiryController;
use App\Http\Controllers\EnquiryTypeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\PurchaseModeController;
use App\Http\Controllers\EnquirySourceController;
use App\Http\Controllers\EnquiryStatusController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\FollowUpMethodController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CustomerProfessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('migrate', function (){
    Artisan::call('cache:clear');
    // echo "Cache cleared
    Artisan::call('view:clear');
    // echo "View cleared

    Artisan::call('config:cache');
    // echo "Config cleared

    Artisan::call('route:cache');
    // echo "Route cleared

  \dd("done");
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget_password');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::group(['middleware' => 'auth'], function () {
  Route::get('/generate-notifications',[NotificationsController::class,'GenerateNotification']);

    //Route::get('/due-enquery',[DueEnquiryController::class]);
    Route::get('home', [DashboardController::class, 'index'])->name('home');
  //  Route::get('enquiry', [EnquiryController::class, 'index'])->name('enquiry');
    Route::get('notifications', [NotificationsController::class, 'notifications'])->name('notifications');
    Route::get('clear-all', [NotificationsController::class, 'ClearAll'])->name('clearAll');
    Route::get('notifications-details/{id}/{notification_id}',[NotificationsController::class,'NotificaionDetails']);

    Route::get('pre-booking',           [EnquiryController::class, 'preBooking'])->name('pre-booking');
    Route::post('store-enquiry',        [EnquiryController::class,'Store']);
    Route::post('customer-enquiry',     [EnquiryController::class,'CustomerEnquiry']);
    Route::post('source-awareness',     [EnquiryController::class,'SourcesOfAwreness']);
    Route::post('find-upazila',         [ShowRoomController::class,'FindUpazila']);
    Route::get('follow-up',             [FollowUpController::class, 'index'])->name('follow-up');
    Route::get('attend-follow-up/{id}', [FollowUpController::class,'show']);
    Route::post('child-status',         [FollowUpController::class,'ChildStatus']);
    Route::post('update-follow/{id}',   [FollowUpController::class,'update']);
    // User
    Route::get('user/profile/{id}',         [UserController::class, 'Profile'])->name('user.profile');
    Route::post('user/profile-update/{id}', [UserController::class, 'UpdateProfile'])->name('user.profile.update');
    Route::get('change-password/{id}',      [UserController::class, 'ChangePassword'])->name('password.change');
    Route::post('update-password',          [UserController::class, 'UpdatePassword'])->name('password.update');

    Route::get('user-pass-change/{id}',      [UserController::class, 'UserPasswordChange'])->name('password.change');

    Route::post('update-password-user/{id}',  [UserController::class, 'UpdatePasswordUser'])->name('password.update.user');
    // Enquiry status parent assign
    Route::get('enquiry-status-setting',        [EnquiryStatusController::class, 'statusSetting'])->name('enquiry-status-settings');
    Route::post('enquiry-status-parent-assign', [EnquiryStatusController::class, 'parentAssign'])->name('parent-assign');
    Route::get('status-type/{type_id}',         [EnqueryController::class, 'statusType'])->name('status-type');
  // Role Permission

    Route::get('source-permission',          [RoleController::class, 'SourcePermission'])->name('source-permission');
    Route::get('check-permission/{user_id}',          [RoleController::class, 'CehckPermission'])->name('check-permission');
    Route::post('source-assign', [RoleController::class, 'SourceAssign']);

    Route::get('menu-permission',          [RoleController::class, 'menuPermission'])->name('menu-permission');
    Route::get('menu-assign/{role_id}',    [RoleController::class, 'menuAssign'])->name('menu-assign');
    Route::post('menu-permission-assign',  [RoleController::class, 'menuPermissionAssign'])->name('menu-permission-assign');

    Route::get('menu-entry',  [RoleController::class, 'menu_entry']);
    // All resources route here

    Route::get('user-export',[UserController::class,'export'] )->name('user.export');
    Route::get('user-export-active',[UserController::class,'Activeexport'] )->name('active.user.export');

    Route::get('customer-export',[CustomerController::class,'export'] );
    Route::get('passed-over-enquiries-export',[EnqueryController::class,'Passedexport']);
    Route::get('showroom-export',[ShowRoomController::class,'ShowroomExport']);
    Route::get('enquiry-export',[EnqueryController::class,'export'] )->name('enquiry.export');
    Route::get('pending-enquiries-export', [EnqueryController::class, 'PendingEnquiryExport']);

    Route::middleware(['check.permission'])->group(function () {
        Route::resources([
            'enquiry-type'        => EnquiryTypeController::class,
            'enquiry-source'      => EnquirySourceController::class,
            'customer-type'       => CustomerTypeController::class,
            'purchase-mode'       => PurchaseModeController::class,
            'follow-up-method'    => FollowUpMethodController::class,
            'enquiry-status'      => EnquiryStatusController::class,
            'zones'               => ZoneController::class,
            'show-rooms'          => ShowRoomController::class,
            'enquiry'             => EnqueryController::class,
            'roles'               => RoleController::class,
            'customer'            => CustomerController::class,
            'user'                 => UserController::class,
            'customer-profession' => CustomerProfessionController::class,
            'upazila'             => UpazillaController::class,
            'product'            => ProductController::class,
            'category'           => ProductCategoryController::class,
            'group'              => ProductTypeController::class,
        ]);
    });

    Route::get('active-user-manager',[UserController::class,'ActiveUserManager'] )->name('user.active.manager');
    Route::get('active-user-executive',[UserController::class,'ActiveUserExecutive'] )->name('user.active.executive');
    Route::get('active-user-admin',[UserController::class,'ActiveUserAdmin'] )->name('user.active.admin');
    // Enquiry settings
    Route::get('/enquiry-status-settings',[EnquiryStatusController::class,'statusSetting'])->name('enquiry-status-setting');
    // Ajax enquiry
    Route::get('enquiries',             [EnqueryController::class, 'enquiries'])->name('enquiries');
    Route::get('passed-over',           [EnqueryController::class, 'passedOver'])->name('passed-over');
    Route::get('pending-enquiry',       [EnqueryController::class, 'Pending'])->name('pending-enquiry');
     Route::get('pending-enquiries',   [EnqueryController::class, 'PendingEnquiry'])->name('pending-enquiries');
    Route::get('passed-over-enquiries', [EnqueryController::class, 'passedOverEnquiries'])->name('passed-over-enquiries');
    Route::post('select-executive',     [EnquiryController::class,'SelectExecutive']);
    Route::post('select-showroom',      [DashboardController::class,'SelectShowroom']);
    Route::post('todays-followup',      [DashboardController::class,'TodaysfollowUp']);
    Route::post('enquiry-statistics',[DashboardController::class, 'EnquiryStatistics']);
    Route::post('source-statistics', [DashboardController::class, 'SourceStatistics']);

    Route::post('query-type',      [ProductTypeController::class, 'QueryType']);
    Route::post('query-category',      [ProductCategoryController::class, 'QueryCategory']);
    Route::post('query-product',      [ProductController::class, 'QueryProduct']);
    Route::post('/check-status',[FollowUpController::class,'StatusCheck']);
    Route::post('/check-status-all', [FollowUpController::class, 'CheckStatusAll']);

    Route::get('import/enquiry', function () {
        return view('pages.enquiry.import');
    });
    Route::post('/import-enquiry', [ImportController::class, 'import']);

    // Status
    Route::get('enquiry-type-status/{id}',        [EnquiryTypeController::class, 'status'])->name('enquiry-type-status');
    Route::get('enquiry-source-status/{id}',      [EnquirySourceController::class, 'status'])->name('enquiry-source-status');
    Route::get('purchase-mode-status/{id}',       [PurchaseModeController::class, 'status'])->name('purchase-mode-status');
    Route::get('follow-up-method-status/{id}',    [FollowUpMethodController::class, 'status'])->name('follow-up-method-status');
    Route::get('customer-profession-status/{id}', [CustomerProfessionController::class, 'status'])->name('customer-profession-status');
    Route::get('customer-status/{id}',            [CustomerController::class, 'status'])->name('customer-status');
    Route::get('zone-status/{id}',                [ZoneController::class, 'status'])->name('zone-status');
    Route::get('role-status/{id}',                [RoleController::class, 'status'])->name('role-status');
    Route::get('user-status/{id}',                [UserController::class, 'status'])->name('user-status');
    Route::get('showroom-status/{id}',            [ShowRoomController::class, 'status'])->name('showroom-status');
    Route::get('data-backup',[BackupController::class,'DataBackup']);
    Route::get('backup-product', [BackupController::class, 'DataProductBackup']);

});

Route::get('/lang/{lang}', [LanguageController::class, 'switchLang'])->name('switch_lang');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
