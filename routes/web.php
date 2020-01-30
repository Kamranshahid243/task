<?php

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

Route::prefix('admin')->namespace('Auth')->group(function () {

    // Authentication Routes...
    Route::get('/', 'Admin\LoginController@showLoginForm')->name('login');
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Admin\LoginController@login');
    Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Admin\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Admin\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Admin\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Admin\ResetPasswordController@reset')->name('password.update');
});

Route::prefix('admin')->namespace('Admin')->group(function () {

    // Customer routes
    Route::resource('/customers', 'CustomerController');
    Route::post('/customers/block/{id}', 'CustomerController@block');
    Route::post('/customers/unblock/{id}', 'CustomerController@unblock');

    // Admin routes
    Route::resource('/users/management', 'AdminController');
    Route::post('/users/management/{id}/block', 'AdminController@block');
    Route::post('/users/management/{id}/unblock', 'AdminController@unblock');
//    Category Management
    Route::resource('/ad-categories','AdCategoryController');//

    //    Category Management
    Route::resource('/ad-sub-categories','AdSubCategoryController');

    // Package routes
    Route::resource('/packages', 'PackageController');
    Route::post('/packages/block/{id}', 'PackageController@block');
    Route::post('/packages/unblock/{id}', 'PackageController@unblock');

    // Service routes
    Route::resource('/services', 'ServiceController');
    Route::post('/services/block/{id}', 'ServiceController@block');
    Route::post('/services/unblock/{id}', 'ServiceController@unblock');

    // Package Extras  routes
    Route::resource('/extras', 'ExtraController');
    Route::post('/extras/block/{id}', 'ExtraController@block');
    Route::post('/extras/unblock/{id}', 'ExtraController@unblock');




    // Testimonials  routes
    Route::resource('/testimonials', 'TestimonialController');
    Route::post('/testimonials/approve/{id}', 'TestimonialController@approve');
    Route::post('/testimonials/disapprove/{id}', 'TestimonialController@disapprove');

    // Support Ticket  routes
    Route::get('/tickets/attachment/delete/{id}', 'TicketController@deleteAttachment');
    Route::get('/ticket/attachment/download/{id}', 'TicketController@download');
    Route::post('/tickets/reply/delete/{id}', 'TicketController@destroy');
    Route::post('/tickets/reply/update/{id}', 'TicketController@update');
    Route::get('/tickets/reply/edit/{id}', 'TicketController@edit');
    Route::post('/tickets/open/{id}', 'TicketController@open');
    Route::post('/tickets/close/{id}', 'TicketController@close');
    Route::post('/tickets/reply/{id}', 'TicketController@reply');
    Route::get('/tickets/{id}', 'TicketController@show');
    Route::get('/tickets', 'TicketController@index');

    // Blog Post routes
    Route::resource('/blog/posts', 'PostController');
    Route::get('/blog/posts/{id}/view', 'PostController@view');
    Route::post('/blog/posts/attachment/upload', 'PostController@upload');
    Route::post('/blog/posts/hide/{id}', 'PostController@hidden');
    Route::post('/blog/posts/show/{id}', 'PostController@visible');

    // Tutorial routes
    Route::resource('/tutorials', 'TutorialController');
    Route::get('/tutorials/{id}/view', 'TutorialController@view');
    Route::post('/tutorials/attachment/upload', 'TutorialController@upload');
    Route::post('/tutorials/hide/{id}', 'TutorialController@hidden');
    Route::post('/tutorials/show/{id}', 'TutorialController@visible');

    // Task routes
    Route::get('/tasks/{id}/assign', 'TaskController@assign');
    Route::post('/tasks/assign/update', 'TaskController@assignUpdate');
    Route::resource('/tasks', 'TaskController');
    Route::get('/tasks/attachment/delete/{id}', 'TaskController@deleteAttachment');
    Route::get('/tasks/{id}/view', 'TaskController@view');
    Route::post('/tasks/attachment/upload', 'TaskController@upload');
    Route::post('/tasks/hide/{id}', 'TaskController@hidden');
    Route::post('/tasks/show/{id}', 'TaskController@visible');

    // Social link routes
    Route::resource('/sociallinks', 'SocialController');

    // Company settings routes
    Route::get('/company/address', 'CompanyController@viewAddress');
    Route::get('/company/privacy', 'CompanyController@viewPrivacy');
    Route::get('/company/terms', 'CompanyController@viewTerms');
    Route::post('/company/address/update', 'CompanyController@updateAddress');
    Route::post('/company/privacy/update', 'CompanyController@updatePrivacy');
    Route::post('/company/terms/update', 'CompanyController@updateTerms');
    Route::resource('/company', 'CompanyController');

    Route::resource('/company/emails', 'CompanyEmailController');
    Route::resource('/company/phones', 'CompanyPhoneController');


    // Email
    Route::resource('/email-templates', 'EmailController');


//    Route::post('/email-template','EmailController@storeTemplate');
//    Route::get('/role','RoleController@index');
//    Route::post('/email-update-form','EmailController@emailUpdateForm');
//    Route::get('/load-email-templates','EmailController@loadEmailTemplates');

//    Route::post('/ad-management','AdController@store');
//    Route::get('/load-ads','AdController@load');
    // Logged In Admin Routes
    Route::get('/profile', 'ProfileController@index');
//    Route::get('/test', 'ProfileController@test');
//    Route::get('/ad-management', 'AdController@load');
    Route::post('/profile/update', 'ProfileController@update');
    Route::get('/password', 'PasswordController@showPasswordResetForm');
    Route::post('/password/update', 'PasswordController@passwordUpdate');
    Route::get('/search/{searchQuery}', 'AdminController@search');


    Route::post('/security/password/expiry/{status}', 'securityController@passwordExpiry');
    Route::post('/security/login/approval/code/{status}', 'securityController@loginApprovalCode');
    Route::post('/security/otp/{status}', 'securityController@otp');
    Route::get('/security/settings', 'securityController@showSecurityForms');

    // Notifications routes
    Route::post('/notifications/{id}', 'NotificationController@destroy');
    Route::get('/notifications', 'NotificationController@index');


    // Pricing routes
    Route::resource('/countries/pricings', 'CountryPricingController');
    Route::resource('/states/pricings', 'StatePricingController');
    Route::resource('/cities/pricings', 'CityPricingController');


    // Categories routes
    Route::resource('/categories/management', 'CategoryController');
    Route::post('/categories/management/pause/{id}', 'CategoryController@pause');
    Route::post('/categories/management/play/{id}', 'CategoryController@play');

    //Ads
    Route::get('/ads/subcat-metadata','AdsController@SubCatDetails')->name('adDetails');
    Route::resource('/ads','AdsController');
    Route::get('/ads-metadata','AdsController@adMetadataForm');

    // Subcategories routes
    Route::resource('/subcategories/management', 'SubcategoryController');

//    subcategories details
    Route::resource('/subcategories/metadata', 'SubcategoryMetadataController');

    // Plans routes
    Route::resource('/plans/management', 'PlanController');

    // FAQs  routes
    Route::resource('/faqs/management', 'FaqController');

    // Dashboard Route...
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/routes', 'DashboardController@routes');

});

Route::get('/get/{id}/states/', 'Common\LocationController@getStates');
Route::get('/get/{id}/cities/', 'Common\LocationController@getCities');
