
<?php
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {    // Ignores notices and reports all other kinds... and warnings    
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);    // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}
Route::any('/test', function(Request $request) {
  return md5(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ').time());
});
Route::get('/','MainController@home_page')->name('home');
Route::get('blog','BlogController@getPosts');
Route::resource('subscriber','SubscriberController');
Route::get('post/{id}', 'BlogController@showPost');
//Route::get('about','MainController@about')->name('about');
Route::get('products/price','ProductController@price_filter');
Route::get('shop/gift-vouchers','GiftVouchersController@showPage');
Route::get('checkout/gift-vouchers','CartController@giftVoucherCheckout');
Route::get('checkout','CartController@checkout')->name('cart.checkout');
Route::post('couponcode','CartController@couponcode')->name('cart.coupon');
//Route::get('file/{file}','FileController@getFile');
Route::get('images/{image}','FileController@images')->name('images');
Route::post('cart/update/all', 'CartController@update_all');
Route::resource('cart', 'CartController');

Route::get('product/{slug}','ProductController@show')->name('product.show');
Route::get('products','ProductController@index')->name('products');
Route::get('category/{slug}','CategoryController@show')->name('category.show');
Route::get('shop/{slug}','ProductController@page_products')->name('shop.products');
//Route::resource('users', 'UserController');
//Route::resource('payments', 'PaymentsController');

Route::post('pay','PaymentsController@pay');
Route::post('pay2','PaymentsController@pay2');
Route::post('gift/pay','PaymentsController@payGift');
Route::get('thanks','PaymentsController@thanks');
Route::any('search','ProductController@search')->name('search');
Route::get('{slug}/page','PagesController@show_page');



//Auth::routes();
route::get( '/contact', function(){
    return view('contact');
});

// contact-us
route::get( '/contact-us', 'SettingsController@contact_us');
// end contact us


Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::group(['prefix' => 'dashboard','middleware' => ['dashboard_login','auth']], function () {

    Route::get('/', function ()    {
        return view('dashboard.index');
    });
    Route::get('/upload', function ()    {
        return view('dashboard.upload');
    });
    route::get( '/addcoupon', function(){
    return view('dashboard.coupon');
});
    Route::get('newsletter', 'NewsLetterController@index');
    Route::post('newsletter', 'NewsLetterController@send');
    Route::post('couponcode', 'SettingsController@couponcode');
    Route::get('coupon', 'SettingsController@coupon');
    Route::delete('deletecoupon/{id}', 'SettingsController@destroy');
    Route::get('editcoupon/{id}', 'SettingsController@editcoupon');
    Route::post('upload', 'SettingsController@upload');
    Route::resource('users', 'UserController');
    Route::resource('orders', 'OrderController');
    Route::get('recycl-remove/{id}', 'OrderController@destroy_payer');
    Route::get('recycle-orders', 'RecycleController@index');
     Route::delete('deleteorder/{id}', 'RecycleController@destroy');
	Route::get('changestatus/{id}', 'OrderController@updatestatus');
    Route::get('blog/published', 'BlogController@published');
    Route::get('blog/un-published', 'BlogController@unPublished');
    Route::resource('blog', 'BlogController');
    Route::resource('pages', 'PagesController');
    Route::resource('gift-vouchers', 'GiftVouchersController');
    Route::resource('roles', 'RolesController');
    Route::resource('category', 'CategoryController');
    Route::resource('subscribers', 'SubscriberController');
    Route::post('gallery/update-categories', 'GalleryController@updateCategories');
   Route::match(['get', 'post'],'copy/{id}','ProductController@copy')->name('dashboard.products');
    Route::resource('gallery', 'GalleryController');
    Route::match(['get', 'post'],'products','ProductController@getIndex')->name('dashboard.products');
    Route::get('/deleteimg/{id}','ProductController@deleteimg');
    Route::resource('product', 'ProductController');
    Route::resource('slider', 'SliderController');
    Route::resource('navigation','NavigationController');
    Route::get('navigation/{id}/edit-sub-nav','NavigationController@edit_subNav');
    Route::patch('navigation/{id}/update-sub-nav','NavigationController@update_subNav');
    Route::delete('navigation/{id}/delete-sub-nav','NavigationController@destroy_subNav');
    Route::delete('navigation/{id}/delete-more-nav','NavigationController@destroy_moreNav');
    Route::get('map','PagesController@map_page');
    Route::post('map','SettingsController@update_map');
    Route::get('theme','SettingsController@theme');
    Route::post('theme','SettingsController@update_theme');
    Route::get('info/show','SettingsController@showInfo');
    Route::get('info','SettingsController@getInfo');
    Route::post('info','SettingsController@postInfo');
    Route::get('about','PagesController@getAboutPage');
    Route::post('about','PagesController@postAboutPage');
    Route::post('settings','SettingsController@postSettings');
    Route::get('settings','SettingsController@showSettings');
    Route::post('site-settings','SettingsController@updateSettings');
    Route::post('site-settings','SettingsController@updateSettings');
  

});
  // contact us feed back
     Route::post('conatctus','ContactController@contactus');
     // End Contact feed back
     

