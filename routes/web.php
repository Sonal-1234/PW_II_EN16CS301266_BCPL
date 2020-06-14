<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', function () {
    if (Auth::check()):
        return redirect()->route('dashboard');
    endif;
    return view('auth.login');
});

Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    //organizations routes
    Route::get('/organizations', 'OrganizationController@index')->name('organizations');
    Route::get('/organizations/add', 'OrganizationController@add')->name('organizations-add');
    Route::post('/organizations/store', 'OrganizationController@store')->name('organizations-store');
    Route::post('/organizations/update/{id}', 'OrganizationController@update')->name('organizations-update');
    Route::get('/organizations/edit/{id}', 'OrganizationController@edit')->name('organizations-edit');
    Route::get('/organizations/show', 'OrganizationController@show')->name('organizations-show');
    Route::get('/organizations/lists', 'OrganizationController@lists')->name('organizations-lists');

    //users
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/add', 'UserController@add')->name('users-add');
    Route::post('/users/store', 'UserController@store')->name('user-store');
    Route::post('/users/update/{id}', 'UserController@update')->name('user-update');
    Route::get('/users/edit/{id}', 'UserController@edit');
    Route::get('/users/delete/{id}', 'UserController@delete');
    Route::get('/users/lists', 'UserController@lists')->name('users-lists');

    //product routes
    Route::get('/products', 'ProductController@index')->name('products');
    Route::get('/products/add', 'ProductController@add')->name('products-add');
    Route::get('/products/create', 'ProductController@create')->name('products-create');
    Route::post('/products/store', 'ProductController@store')->name('products-store');
    Route::post('/products/update', 'ProductController@update')->name('products-update');
    Route::get('/products/edit/{id}', 'ProductController@edit')->name('products-edit');
    Route::get('/products/delete/{id}', 'ProductController@destroy')->name('products-delete');
    Route::get('/products/lists', 'ProductController@lists')->name('products-lists');
    Route::get('/products/details/{id}/{quantity}', 'ProductController@details')->name('products-details');

    //customer routes
    Route::get('/customers', 'CustomerController@index')->name('customers');
    Route::get('/customers/add', 'CustomerController@addCustomer')->name('customers-add');
    Route::post('/customers/store', 'CustomerController@store')->name('customers-store');
    Route::post('/customers/account/add', 'CustomerController@addAccount')->name('customers-account-add');
    Route::post('/customers/billing/add', 'CustomerController@addBilling')->name('add-billing');
    Route::post('/customers/update', 'CustomerController@update')->name('customers-update');
    Route::post('/customers/company/update', 'CustomerController@companyUpdate')->name('customers-company-update');
    Route::post('/customers/address/update', 'CustomerController@addressUpdate')->name('customers-address-update');
    Route::get('/customers/delete/{id}', 'CustomerController@destroy')->name('customers-delete');
    Route::get('/customers/edit/{id}', 'CustomerController@edit')->name('customers-edit');
    Route::get('/customers/company/edit/{id}', 'CustomerController@companyEdit')->name('customers-company-edit');
    Route::get('/customers/address/edit/{id}', 'CustomerController@addressEdit')->name('customers-address-edit');
    Route::get('/customers/show/{id}', 'CustomerController@show')->name('customers-show');
    Route::get('/customers/lists', 'CustomerController@lists')->name('customers-lists');
    Route::get('/customers/services/lists/{id}', 'CustomerController@serviceLists')->name('customers-services-lists');
    Route::get('/customers/services/edit/{id}', 'CustomerController@serviceEdit')->name('customers-services-edit');
    Route::post('/customers/services/update', 'CustomerController@serviceUpdate')->name('customers-service-update');
    Route::get('/customers/billing/lists/{id}', 'CustomerController@billingLists')->name('customers-billing-lists');
    Route::get('/customers/purchase/lists/{id}', 'CustomerController@purchaseOrderLists')->name('customers-purchase-orders-lists');
    Route::get('/customers/details/{id}', 'CustomerController@details')->name('customers-details');
    Route::get('/customers/change/account/status/{id}/{value}', 'CustomerController@changeAccountStatus');
    Route::get('/customers/change/due/reminder/status/{id}/{value}', 'CustomerController@changeDueInvoiceReminderStatus');
    Route::get('/customers/change/reminder/status/{id}/{value}', 'CustomerController@changeInvoiceReminderStatus');

    //order routes
    Route::get('/purchase/orders', 'PurchaseOrderController@index')->name('purchase-orders');
    Route::get('/purchase/orders/create', 'PurchaseOrderController@create')->name('purchase-create');
    Route::get('/custom/purchase/orders/create', 'PurchaseOrderController@customCreate')->name('custom-purchase-create');
    Route::post('/purchase/store', 'PurchaseOrderController@store')->name('purchase-store');
    Route::post('/custom/purchase/store', 'PurchaseOrderController@customStore')->name('custom-purchase-store');
    Route::post('/purchase/update', 'PurchaseOrderController@update')->name('purchase-update');
    Route::get('/purchase/show/{id}', 'PurchaseOrderController@show')->name('purchase-show');
    Route::get('/purchase/edit/{id}', 'PurchaseOrderController@edit')->name('purchase-edit');
    Route::get('/purchase/destroy/{id}', 'PurchaseOrderController@destroy')->name('purchase-destroy');
    Route::get('/purchase/orders/list', 'PurchaseOrderController@lists')->name('purchase-orders-lists');
    Route::get('/purchase/item/details/{id}/{quantity}', 'PurchaseOrderController@itemCalculationDetails')->name('products-item-details');
    Route::get('/purchase/service/details/{plan}/{frequency}', 'PurchaseOrderController@serviceCalculationDetails')->name('products-service-details');

    //payments routes
    Route::get('/payments', 'PaymentController@index')->name('payments');
    Route::get('/payments/lists', 'PaymentController@lists')->name('payments-lists');
    Route::post('/payments/store', 'PaymentController@store')->name('payments-store');
    Route::get('/payments/invoice/{poNumber}', 'PaymentController@invoice');
});
