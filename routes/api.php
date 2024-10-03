<?php

use App\Http\Controllers\API\FooterSettingsController;
use App\Http\Controllers\Frontend\StripeController;
use App\Http\Controllers\API\{AddressController, AuthController, CartController, CmsController, DistributorController, HomeController, ResourceController, UserController, SeoController, ProductController, OrderController, IndustryController};
use App\Models\FooterSettings;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('forget-password-send-otp', 'forgetPasswordSendOtp');
    Route::post('forget-password-verify-otp', 'forgetPasswordVerifyOtp');
    Route::post('change-password', 'changePassword');
    Route::post('one-tap-singin', 'oneTapSignin');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('category-list', 'categoryList');
    Route::get('industry-list', 'industryList');
    Route::get('choose-for-list', 'chooseForList');
    Route::get('testimonials', 'testimonialList');
    Route::get('distribution-center-list', 'distributionList');
    Route::get('home-page', 'homePage');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('my-profile', 'user');
        Route::post('personal-details-update', 'personalUpdate');
        Route::post('update-password', 'updatePassword');
        Route::post('add-address/{address_id?}', 'addAddress');
        Route::post('get-address', 'getAddress');
        Route::get('delete-address/{address_id}', 'deleteAddress');
    });
    Route::controller(CartController::class)->group(function () {
        Route::get('get-dry-ice-pallet/{id}', 'DryicePallet');
        Route::post('add-to-cart', 'AddToCart');
        Route::post('view-cart', 'viewCart');
    });
});

Route::controller(ResourceController::class)->group(function () {
    Route::get('resources', 'resources');
    Route::get('resource/{slug}/details', 'resourceDtls');
});

Route::controller(CmsController::class)->group(function () {
    Route::get('get/{slug}/cms', 'getCmsPage');
    Route::get('get-faq', 'getFaq');
    Route::get('dry-ice-page', 'dryIcePage');
});

Route::controller(SeoController::class)->group(function () {
    Route::get('seo/{slug}', 'getSeoPage');
    Route::get('seo-pages', 'getSeoPages');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'getProducts');
    Route::post('products/distance', 'getDistance');
    Route::post('/custom-cut-dryice-request', 'customCutDryiceRequest');
    Route::post('/contact-us', 'contactUs');
    Route::get('products/{slug}', 'getProduct');
});


Route::controller(IndustryController::class)->group(function () {
    Route::get('industries', 'getIndustries');
    Route::get('industries/{slug}', 'getIndustry');
});
Route::controller(FooterSettingsController::class)->group(function () {
    Route::get('footer-settings', 'footerSettings');
});

Route::middleware('auth:sanctum')->resource('addresses', AddressController::class)->only([
    'index',
    'store'
]);

Route::middleware('auth:sanctum')->controller(StripeController::class)->group(function () {
    Route::post('payment/initiate', 'initiatePayment');
    Route::post('payment/complete', 'completePayment');
    Route::post('payment/failure', 'failPayment');
    Route::get('payment/payment-method', 'getPaymentMethod');
    Route::post('payment/payment-method', 'updatePaymentMethod');
});
Route::controller(OrderController::class)->group(function () {
    Route::post('order/purchase', 'completePayment');
});
Route::controller(DistributorController::class)->group(function () {
    Route::get('distributions', 'index');
});
Route::middleware('auth:sanctum')->controller(OrderController::class)->group(function () {

    Route::get('order', 'index');
});
