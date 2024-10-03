<?php

use App\Http\Controllers\Admin\{CategoryController, ChooseForController, CmsController, DistributorController, DryIceController, FaqController, HomeController, IndustryController, ProductController, ResourceController, SeoController, TestimonialController, UserController, OrderController, DistributionController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\{CommonController};
use App\Models\Distribution;

Route::redirect('/admin', 'admin/login');
Route::redirect('/', 'admin/login');

Route::group(['prefix' => 'admin'], function () {
        Route::any('forgot-password', [CommonController::class, 'forgotPassword'])->name('admin.forgotPassword');
        Route::any('otp-validations', [CommonController::class, 'otpValidations'])->name('admin.otpValidations');
        Route::any('reset-password', [CommonController::class, 'resetPassword'])->name('admin.resetPassword');
        Route::get('login', [HomeController::class, 'index'])->name('admin.login');
        Route::post('login', [HomeController::class, 'authenticate'])->name('login');

        Route::name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
                /**Authentication */
                Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

                

                Route::any("footer-settings", [HomeController::class, 'footerSettings'])->name('footer-settings');
                Route::any("orders", [OrderController::class, 'orders'])->name('orders');
                Route::any("view-order/{id}", [OrderController::class, 'viewOrder'])->name('viewOrder');
                Route::post('order-change-status', [OrderController::class, 'changeStatus'])->name('order.status');

                /** User */
                Route::get('user', [UserController::class, 'userlist'])->name('users');
                Route::any('create-user', [UserController::class, 'createUser'])->name('createUser');
                Route::any('edit-user/{id}', [UserController::class, 'editUser'])->name('editUser');
                Route::delete('delete-user/{id}', [UserController::class, 'deleteUser'])->name('userDelete');
                Route::post('change-user-status', [UserController::class, 'changeUserStatus'])->name('changeuserstatus');

                /** CMS */
                Route::resource('cms', CmsController::class)->except(['update', 'show']);
                Route::post('cms/{slug}', [CmsController::class, 'update']);
                Route::get('cms/page/{slug}/edit', [CmsController::class, 'editCmsPages']);
                Route::post('cms/page/update/{slug}', [CmsController::class, 'updateCmsPages'])->name('cms.page.update');
                Route::any('cms-new-page', [CmsController::class, 'create'])->name('cms.new.page');

                /* Category */
                Route::get('category', [CategoryController::class, 'getCategoryPage'])->name('category');
                Route::any('/create-category', [CategoryController::class, 'createCategory'])->name('createCategory');
                Route::any('/edit-category/{category_id}', [CategoryController::class, 'editCategory'])->name('editCategory');
                Route::post('/change-category-status', [CategoryController::class, 'changeCategoryStatus'])->name('changeCategoryStatus');
                Route::delete('/delete-category/{category_id}', [CategoryController::class, 'categoryDelete'])->name('categoryDelete');

                

                

                /** Choose For */
                Route::get('choose-for-list', [ChooseForController::class, 'ChooseForList'])->name('choose-for');
                Route::any('create-choose-for', [ChooseForController::class, 'createChooseFor'])->name('create-choose-for');
                Route::any('edit-choose-for/{id}', [ChooseForController::class, 'editChooseFor'])->name('edit-choose-for');
                Route::delete('delete-choose-for/{id}', [ChooseForController::class, 'deleteChooseFor'])->name('choose-for-Delete');
                Route::post('change-choose-for-status', [ChooseForController::class, 'changeChooseForStatus'])->name('change-choose-for-status');

                /** testimonial management */
                Route::get('testimonial', [TestimonialController::class, 'index'])->name('testimonial');
                Route::get('testimonial-create', [TestimonialController::class, 'createTestimonial'])->name('testimonial.create');
                Route::post('testimonial-create-post', [TestimonialController::class, 'createTestimonialPost'])->name('testimonial.create-post');
                Route::get('testimonial/{id}/edit', [TestimonialController::class, 'editTestimonial'])->name('testimonial.edit');
                Route::post('update-testimonial/{id}', [TestimonialController::class, 'updateTestimonial'])->name('testimonial.update');
                Route::post('testimonial-delete/{id}', [TestimonialController::class, 'deleteTestimonial'])->name('testimonial.delete');
                Route::get('contact-us', [ProductController::class, 'contact_us'])->name('contact-us');

                
                
                
                
                // Shared Routes



                // Route::any('admin-profile', [HomeController::class, 'adminProfile'])->name('profile');
                // Route::post('admin-change-password', [HomeController::class, 'adminChangePassword'])->name('changePassword');
                // Route::post('logout', [HomeController::class, 'logout'])->name('logout');

                // // resource management<
                // Route::any('resource-list', [ResourceController::class, 'resourceList'])->name('resource-list');
                // Route::any('resource-create', [ResourceController::class, 'createResource'])->name('resource-create');
                // Route::any('resource/{id}/edit', [ResourceController::class, 'editResource'])->name('resource-edit');
                // Route::delete('resource/{id}/delete', [ResourceController::class, 'deleteResource'])->name('delete.resource');

                // //seo management
                // Route::any('seo-pages', [SeoController::class, 'index'])->name('seo.pages');
                // Route::any('seo-page-create', [SeoController::class, 'createSeo'])->name('seo.page.create');
                // Route::post('/change-seo-status', [SeoController::class, 'changeSeoStatus'])->name('changeSeoStatus');
                // Route::delete('/seo/delete/{id}', [SeoController::class, 'deleteSeo'])->name('deleteSeo');
                // Route::any('seo-page-edit/{id}', [SeoController::class, 'editSeo'])->name('seo.page.edit');
                // Route::any('seo-page-update/{id}', [SeoController::class, 'updateSeo'])->name('seo.page.update');

                // //distributor management
                // Route::get('distribution-center', [DistributorController::class, 'index'])->name('distribution.center');
                // Route::post('change-distribution-status', [DistributorController::class, 'changeStatus'])->name('change.distribution.status');
                // Route::any('distribution-create', [DistributorController::class, 'createDistribution'])->name('distribution.create');
                // Route::any('distribution-edit/{id}', [DistributorController::class, 'editDistribution'])->name('distribution.edit');
                // Route::get('distribution-delete/{id}', [DistributorController::class, 'deleteDistribution'])->name('distribution.delete');

                // // Product
                // Route::get('product-list', [ProductController::class, 'index'])->name('product.list');
                // Route::get('custom-cut-dryice-list', [ProductController::class, 'customcutdryice'])->name('product.custom-cut-dryice');
                // Route::any('product-create', [ProductController::class, 'ProductCreate'])->name('product.create');
                // Route::any('/edit-product/{product_id}', [ProductController::class, 'editProduct'])->name('editProduct');
                // Route::post('/change-product-status', [ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
                // Route::delete('/delete-product/{product_id}', [ProductController::class, 'productDelete'])->name('productDelete');

                // //dry ice
                // Route::get('dry-ice-list', [DryIceController::class, 'dryiceList'])->name('dry.ice.list');
                // Route::any('dry-ice-create', [DryIceController::class, 'dryiceCreate'])->name('dry.ice.create');
                // Route::any('/edit-dry-ice/{dry_ice_id}', [DryIceController::class, 'editDryIce'])->name('edit.dry.ice');
                // Route::post('dry-ice-delete/{id}', [DryIceController::class, 'deleteDryIce'])->name('delete.dry.ice');


                // /** Industry */
                // Route::get('industry', [IndustryController::class, 'index'])->name('industry');
                // Route::any('industry-create', [IndustryController::class, 'create'])->name('industry.create');
                // Route::get('industry-edit/{id}', [IndustryController::class, 'edit'])->name('industry.edit');
                // Route::post('industry-update/{id}', [IndustryController::class, 'update'])->name('industry.update');
                // Route::post('industry-change-status', [IndustryController::class, 'changeStatus'])->name('industry.status');
                // Route::post('industry-delete/{id}', [IndustryController::class, 'deleteIndustry'])->name('industry.delete');

                // /** Faq */
                // Route::resource('faq', FaqController::class);
                // Route::post('change-faq-status', [FaqController::class, 'changeFaqStatus']);


        });


        Route::name('admin.')->middleware(['auth', 'isAdminOrEditor'])->group(function () {

                Route::any('admin-profile', [HomeController::class, 'adminProfile'])->name('profile');
                Route::post('admin-change-password', [HomeController::class, 'adminChangePassword'])->name('changePassword');
                Route::post('logout', [HomeController::class, 'logout'])->name('logout');

                // resource management<
                Route::any('resource-list', [ResourceController::class, 'resourceList'])->name('resource-list');
                Route::any('resource-create', [ResourceController::class, 'createResource'])->name('resource-create');
                Route::any('resource/{id}/edit', [ResourceController::class, 'editResource'])->name('resource-edit');
                Route::delete('resource/{id}/delete', [ResourceController::class, 'deleteResource'])->name('delete.resource');

                //seo management
                Route::any('seo-pages', [SeoController::class, 'index'])->name('seo.pages');
                Route::any('seo-page-create', [SeoController::class, 'createSeo'])->name('seo.page.create');
                Route::post('/change-seo-status', [SeoController::class, 'changeSeoStatus'])->name('changeSeoStatus');
                Route::delete('/seo/delete/{id}', [SeoController::class, 'deleteSeo'])->name('deleteSeo');
                Route::any('seo-page-edit/{id}', [SeoController::class, 'editSeo'])->name('seo.page.edit');
                Route::any('seo-page-update/{id}', [SeoController::class, 'updateSeo'])->name('seo.page.update');

                //distributor management
                Route::get('distribution-center', [DistributorController::class, 'index'])->name('distribution.center');
                Route::post('change-distribution-status', [DistributorController::class, 'changeStatus'])->name('change.distribution.status');
                Route::any('distribution-create', [DistributorController::class, 'createDistribution'])->name('distribution.create');
                Route::any('distribution-edit/{id}', [DistributorController::class, 'editDistribution'])->name('distribution.edit');
                Route::get('distribution-delete/{id}', [DistributorController::class, 'deleteDistribution'])->name('distribution.delete');

                // Product
                Route::get('product-list', [ProductController::class, 'index'])->name('product.list');
                Route::get('custom-cut-dryice-list', [ProductController::class, 'customcutdryice'])->name('product.custom-cut-dryice');
                Route::any('product-create', [ProductController::class, 'ProductCreate'])->name('product.create');
                Route::any('/edit-product/{product_id}', [ProductController::class, 'editProduct'])->name('editProduct');
                Route::post('/change-product-status', [ProductController::class, 'changeProductStatus'])->name('changeProductStatus');
                Route::delete('/delete-product/{product_id}', [ProductController::class, 'productDelete'])->name('productDelete');

                //dry ice
                Route::get('dry-ice-list', [DryIceController::class, 'dryiceList'])->name('dry.ice.list');
                Route::any('dry-ice-create', [DryIceController::class, 'dryiceCreate'])->name('dry.ice.create');
                Route::any('/edit-dry-ice/{dry_ice_id}', [DryIceController::class, 'editDryIce'])->name('edit.dry.ice');
                Route::post('dry-ice-delete/{id}', [DryIceController::class, 'deleteDryIce'])->name('delete.dry.ice');


                /** Industry */
                Route::get('industry', [IndustryController::class, 'index'])->name('industry');
                Route::any('industry-create', [IndustryController::class, 'create'])->name('industry.create');
                Route::get('industry-edit/{id}', [IndustryController::class, 'edit'])->name('industry.edit');
                Route::post('industry-update/{id}', [IndustryController::class, 'update'])->name('industry.update');
                Route::post('industry-change-status', [IndustryController::class, 'changeStatus'])->name('industry.status');
                Route::post('industry-delete/{id}', [IndustryController::class, 'deleteIndustry'])->name('industry.delete');

                /** Faq */
                Route::resource('faq', FaqController::class);
                Route::post('change-faq-status', [FaqController::class, 'changeFaqStatus']);


        });

});
