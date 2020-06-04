<?php
use Illuminate\Support\Facades\Auth;
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
    
    if (Auth::check()) {

        if(Auth::user()->user_type == "admin"){

            return redirect()->route('admin-dashboard');
            
        }
        
        return redirect()->route('user-dashboard');
    }

    return view('auth.login');

});


Auth::routes();

Route::post('register-user', 'Auth\RegisterController@registerUser')->name('register.user');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/recipient', 'MessageController@recipient')->name('recipient');

Route::post('/recipient/message', 'MessageController@sendMsg')->name('to-recipient');

// Print
Route::get('/print/{id}/{requestor}', 'PrintController@view_print')->name('view.pdf');

Route::group(['middleware' => ['auth', 'user']], function(){
    
    //User View
    Route::get('/user-view/{id}/{requestor}', 'PrintController@index')->name('view.prform');

    //User Dashboard
    Route::get('/user/dashboard', 'User\UserDashboardController@index')->name('user-dashboard');

    //User Form
    Route::get('/user/form', 'User\UserFormController@index')->name('user-form');
    Route::post('/user/form', 'User\UserFormController@store')->name('insert.products');
    
    //User Requested
    Route::get('/search/request', 'User\UserRequestController@search')->name('search-request');
    Route::get('/user/request', 'User\UserRequestController@index')->name('user-request');
    Route::put('/user/delete', 'User\UserRequestController@delete')->name('request.delete');
    
    //User Send
    Route::get('/user/{id}/{requestor}', 'User\UserSendController@index')->name('user-send');
    Route::post('/user/insert', 'User\UserSendController@addProduct')->name('add.product');
    Route::put('/user/approval'. 'User\UserSendController@approval')->name('request.approval');
    Route::put('/user/pr', 'User\UserSendController@savePR')->name('save.pr');
    Route::put('/user/save_product', 'User\UserSendController@saveProduct')->name('save.product');
    Route::put('/user/requested', 'User\UserSendController@requested')->name('requested.pr');
    Route::delete('/user/delete', 'User\UserSendController@destroy')->name('delete.product');
    
    //User Requested
    Route::get('/user/requested', 'User\UserRequestedController@index')->name('user-requested');
    Route::get('/search/requested', 'User\UserRequestedController@search')->name('search-requested');
    
    //User Approved
    Route::get('/user/approved', 'User\ApprovedController@index')->name('user-approved');
    Route::get('/search/approved', 'User\ApprovedController@search')->name('search-approved');

     //User Approved
     Route::get('/user/rejected', 'User\UserRejectedController@index')->name('user-rejected');
     Route::get('/search/rejected', 'User\UserRejectedController@search')->name('search-rejected');

     //User Edit
     Route::get('/user-edit/{id}/{series}', 'User\UserEditController@index')->name('user-edit');
    
    //User Resend
    Route::get('/user-resend/{id}/{requestor}', 'User\UserSendController@resend')->name('user-resend');
    Route::post('/user/resend/pr', 'User\UserSendController@store')->name('user.resend');

    //User Delete attachment
    Route::delete('user-delete/attachment', 'AttachmentController@delete')->name('delete.attachment');
    Route::post('user-attach/attachment', 'AttachmentController@storeAttach')->name('store.attachment');

    //User Profile
    Route::get('user/profile/{id}/{name}', 'User\UserDashboardController@profile')->name('user.profile');
    Route::post('user/upload', 'User\UserDashboardController@upload')->name('user.upload-image');
    Route::put('user/save-profile', 'User\UserDashboardController@save_profile')->name('user.save-profile');

    Route::get('user/inbox', 'MessageController@userInbox')->name('user-inbox');
    Route::get('message/{id}/{name}', 'MessageController@userMessage')->name('user-message');

    Route::post('user/reply', 'MessageController@userReply')->name('user-reply');
    Route::put('message/status/user', 'MessageController@msgUser')->name('msg.status-user');

});



Route::group(['middleware' => ['auth', 'admin']], function(){

    //Admin View
    Route::get('/admin-view/{id}/{requestor}', 'PrintController@adminIndex')->name('view.admin-prform');
    Route::get('/admin/messages/{id}/{requestor}', 'MessageController@admin')->name('view.admin-messages');

    //Admin Dashboard
    Route::get('/admin/dashboard', 'Admin\AdminDashboardController@index')->name('admin-dashboard');

    //Admin Pending
    Route::get('/admin/pending', 'Admin\AdminPendingController@index')->name('admin-pending');
    Route::post('/admin/insert', 'Admin\AdminPendingController@addProduct')->name('admin.add');
    Route::put('/admin/save_product', 'Admin\AdminPendingController@saveProduct')->name('admin.save');
    Route::delete('/admin/delete', 'Admin\AdminPendingController@destroy')->name('admin.delete');

    //Admin Requested
    Route::get('/admin/approved', 'Admin\AdminRequestedController@index')->name('admin-approved');


    //Admin Deleted
    Route::get('/admin/rejected', 'Admin\AdminDeletedController@index')->name('admin-removed');
    Route::put('/admin/restored', 'Admin\AdminDeletedController@restore')->name('admin-restored');
    

    //Admin View
    Route::get('/admin/pending/{id}', 'Admin\AdminPendingController@view')->name('admin-view');
    Route::put('/admin/approve', 'Admin\AdminPendingController@approve')->name('admin.approve');
    Route::put('/admin/remove', 'Admin\AdminPendingController@remove')->name('admin.remove');
    Route::put('/admin/delete', 'Admin\AdminPendingController@deleted')->name('admin.deleted');


    //Admin Check
    Route::get('/admin/checks', 'Admin\AdminCheckController@index')->name('admin-check');
    Route::put('/admin/update-issue', 'Admin\AdminCheckController@issue')->name('admin.issue');
    Route::put('/admin/checks-revert', 'Admin\AdminCheckController@revert')->name('admin.revert');
    Route::put('/admin/checks-edit', 'Admin\AdminCheckController@edit')->name('admin.edit');


    //Admin Search
    Route::get('/pending/admin', 'Admin\AdminPendingController@search')->name('pending.search');
    Route::get('/approve/admin', 'Admin\AdminRequestedController@search')->name('approve.search');
    Route::get('/remove/admin', 'Admin\AdminDeletedController@search')->name('remove.search');
    Route::get('/check/admin', 'Admin\AdminCheckController@search')->name('check.search');

    //User Delete attachment
    Route::delete('admin-delete/attachment', 'AttachmentController@delete')->name('admin-delete.attachment');
    Route::post('admin-attach/attachment', 'AttachmentController@storeAttach')->name('admin-store.attachment');
    

    Route::get('admin/attachment/view', 'Admin\AdminPendingController@viewAttachment')->name('show-attachment');
    Route::get('admin/profile/{id}/{name}', 'Admin\AdminDashboardController@profile')->name('admin.profile');
    Route::post('admin/upload', 'Admin\AdminDashboardController@upload')->name('admin.upload-image');
    Route::put('admin/save-profile', 'Admin\AdminDashboardController@save_profile')->name('admin.save-profile');

    Route::get('messages/{id}/{name}', 'MessageController@adminMessage')->name('admin-message');
    Route::post('admin/reply', 'MessageController@adminReply')->name('admin-reply');
    Route::get('admin/inbox', 'MessageController@adminInbox')->name('admin-inbox');
    Route::put('message/status', 'MessageController@msgAdmin')->name('admin-msg');

    Route::get('admin/accounts', 'Admin\AdminDashboardController@accounts')->name('admin-users');
    Route::put('admin/approve-user', 'Admin\AdminDashboardController@approveUser')->name('admin.approveUser');

});


Route::group(['middleware', ['auth', 'sa']], function(){

   
    Route::get('/sa/dashboard', 'SuperAdmin\SuperAdminController@dashboard')->name('sa-dashboard');

    Route::get('/sa/pending', 'SuperAdmin\SuperAdminController@pending')->name('sa-pending');

    Route::get('/sa/admins', 'SuperAdmin\SuperAdminController@admins')->name('sa-admins');

    Route::get('/sa/users', 'SuperAdmin\SuperAdminController@users')->name('sa-users');


});



