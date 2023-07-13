<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BanneSlideController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\frontend\FrontendAboutController;
use App\Http\Controllers\frontend\FrontendContactController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\Home\HomeSliderController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\ProductController;
use App\Http\Controllers\Home\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RolePermission\RoleController;
use App\Http\Controllers\SocialmediaController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::get('/admin', function () {
    return redirect(app()->getLocale() . '/admin');
});


Route::group(
    [
        'prefix' => '{locale}',
        'where' => ['locale' => '[a-zA-Z]{2}'],
        'middleware' => 'setlocale'
    ],
    function () {

        Route::get('/admin', [AdminController::class, 'Login'])->name('login');
        Route::post('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
        Route::get('/admins/{id}', [AdminController::class, 'StatusLogin'])->name('status.login');
        Route::post('/admins/login', [AdminController::class, 'AdminStatusLogin'])->name('admin.status.login');

        Route::get('/', [HomeController::class, 'Home'])->name('index.page');
        Route::get('/posts', [HomeController::class, 'allpost'])->name('all.post.page');
        Route::get('/search', [HomeController::class, 'allpost'])->name('search.post.page');
        Route::get('/promote/{id}', [HomeController::class, 'banner'])->name('home.banner');
        Route::get('/about', [FrontendAboutController::class, 'HomeAbout'])->name('home.about');
        Route::get('/contact', [FrontendContactController::class, 'HomeContact'])->name('home.contact');

        Route::get('/{post_id}', [ProductController::class, 'single_post'])->name('single.post');
        Route::get('/category/{category_id}', [ProductController::class, 'categoryPost'])->name('category.post');

        Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

            Route::group(['prefix' => 'media', 'middleware' => ['web', 'auth']], function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });

            Route::middleware(['auth', 'roles:1'])->group(function () {

                //Dashboard route
                Route::controller(DashboardController::class)->group(function () {
                    Route::get('/dashboard', 'Dashboard')->name('dashboard');
                    Route::get('/view/post/cat/{cat_name}/{id}', 'ViewPostCat')->name('view.post.cat');
                    Route::get('/query-data/year', 'queryData')->name('query.data');
                });


                Route::controller(HomeSliderController::class)->group(function () {
                    Route::get('/home/slide', 'HomeSlider')->name('home.slide');
                    Route::post('/update/slider', 'UpdateSlider')->name('update.slider');
                });

                // dev edit banner
                Route::controller(BannerController::class)->group(function () {
                    Route::get('/banner', 'index')->name('banner.index');
                    Route::get('/create/banner', 'create')->name('banner.create');
                    Route::post('/store/banner', 'store')->name('banner.store');
                    Route::get('/edit/banner/{id}', 'edit')->name('banner.edit');
                    Route::post('/update/banner', 'update')->name('banner.update');
                    Route::get('/delete/banner/{id}', 'delete')->name('banner.delete');

                    Route::get('/banner/trashed', 'trashed')->name('banner.trashed');
                    Route::get('/banner/restore/{id}', 'restore')->name('banner.restore');
                    Route::get('/banner/force-delete/{id}', 'force_delete')->name('banner.force.delete');

                    Route::get('/banner/update/status', 'toggle')->name('banner.update.status');
                });

                // Category routes
                Route::controller(CategoryController::class)->group(function () {
                    Route::get('/category', 'Category')->name('category');
                    Route::post("/store/category", 'StoreCategory')->name('store.category');
                    Route::get('/edit/category/{id}', "EditCategory")->name('edit.category');
                    Route::post('/update/category', "UpdateCategory")->name('update.category');
                    Route::get('/delete/category/{id}', "DeleteCategory")->name('delete.category');

                    Route::get('/category/trashed', 'index')->name('cates.index.trashed');
                    Route::get('/category/restore/{id}', 'restore')->name('cates.restore.trashed');
                    Route::get('/category/force-delete/{id}', 'force_delete')->name('cates.force.delete.trashed');
                });

                // Posts routes
                Route::controller(PostController::class)->group(function () {
                    Route::get('/post', 'Post')->name('post');
                    Route::get('/create/post', 'CreatePost')->name('create.post');
                    Route::post('/store/post', 'StorePost')->name('store.post');
                    Route::get('/delete/post/{id}', 'DeletePost')->name('delete.post');
                    Route::get('/edit/post/{id}', 'EditPost')->name('edit.post');
                    Route::post('/update/post', "UpdatePost")->name('update.post');
                    Route::get('/delete/single_image/{id}', "DeleteSingleImage")->name('delete.single.image');
                    Route::get('/delete/post/{post_id}/tag/{tag_id}', 'DeletePostTag')->name('delete.post.tag');

                    Route::get('/post/trashed', 'index')->name('post.transhed');
                    Route::get('/post/restore/{id}', 'restore')->name('post.restore.trashed');
                    Route::get('/post/force-delete/{id}', 'force_delete')->name('post.force.delete.trashed');

                    Route::post('get-tags', 'getTags')->name('get-tags');
                });

                // Tags
                Route::controller(TagController::class)->group(function () {
                    Route::get('/tag', "Tag")->name('tag');
                    Route::post('/store/tag', "StoreTag")->name('store.tag');
                    Route::get('/edit/tag/{id}', "EditTag")->name('edit.tag');
                    Route::post('/update/tag', "UpdateTag")->name('update.tag');
                    Route::get('/delete/tag/{id}', "DeleteTag")->name('delete.tag');

                    Route::get('/tag/trashed', 'index')->name('index.trashed');
                    Route::get('/tag/restore/{id}', 'restore')->name('restore.trashed');
                    Route::get('/tag/force-delete/{id}', 'force_delete')->name('force.delete.trashed');
                });


                Route::controller(AboutController::class)->group(function () {
                    Route::get('/about/page', 'AboutPage')->name('about.page');
                    Route::post('/update/about', 'UpdateAbout')->name('update.about');
                    Route::post('/store/about', 'StoreAbout')->name('store.about');
                    Route::get('/about/trans/page/{id}', 'AboutTransPage')->name('about.trans.page');
                    Route::post('/about/translate', 'AboutTranslate')->name('about.translate');

                    Route::get('/about/multi/image', 'AboutMultiImage')->name('about.multi.image');
                    Route::post('/store/multi/image', 'StoreMultiImage')->name('store.multi.image');
                    Route::get('/all/multi/image', 'AllMultiImage')->name('all.multi.image');
                    Route::get('/edit/multi/image/{id}', 'EditMultiImage')->name('edit.multi.image');
                    Route::post('/update/multi/image', 'UpdateMultiImage')->name('update.multi.image');
                    Route::get('/delete/multi/image/{id}', 'DeleteMultiImage')->name('delete.multi.image');
                });

                Route::controller(PortfolioController::class)->group(function () {
                    Route::get('/all/portfolio', 'AllPortfolio')->name('all.portfolio');
                    Route::get('/add/portfolio', 'AddPortfolio')->name('add.portfolio');
                    Route::post('/store/portfolio', 'StorePortfolio')->name('store.portfolio');
                    Route::get('/edit/portfolio/{id}', 'EditPortfolio')->name('edit.portfolio');
                    Route::post('/update/portfolio', 'UpdatePortfolio')->name('update.portfolio');
                    Route::get('/delete/portfolio/{id}', 'DeletePortfolio')->name('delete.portfolio');
                });

                Route::controller(CompanyController::class)->group(function () {
                    Route::get('/company-info', 'index')->name('index.company');
                    Route::post('/add/company-inof', 'store')->name('store.company');
                    Route::put('/update/company-info', 'update')->name('update.company');
                });

                Route::controller(SocialmediaController::class)->group(function () {
                    Route::get('/social', 'index')->name('index.social');
                    Route::post('/create/social', 'store')->name("store.social");
                    Route::get('/edit/social/{id}', 'edit')->name("edit.social");
                    Route::put('/update/social/{id}', 'update')->name("update.social");
                    Route::get('/delete/social/{id}', 'delete')->name('delete.social');
                });

                Route::controller(ContactController::class)->group(function () {
                    Route::get('create/contact/', 'index');
                    Route::post('store/contact/', 'store')->name("store.contact");
                    Route::get('show/contact/{id}', 'show')->name("show.contact");
                    Route::get('edit/contact/{id}', 'edit')->name("edit.contact");
                    Route::put('update/contact/{id}', 'update')->name("update.contact");
                    Route::get('delete/contact/{id}', 'destroy')->name("delete.contact");
                });


                // Admin All Route
                Route::controller(AdminController::class)->group(function () {

                    //Admin Profile
                    Route::get('/admin/logout', 'AdminLogout')->name('admin.logout');
                    Route::get('/admin/profile', 'Profile')->name('admin.profile');
                    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
                    Route::post('/store/profile', 'StoreProfile')->name('store.profile');
                    Route::get('/change/password', 'ChangePassword')->name('change.password');
                    Route::post('/update/password', 'UpdatePassword')->name('update.password');

                    //All Admin Manage
                    Route::get('/all/admin', 'AllAdmin')->name('all.admin');
                    Route::get('/add/admin', 'AddAdmin')->name('add.admin');

                    Route::get('/trashed/admin', 'trash')->name('admin.trashed');
                    Route::get('/restore/trash/admin/{id}', 'restore')->name('admin.restored.trashed');
                    Route::get('/force-delete/trash/admin/{id}', 'force_delete')->name('admin.force.delete.trashed');

                    Route::post('/admin/user/store', 'AdminUserStore')->name('admin.user.store');
                    Route::get('/edit/admin/role/{id}', 'EditAdminRole')->name('edit.admin.role');
                    Route::post('/admin/user/update/{id}', 'AdminUserUpdate')->name('admin.user.update');
                    Route::get('/delete/admin/role/{id}', 'DeleteAdminRole')->name('delete.admin.role');

                    Route::get('/active/admin/status/{id}', 'ActiveAdminStatus')->name('active.admin.status');
                });


                //Roles and Permission Route

                Route::controller(RoleController::class)->group(function () {
                    Route::get('/all/permision', 'AllPermission')->name('all.permission');
                    Route::get('/add/permission', 'AddPermission')->name('add.permission');
                    Route::post('/store/permission', 'StorePermission')->name('store.permission');
                    Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
                    Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
                    Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');
                });

                Route::controller(RoleController::class)->group(function () {
                    Route::get('/all/roles', 'AllRoles')->name('all.roles');
                    Route::get('/add/roles', 'AddRoles')->name('add.roles');
                    Route::post('/store/roles', 'StoreRoles')->name('store.roles');
                    Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');
                    Route::post('/update/roles', 'UpdateRoles')->name('update.roles');
                    Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');

                    ///Add Role Permission

                    Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
                    Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');
                    Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');
                    Route::get('/admin/edit/roles/{id}', 'AdminRoleEdit')->name('admin.edit.roles');
                    Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');
                    Route::get('/admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');
                });
            }); // end middleware 'role:1'


        }); // end prefix => 'admin


    }
); //end prefix locale

require __DIR__ . '/auth.php';
