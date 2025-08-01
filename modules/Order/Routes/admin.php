<?php

use Illuminate\Support\Facades\Route;

Route::get('orders', [
    'as' => 'admin.orders.index',
    'uses' => 'OrderController@index',
    'middleware' => 'can:admin.orders.index',
]);

Route::get('orders/{id}', [
    'as' => 'admin.orders.show',
    'uses' => 'OrderController@show',
    'middleware' => 'can:admin.orders.show',
]);

Route::put('orders/{id}', [
    'as' => 'admin.orders.update',
    'uses' => 'OrderController@update',
    'middleware' => 'can:admin.orders.edit',
]);

Route::get('orders/index/table', [
    'as' => 'admin.orders.table',
    'uses' => 'OrderController@table',
    'middleware' => 'can:admin.orders.index',
]);

Route::put('orders/{order}/status', [
    'as' => 'admin.orders.status.update',
    'uses' => 'OrderStatusController@update',
    'middleware' => 'can:admin.orders.edit',
]);

Route::post('orders/{order}/email', [
    'as' => 'admin.orders.email.store',
    'uses' => 'OrderEmailController@store',
    'middleware' => 'can:admin.orders.show',
]);

Route::get('orders/{order}/print', [
    'as' => 'admin.orders.print.show',
    'uses' => 'OrderPrintController@show',
    'middleware' => 'can:admin.orders.show',
]);

Route::post('/order-products/{order_product}/update-license', [\Modules\Order\Http\Controllers\Admin\OrderProductLicenseController::class, 'update'])
    ->name('admin.order_products.update_license')
    ->middleware('can:admin.orders.edit');
