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
/*
|--------------------------------------------------------------------------
| Admin Consoel Panel All Routes
|--------------------------------------------------------------------------
*/


// Admin Auth Routes are here

Route::redirect('/business-portal-admin', 'business-portal-admin/admin/dashboard');

Auth::routes(); ///////////************* USE FOR ALL AUTH ROUTES **************** //////////////
Route::prefix('admin')->group(function(){ 
Route::group(['middleware' => 'prevent-back-history'],function(){
    Auth::routes();    
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard')->middleware('auth:admin');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
});
	//Category Routes are here
    Route::resource('category','admin\CategoryController');
    Route::post('/category/delete/', 'admin\CategoryController@destroy')->name('category.delete');
    Route::post('/category/modify/', 'admin\CategoryController@update')->name('category.modify');
    Route::get('/category-active/{cat_id}','admin\CategoryController@active')->name('category.active');
    Route::get('/category-deactive/{cat_id}','admin\CategoryController@deactive')->name('category.deactive');
    //Sub-Category Routes are here
    Route::resource('sub-category','admin\SubCategoryController');
    Route::post('/sub-category/delete/', 'admin\SubCategoryController@destroy')->name('sub.category.delete');
    Route::post('/sub-category/modify/', 'admin\SubCategoryController@update')->name('sub.category.modify');
    Route::get('/sub-category-active/{sub_cat_id}','admin\SubCategoryController@active')->name('sub.category.active');
    Route::get('/sub-category-deactive/{sub_cat_id}','admin\SubCategoryController@deactive')->name('sub.category.deactive');

 	//Brand Routes are here
 	Route::resource('brand','admin\BrandController');   
    Route::post('/brand/delete/', 'admin\BrandController@destroy')->name('brand.delete');
    Route::post('/brand/modify/', 'admin\BrandController@update')->name('brand.modify');
 	Route::get('/brand-active/{brand_id}','admin\BrandController@active')->name('brand.active');
 	Route::get('/brand-deactive/{brand_id}','admin\BrandController@deactive')->name('brand.deactive');
 	//Products Routes are here
    Route::resource('product','admin\ProductController');
    Route::get('/product/delete/{product_id}', 'admin\ProductController@destroy')->name('product.delete');
   
    Route::get('/product-active/{product_id}','admin\ProductController@active')->name('product.active');
 	Route::get('/product-deactive/{product_id}','admin\ProductController@deactive')->name('product.deactive');
    Route::get('/product/image/delete/{product_id}/{img_id}','admin\ProductController@imageDel')->name('product.image.delete');
 	//Settings Routes are here
 	Route::get('/settings','admin\SettingsController@index')->name('admin.settings');
    //Tax Routes are here
    Route::resource('tax','admin\TaxController');
    Route::post('tax/modify/{tax_id}','admin\TaxController@update')->name('tax.modify');
    Route::post('tax/delete/{tax_id}','admin\TaxController@destroy')->name('tax.delete');
    //Unit Routes are here
    Route::resource('unit','admin\UnitController');
    Route::post('unit/modify/{unit_id}','admin\UnitController@update')->name('unit.modify');
    Route::get('unit/delete/{unit_id}','admin\UnitController@destroy')->name('unit.delete');
    //SMS Check Test
    Route::match(['get','post'],'/sms','admin\SmsController@index')->name('sms.api');
    Route::post('/sms/check','admin\SmsController@chksms')->name('sms.check');
    //Orders Routes are here
    Route::get('/orders','admin\OrdersController@index')->name('order.index');
    Route::get('/orders/details/{order_id}','admin\OrdersController@details')->name('order.details');
    Route::get('/orders/dispatched/{order_id}/{associates_id}','admin\OrdersController@dispatched')->name('order.dispatched');
    Route::match(['get','post'],'/orders/delivery/charges','admin\OrdersController@delCharges')->name('order.delivery.charges');    
    //Home Pages Routes are here /// For Apps 
    Route::get('/home/new/product', 'admin\HomePageController@Index_Product')->name('apps.home.page.new.product');
    Route::post('/home/new/product/add', 'admin\HomePageController@add_Product')->name('apps.home.page.new.product.add');
    Route::get('/home/new/product/delete/{product_id}', 'admin\HomePageController@del_Product')->name('apps.home.page.new.product.del');
                    ///product End here
                    ///category Start here
    Route::get('/home/new/category/', 'admin\HomePageController@Index_Category')->name('apps.home.page.category');
    Route::post('/home/new/category/add', 'admin\HomePageController@add_Category');
    Route::post('/home/new/category/delete', 'admin\HomePageController@del_Category');
    //Delivey Associates Start here
    Route::get('/delivery/associates', 'admin\DeliveryController@index')->name('delivery.index');
    Route::post('/delivery/associates/store/', 'admin\DeliveryController@store')->name('delivery.associates.store');
    Route::post('/delivery/associates/update', 'admin\DeliveryController@update')->name('delivery.update');
    Route::post('/delivery/associates/destroy', 'admin\DeliveryController@destroy')->name('delivery.destroy');
    //Delivey Associates Start here
    Route::get('/users/', 'admin\UserController@index')->name('user.index');
    //Store Location Start here
    Route::get('/store/', 'admin\StoreController@index')->middleware('auth:admin')->name('store.index');
    Route::post('/store/create', 'admin\StoreController@create')->middleware('auth:admin')->name('store.create');
    Route::get('/store/delete/{store_id}', 'admin\StoreController@delete')->middleware('auth:admin')->name('store.delete');

    
});
/*
|--------------------------------------------------------------------------
| Delivery ALL Routes
|--------------------------------------------------------------------------s
*/
Route::prefix('delivery')->group(function(){
Route::redirect('', '/delivery/login');
Auth::routes(); 
Route::get('/login','delivery_associates\LoginController@loginform')->name('delivery.login.form');
Route::post('/login','delivery_associates\LoginController@login')->name('delivery.login');
Route::post('/login/confirm','delivery_associates\LoginController@confirm')->name('delivery.login.confirm');
Route::post('/logout','delivery_associates\LoginController@logout')->name('delivery.logout');
Route::post('/setpin','delivery_associates\LoginController@setpin')->name('delivery.setpin');
Route::get('/dashboard','delivery_associates\HomeController@index')->name('delivery.dashboard')->middleware('auth:delivery');
Route::get('/order/details/{order_id}','delivery_associates\HomeController@orderDetails')->name('delivery.order.details')->middleware('auth:delivery');
Route::get('/order/return/{order_id}/{product_id}','delivery_associates\HomeController@orderReturn')->name('delivery.order.return')->middleware('auth:delivery');
Route::get('/order/confirm/{order_id}/','delivery_associates\HomeController@confirmOrder')->name('delivery.order.confirm')->middleware('auth:delivery');
Route::get('/all','delivery_associates\HomeController@alldelivery')->name('delivery.all')->middleware('auth:delivery');
Route::get('/all/details/{order_id}','delivery_associates\HomeController@deliveryDetails')->name('delivery.all.details')->middleware('auth:delivery');
});
