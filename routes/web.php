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
//Frontend 
Route::get('/', 'HomeController@index');
Route::get('/trang-chu', 'HomeController@index');
Route::get('/404', 'HomeController@error_page');
Route::post('/tim-kiem', 'HomeController@search');
Route::post('/autocomplete-ajax', 'HomeController@autocomplete_ajax');
Route::get('/yeu-thich','HomeController@yeu_thich');




Route::get('create-transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');

Route::get('create-transaction', 'PayPalController@createTransaction')->name('createTransaction');
Route::get('process-transaction',  'PayPalController@processTransaction')->name('processTransaction');
Route::get('success-transaction', 'PayPalController@successTransaction')->name('successTransaction');
Route::get('cancel-transaction', 'PayPalController@cancelTransaction')->name('cancelTransaction');

// Contact
Route::get('/lien-he', 'ContactController@lien_he');
Route::get('/information', 'ContactController@information');
Route::post('/save-info', 'ContactController@save_info');
Route::post('/update-info/{info_id}', 'ContactController@update_info');

//Category
Route::get('/danh-muc/{slug_category_product}', 'CategoryProduct@show_category_home');
Route::get('/thuong-hieu/{brand_slug}', 'BrandProduct@show_brand_home');
Route::get('/chi-tiet/{product_slug}', 'ProductController@details_product');

//Backend
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard', 'AdminController@show_dashboard');
Route::get('/logout', 'AdminController@logout');

Route::post('/filter-by-date', 'AdminController@filter_by_date');
Route::post('/dashboard-filter', 'AdminController@dashboard_filter');
Route::post('/days-order', 'AdminController@days_order');
Route::post('/admin-dashboard', 'AdminController@dashboard');


//Category Product
Route::get('/add-category-product', 'CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}', 'CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}', 'CategoryProduct@delete_category_product');
Route::get('/all-category-product', 'CategoryProduct@all_category_product');

Route::post('/export-csv', 'CategoryProduct@export_csv');
Route::post('/import-csv', 'CategoryProduct@import_csv');


Route::get('/unactive-category-product/{category_product_id}', 'CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}', 'CategoryProduct@active_category_product');

//Send Mail 
Route::get('/send-mail', 'HomeController@send_mail');


//Login facebook
Route::get('/login-facebook', 'AdminController@login_facebook');
Route::get('/admin/callback', 'AdminController@callback_facebook');

//Login google admin
Route::get('/login-google', 'AdminController@login_google');
Route::get('/google/callback', 'AdminController@callback_google');
//Login customer google
Route::get('/login-customer-google', 'AdminController@login_customer_google');
Route::get('/customer/google/callback', 'AdminController@callback_customer_google');
//
Route::post('/save-category-product', 'CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}', 'CategoryProduct@update_category_product');

Route::post('/product-tabs', 'CategoryProduct@product_tabs');


//Brand Product
Route::get('/add-brand-product', 'BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}', 'BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}', 'BrandProduct@delete_brand_product');
Route::get('/all-brand-product', 'BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}', 'BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}', 'BrandProduct@active_brand_product');

Route::post('/save-brand-product', 'BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}', 'BrandProduct@update_brand_product');


//Product
Route::group(['middleware' => 'auth.roles'], function () {
	Route::get('/add-product', 'ProductController@add_product');
	Route::get('/edit-product/{product_id}', 'ProductController@edit_product');
});
Route::get('users', 'UserController@index')->middleware('auth.roles');
Route::get('add-users', 'UserController@add_users')->middleware('auth.roles');

Route::get('delete-user-roles/{admin_id}', 'UserController@delete_user_roles')->middleware('auth.roles');
Route::post('store-users', 'UserController@store_users');
Route::post('assign-roles', 'UserController@assign_roles')->middleware('auth.roles');

Route::get('impersonate/{admin_id}', 'UserController@impersonate');
Route::get('impersonate-destroy', 'UserController@impersonate_destroy');


Route::get('/delete-product/{product_id}', 'ProductController@delete_product');
Route::get('/all-product', 'ProductController@all_product');
Route::get('/unactive-product/{product_id}', 'ProductController@unactive_product');
Route::get('/active-product/{product_id}', 'ProductController@active_product');
Route::post('/save-product', 'ProductController@save_product');
Route::post('/update-product/{product_id}', 'ProductController@update_product');

//Coupon
Route::post('/check-coupon', 'CartController@check_coupon');

Route::get('/unset-coupon', 'CouponController@unset_coupon');
Route::get('/insert-coupon', 'CouponController@insert_coupon');
Route::get('/delete-coupon/{coupon_id}', 'CouponController@delete_coupon');
Route::get('/list-coupon', 'CouponController@list_coupon');
Route::post('/insert-coupon-code', 'CouponController@insert_coupon_code');

//Cart
Route::post('/update-cart-quantity', 'CartController@update_cart_quantity');
Route::post('/update-cart', 'CartController@update_cart');
Route::post('/save-cart', 'CartController@save_cart');
Route::post('/add-cart-ajax', 'CartController@add_cart_ajax');
Route::get('/show-cart', 'CartController@show_cart');
Route::get('/gio-hang', 'CartController@gio_hang');
Route::get('/delete-to-cart/{rowId}', 'CartController@delete_to_cart');
Route::get('/del-product/{session_id}', 'CartController@delete_product');
Route::get('/del-all-product', 'CartController@delete_all_product');
Route::get('/show-cart', 'CartController@show_cart_menu');


//Checkout
Route::get('/dang-nhap', 'CheckoutController@login_checkout');
Route::get('/del-fee', 'CheckoutController@del_fee');

Route::get('/logout-checkout', 'CheckoutController@logout_checkout');
Route::post('/add-customer', 'CheckoutController@add_customer');
Route::post('/order-place', 'CheckoutController@order_place');
Route::post('/login-customer', 'CheckoutController@login_customer');
Route::post('/add-phone', 'CheckoutController@add_phone');




Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');

Route::get('/payment', 'CheckoutController@payment');
Route::post('/save-checkout-customer', 'CheckoutController@save_checkout_customer');
Route::post('/calculate-fee', 'CheckoutController@calculate_fee');
Route::post('/select-delivery-home', 'CheckoutController@select_delivery_home');
Route::post('/confirm-order', 'CheckoutController@confirm_order');

//Order
Route::get('/view-history-order/{order_code}', 'OrderController@view_history_order');
Route::get('/history', 'OrderController@history');
Route::get('/delete-order/{order_code}', 'OrderController@order_code');
Route::get('/delete-order/{order_code}', 'OrderController@order_code');
Route::get('/print-order/{checkout_code}', 'OrderController@print_order');
Route::get('/manage-order', 'OrderController@manage_order');
Route::get('/view-order/{order_code}', 'OrderController@view_order');
Route::post('/update-order-qty', 'OrderController@update_order_qty');
Route::post('/update-qty', 'OrderController@update_qty');
Route::post('/huy-don-hang', 'OrderController@huy_don_hang');


//Delivery
Route::get('/delivery', 'DeliveryController@delivery');
Route::post('/select-delivery', 'DeliveryController@select_delivery');
Route::post('/insert-delivery', 'DeliveryController@insert_delivery');
Route::post('/select-feeship', 'DeliveryController@select_feeship');
Route::post('/update-delivery', 'DeliveryController@update_delivery');
Route::post('/delete-delivery', 'DeliveryController@delete_delivery');
//Banner
Route::get('/manage-slider', 'SliderController@manage_slider');
Route::get('/add-slider', 'SliderController@add_slider');
Route::get('/delete-slide/{slide_id}', 'SliderController@delete_slide');
Route::post('/insert-slider', 'SliderController@insert_slider');
Route::get('/unactive-slide/{slide_id}', 'SliderController@unactive_slide');
Route::get('/active-slide/{slide_id}', 'SliderController@active_slide');


// Cong thanh toan
Route::post('/vnpay-payment', 'CheckoutController@vnpay_payment');
Route::post('/momo-payment', 'CheckoutController@momo_payment');

// Auth roles
Route::get('/register-auth', 'AuthController@register_auth');
Route::get('/login-auth', 'AuthController@login_auth');
Route::get('/logout-auth', 'AuthController@logout_auth');
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

// Send Mail
Route::get('/send-coupon-vip/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}', 'MailController@send_coupon_vip');
Route::get('/send-coupon/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_code}', 'MailController@send_coupon');

Route::get('/mail-example', 'MailController@mail_example');

Route::get('/quen-mat-khau', 'MailController@quen_mat_khau');
Route::get('/update-new-pass', 'MailController@update_new_pass');
Route::post('/reset-new-pass', 'MailController@reset_new_pass');
Route::post('/recover-password', 'MailController@recover_password');


//Gallery
Route::get('/add-gallery/{product_id}', 'GalleryController@add_gallery');
Route::post('/select-gallery', 'GalleryController@select_gallery');
Route::post('/insert-gallery/{pro_id}', 'GalleryController@insert_gallery');
Route::post('/update-gallery-name', 'GalleryController@update_gallery_name');
Route::post('/delete-gallery', 'GalleryController@delete_gallery');
Route::post('/update-gallery', 'GalleryController@update_gallery');
