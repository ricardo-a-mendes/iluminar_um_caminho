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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/checkout/{id}', 'CheckoutController@index')->name('checkout.index');
    Route::post('/checkout', 'CheckoutController@process')->name('checkout_process');
    Route::get('/checkout/{id}/thanks', 'CheckoutController@thanks')->name('checkout_thanks');


    Route::resource('user', 'UserController');
    Route::resource('campaign', 'CampaignController')->except(['index', 'show']);
    Route::resource('donation', 'DonationController')->except(['index', 'show']);

});

Route::post('/notify', 'CheckoutController@notifications')->name('checkout_notifications');
Route::resource('campaign', 'CampaignController')->only(['index']);

Route::get('login/facebook', 'SocialiteController@redirectToFacebookProvider')->name('logon_facebook');
Route::get('login/facebook/callback', 'SocialiteController@handleFacebookProviderCallback');

//Route::get('login/google', 'SocialiteController@redirectToGoogleProvider');
//Route::get('login/google/callback', 'SocialiteController@handleGoogleProviderCallback');
//
//Route::get('login/github', 'SocialiteController@redirectToGithubProvider');
//Route::get('login/github/callback', 'SocialiteController@handleGithubProviderCallback');

Auth::routes();
