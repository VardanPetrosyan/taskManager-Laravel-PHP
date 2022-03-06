<?php

use App\Helper\AuthHelper;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('invoice.index');
});

Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function () {
//    Route::get('/?', "AdminController@info");
    Route::get('/', function () {
        if (AuthHelper::check()) {
            return redirect()->route('admin_dashboard');
        } else {
            return redirect()->route('admin_login_view');
        }
    });

    Route::get('/login', "LoginController@index")->name('admin_login_view');
    Route::get('/logout', "LoginController@logout")->name('admin_logout');
    Route::post('/post-login', "LoginController@login")->name('admin_login');

    Route::group(['middleware' => 'admin'], function () {

        Route::get('/dashboard', "DashboardController@index")->name('admin_dashboard');

        Route::group(['prefix' => '/user'], function (){
            Route::get('/', "DashboardController@userList")->name('admin_user_list');
            Route::get('/user', "DashboardController@userUser")->name('admin_user_user');
            Route::get('/user-admin', "DashboardController@userAdmin")->name('admin_user_admin');
            Route::get('/user-deleted', "DashboardController@userDeleted")->name('admin_user_deleted');
            Route::post('/create', "DashboardController@createUser")->name('admin_users_create');
            Route::get('/edit/{id}', "DashboardController@edit")->name('admin_user_edit');
            Route::post('/update', "DashboardController@update")->name('admin_user_update');
            Route::get('/delete/{id}', "DashboardController@delete")->name('admin_user_delete');
            Route::get('/deleteFinally/{id}', "DashboardController@deleteFinally")->name('admin_user_deleteFinally');
            Route::get('/treat/{id}', "DashboardController@treat")->name('admin_user_treat');
        });
        Route::group(['prefix' => '/position'], function (){
            Route::get('/', "PositionController@index")->name('admin_position');
            Route::post('/create', "PositionController@create")->name('admin_position_create');
            Route::get('/edit/{id}', "PositionController@edit")->name('admin_position_edit');
            Route::post('/update', "PositionController@update")->name('admin_position_update');
            Route::get('/deleteFinally/{id}', "PositionController@deleteFinally")->name('admin_position_deleteFinally');
        });
        Route::group(['prefix' => '/product'], function () {
            Route::get('/', "ProductsController@index")->name('admin_products');
            Route::post('/create', "ProductsController@create")->name('admin_products_create');
            Route::get('/edit/{id}', "ProductsController@edit")->name('admin_product_edit');
            Route::post('/update', "ProductsController@update")->name('admin_product_update');
            Route::get('/active-products', "ProductsController@showActive")->name('admin_product_show_active');
            Route::get('/passive-products', "ProductsController@showPassive")->name('admin_product_show_passive');
            Route::get('/reserved-products', "ProductsController@showReserved")->name('admin_product_show_reserved');
            Route::get('/active/{id}', "ProductsController@active")->name('admin_product_active');
            Route::get('/passive/{id}', "ProductsController@passive")->name('admin_product_passive');
            Route::get('/delete/{id}', "ProductsController@delete")->name('admin_product_delete');
            Route::any('/upload', "ProductsController@uploadFile")->name('upload_product');
            Route::any('/export', "ProductsController@exportProducts")->name('export_products');
        });
        Route::group(['prefix' => '/order'], function () {
            Route::get('/', "OrdersController@index")->name('admin_order_all');
            Route::post('/insert', "OrdersController@store")->name('admin_order_insert');
            Route::get('/edit/{id}', "OrdersController@edit")->name('admin_order_status_edit');
            Route::post('/update', "OrdersController@update")->name('admin_order_status_update');
            Route::get('/delete/{id}', "OrdersController@delete")->name('admin_order_delete');
            Route::get('/archive', "OrdersController@showArchive")->name('admin_order_show_archive');
            Route::get('/back-up/{id}', "OrdersController@backUpArchive")->name('admin_order_back_up');
            Route::get('/complete', "OrdersController@complete")->name('admin_order_complete');
            Route::get('/pending', "OrdersController@pending")->name('admin_order_pending');
            Route::get('/show-archive', "OrdersController@archive")->name('admin_order_archive');
            Route::get('/canceled-admin', "OrdersController@canceledAdmin")->name('admin_order_canceled_by_admin');
            Route::get('/canceled-customer', "OrdersController@canceledCustomer")->name('admin_order_canceled_by_customer');
            Route::post('/filter', "OrdersController@filter")->name('admin_order_filter');
            Route::get('/approve/{id}', "OrdersController@approve")->name('admin_order_approve');
            Route::post('/approveorders', "OrdersController@approveOrders")->name('admin_orders_approve');
            Route::get('/details/{id}', "OrdersController@detail")->name('admin_order_detail');
            Route::get('/excel', "OrdersExportController@excel")->name('admin_order_excel');
            Route::get('/claim', "OrdersController@claim")->name('admin_order_claim');
            Route::post('/ordinary-orders', "OrdersController@ordinary")->name('admin_order_ordinary');
        });

        Route::group(['prefix' => '/categorie'], function () {
            Route::get('/', "CategoriesController@index")->name('admin_categorie_all');
            Route::get('/store', "CategoriesController@store")->name('admin_categorie_store');
            Route::post('/table-edit', "TablEditController@edittable")->name('admin_table_edit');
            Route::get('/edit/{id}', "CategoriesController@edit")->name('admin_category_edit');
            Route::post('/update', "CategoriesController@update")->name('admin_category_update');
            Route::get('/deleteFinally/{id}', "CategoriesController@deleteFinally")->name('admin_category_deleteFinally');
        });

        Route::group(['prefix' => '/furniture'], function () {
            Route::get('/', "FurnituresController@index")->name('admin_furniture');
            Route::get('/ordered', "FurnituresController@ordered")->name('admin_furniture_ordered');
            Route::get('/history', "FurnituresController@history")->name('admin_furniture_history');
            Route::post('/create', "FurnituresController@create")->name('admin_furniture_create');
            Route::post('/delete', "FurnituresController@delete")->name('admin_furniture_delete');
            Route::post('/changeStatus', "FurnituresController@changeStatus")->name('admin_furniture_changeStatus');
            Route::get('/edit/{id}', "FurnituresController@edit")->name('admin_furniture_edit');
            Route::get('/transfer/{id}', "FurnituresController@transfer")->name('admin_furniture_transfer');
            Route::post('/update/{id}', "FurnituresController@update")->name('admin_furniture_update');
            Route::post('/updateTransfer/{id}', "FurnituresController@updateTransfer")->name('admin_furniture_update_transfer');
            Route::post('/approve', "FurnituresController@approve")->name('admin_furniture_approve');
            Route::post('/disapprove', "FurnituresController@disapprove")->name('admin_furniture_disapprove');
            Route::post('/cancelOrder', "FurnituresController@cancelOrder")->name('admin_furniture_cancelorder');
            Route::any('/upload', "FurnituresController@uploadFile")->name('upload_furniture');
            Route::any('/downloadId', "FurnituresController@downloadId")->name('download_id_furniture');
            Route::any('/downloadICategory', "FurnituresController@downloadIdCategory")->name('download_id_category_furniture');
            Route::any('/export', "FurnituresController@exportFurnitures")->name('export_furnitures');
            Route::any('/exportHistory', "FurnituresController@exportHistory")->name('export_furnitures_history');
//            Route::get('/store', "CategoriesController@store")->name('admin_categorie_store');
//            Route::post('/table-edit', "TablEditController@edittable")->name('admin_table_edit');
        });
        Route::group(['prefix' => '/categories_structure_archive'], function () {
            Route::get('/', "CategoryStructureArchiveController@index")->name('admin_categories_structure_archive');
            Route::post('/update', "CategoryStructureArchiveController@update")->name('admin_categories_structure_update_archive');
        });
        Route::group(['prefix' => '/categories_structure'], function () {
            Route::get('/{id?}', "CategoryStructureController@index")->name('admin_categories_structure');
            Route::post('/create', "CategoryStructureController@create")->name('admin_categories_structure_create');
            Route::post('/update', "CategoryStructureController@update")->name('admin_categories_structure_update');
            Route::get('/changeSelect/{id?}', "CategoryStructureController@changeSelect")->name('admin_change_select');
            

        });
        Route::get('/changeSelect/{id}', "CategoryStructureController@changeSelect")->name('admin_change_select');
        Route::get('/selectCategoryView', "CategoryStructureController@selectCategoryView")->name('admin_select_category_view');
        Route::post('/selectCategoryDelete', "CategoryStructureController@selectCategoryDelete")->name('admin_select_category_delete');
        Route::post('/selectCategoryRename', "CategoryStructureController@selectCategoryRename")->name('admin_select_category_rename');
        Route::post('/selectCategoryCreate', "CategoryStructureController@selectCategoryCreate")->name('admin_select_category_create');

    });
});

// Manager

Route::group(['prefix' => '/manager', 'namespace' => 'Manager'], function () {
    Route::get('/', function () {
        if (AuthHelper::check()) {
            return redirect()->route('manager_dashboard');
        } else {
            return redirect()->route('admin_login_view');
        }
    });

    Route::get('/login', "LoginController@index")->name('admin_login_view');
    Route::get('/logout', "LoginController@logout")->name('admin_logout');
    Route::post('/post-login', "LoginController@login")->name('admin_login');

    Route::group(['middleware' => 'manager'], function () {
        Route::get('/dashboard', "DashboardController@index")->name('manager_dashboard');
        Route::get('/order', "OrderController@index")->name('manager_orders');
        Route::get('/excel', "OrdersExportController@excel")->name('manager_order_excel');
        Route::get('/details/{id}', "OrderController@detail")->name('manager_order_detail');
        Route::get('/approve/{id}', "OrderController@approve")->name('manager_order_approve');
        Route::get('/complete', "OrderController@complete")->name('manager_order_complete');
        Route::get('/pending', "OrderController@pending")->name('manager_order_pending');
        Route::get('/show-archive', "OrderController@archive")->name('manager_order_archive');
        Route::get('/canceled-admin', "OrderController@canceledAdmin")->name('manager_order_canceled_by_admin');
        Route::get('/canceled-customer', "OrderController@canceledCustomer")->name('manager_order_canceled_by_customer');
        Route::post('/filter', "OrderController@filter")->name('manager_order_filter');
        Route::post('/ordinary-orders', "OrderController@ordinary")->name('manager_order_ordinary');
    });
});



//Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');






Route::group(['prefix' => '/invoice', 'namespace' => 'Invoice'], function () {
    Route::group(['middleware' => 'invoice.auth'], function () {
        Route::get('/', 'HomeController@index' )->name('invoice.index');
    });
    Route::get('/home', 'HomeController@home')->name('invoice.home')->middleware('invoice.auth');

    Route::get('/errors', 'Users\ProjectController@errors')->name('errors');

    Route::get('/login', 'HomeController@login')->name('invoice.login');
    Route::get('/invite-register', 'HomeController@register')->name('invoice.register');
    Route::post('/register', 'HomeController@regUser')->name('invoice.register.user');

    Route::get('/forget-password','ForgetPasswordController@getEmail')->name('invoice.get.forget-password');
    Route::post('/forget-password','ForgetPasswordController@postEmail')->name('invoice.post.forget-password');

    Route::get('/reset-password/{token}', 'ForgetPasswordController@getPassword')->name('invoice.get.resetPassword');
    Route::post('/reset-password', 'ForgetPasswordController@updatePassword')->name('invoice.post.updatePassword');

    Route::post('/login', 'HomeController@auth')->name('invoice.auth.login');
    Route::post('/logout', 'HomeController@logout')->name('invoice.auth.logout');
    Route::post('/check-user', 'HomeController@checkUser')->name('invoice.check_user');

    Route::group(['prefix' => 'users', 'namespace' => 'Users'], function () {
        Route::group(['prefix' => '/projects'], function() {
            Route::get('/', 'ProjectController@index')->name('invoice.users.projects');
            Route::post('/create', 'ProjectController@create')->name('invoice.users.project_create_task');
            Route::post('/get-task', 'ProjectController@getTask')->name('invoice.users.project_get_task');
            Route::post('/search', 'ProjectController@searchProject')->name('invoice.users.projects_search');
            Route::post('/remove', 'ProjectController@taskRemove')->name('invoice.user.task_remove');

            Route::group(['prefix' => '{id}'], function() {
                Route::get('/view', 'ProjectController@view')->name('invoice.users.project_view');
                Route::post('/update', 'ProjectController@update')->name('invoice.users.project_update');

                Route::post('/delete-task', 'ProjectController@deleteTask')->name('invoice.users.project_delete_task');
            });
        });

        Route::group(['prefix' => 'tasks'], function() {
            Route::get('/', 'TaskController@index')->name('invoice.users.tasks');
            Route::post('/select-project-task', 'TaskController@selectProjectTasks')->name('invoice.users.tasks.select_project_tasks');
            Route::post('/search', 'TaskController@search')->name('invoice.users.tasks.search');
        });

        Route::post('/check-old-password', 'UserController@checkOldPassword')->name('invoice.users.check_old_password');
        Route::group(['prefix' => '{id}'], function() {
            Route::get('/', 'UserController@profile')->name('invoice.users.profile');
            Route::get('/settings', 'UserController@settings')->name('invoice.users.profile_settings');
            Route::post('/update', 'UserController@profileUpdate')->name('invoice.users.profile_update');
            Route::post('/update-password', 'UserController@updatePassword')->name('invoice.users.update_password');
        });
    });

    Route::group(['prefix' => '/admin', 'namespace' => 'Admin', 'middleware' => 'invoice.admin'], function () {
        Route::get('/', 'AdminController@index')->name('invoice.admin.dashboard');
        Route::post('/search-project', 'AdminController@searchProject')->name('invoice.admin.search_project');
        Route::post('/search-user', 'AdminController@searchUser')->name('invoice.admin.search_user');
        Route::post('/search', 'AdminController@search')->name('invoice.admin.search');
        Route::post('/search-user-task', 'AdminController@searchUserTask')->name('invoice.admin.search_user_task');
        Route::get('/settings', 'AdminController@settings')->name('invoice.admin.settings');
        Route::post('/check-password', 'AdminController@checkPassword')->name('invoice.admin.check_password');
        Route::post('/update-password/{id}', 'AdminController@updatePassword')->name('invoice.admin.update_password');

        Route::post('/sidebar-update', 'AdminController@sidebarUpdate')->name('invoice.admin.sidebar_update');

        Route::group(['prefix' => '/users'], function () {
             Route::get('/', 'UsersController@index')->name('invoice.admin.users');
             Route::get('/create', 'UsersController@create')->name('invoice.admin.users_create');
             Route::post('/store', 'UsersController@store')->name('invoice.admin.users_store');
             Route::post('/invite', 'UsersController@invite')->name('invoice.admin.users_invite');
             Route::post('/check-email', 'UsersController@checkEmail')->name('invoice.admin.users_check_email');
             Route::post('/remove', 'UsersController@remove')->name('invoice.admin.users_remove');

             Route::group(['prefix' => '{id}'], function(){
                 Route::get('/edit', 'UsersController@edit')->name('invoice.admin.users_edit');
                 Route::post('/update', 'UsersController@update')->name('invoice.admin.users_update');
                 Route::delete('/delete', 'UsersController@delete')->name('invoice.admin.users_delete');
             });
        });

        Route::group(['prefix' => '/project'], function() {
            Route::get('/', 'ProjectController@index')->name('invoice.admin.project');
            Route::get('/create', 'ProjectController@create')->name('invoice.admin.project_create');
            Route::post('/store', 'ProjectController@store')->name('invoice.admin.project_store');
            Route::post('/check-user', 'ProjectController@checkUser')->name('invoice.admin.project_check_user');
            Route::post('/add-project-user', 'ProjectController@addProjectUser')->name('invoice.admin.project_add_user');
            Route::post('/remove-project-user', 'ProjectController@removeProjectUser')->name('invoice.admin.project_remove_user');
            Route::post('/remove-user-in-project', 'ProjectController@removeUserInProject')->name('invoice.admin.user_in_project');
            Route::post('/search', 'ProjectController@search')->name('invoice.admin.project_search');

            Route::group(['prefix' => '{id}'], function(){
                Route::get('/edit-task', 'ProjectController@editTask')->name('invoice.admin.project_edit_task');
                Route::post('/update-task', 'ProjectController@updateTask')->name('invoice.admin.project_update_task');
                Route::get('/show', 'ProjectController@show')->name('invoice.admin.project_show');
                Route::get('/edit', 'ProjectController@edit')->name('invoice.admin.project_edit');
                Route::get('/fields', 'ProjectController@fields')->name('invoice.admin.project_fields');
                Route::group(['prefix' => '/fields'], function(){
                    Route::post('/items', 'ProjectController@items')->name('invoice.admin.project_fields_items');
                    Route::post('/creat', 'ProjectController@CreatFields')->name('invoice.admin.project_fields_creat');
                    Route::post('/update', 'ProjectController@UpdateFields')->name('invoice.admin.project_fields_update');
                    Route::post('/search', 'ProjectController@Searchfield')->name('invoice.admin.project_fields_search');
                });
                Route::post('/update', 'ProjectController@update')->name('invoice.admin.project_update');
                Route::delete('/delete', 'ProjectController@delete')->name('invoice.admin.project_delete');
                Route::get('/team', 'ProjectController@team')->name('invoice.admin.project_team');
            });
        });

        Route::group(['prefix' => '/currency'], function() {
            Route::get('/', 'CurrencyController@index')->name('invoice.admin.currency');
            Route::post('/store', 'CurrencyController@store')->name('invoice.admin.currency_store');
            Route::post('/{id}/delete', 'CurrencyController@delete')->name('invoice.admin.currency_delete');
        });

        Route::group(['prefix' => '/tasks'], function () {
            Route::get('/', 'TaskController@index')->name('invoice.admin.task');
            Route::get('/create', 'TaskController@create')->name('invoice.admin.task_create');
            Route::post('/create', 'TaskController@create')->name('invoice.admin.task_create_post');
            Route::post('/store', 'TaskController@store')->name('invoice.admin.task_store');
            Route::post('/select-project', 'TaskController@selectProject')->name('invoice.admin.task_select_project');
            Route::post('/remove', 'TaskController@taskRemove')->name('invoice.admin.task_remove');

            Route::group(['prefix' => '/{id}'], function () {
                Route::get('/show', 'TaskController@taskShow')->name('invoice.admin.task_show');
                Route::post('/update', 'TaskController@taskUpdate')->name('invoice.admin.task_update');
            });
        });
        // ------------------ Admin menu left bar setting---------------------
        Route::group(['prefix' => '/setting'], function() {
            Route::get('/', 'SettingsController@index')->name('invoice.admin.settings');
            Route::get('/create', 'SettingsController@create')->name('invoice.admin.setting_create');
            Route::get('/newcreate', 'SettingsController@newcreate')->name('invoice.admin.setting_newcreate');
            Route::post('/store', 'SettingsController@store')->name('invoice.admin.setting_store');
            Route::post('/delete', 'SettingsController@deleteField')->name('invoice.admin.setting_field_delete');
            
            Route::group(['prefix' => '{id}'], function(){
                Route::get('/edit', 'SettingsController@edit')->name('invoice.admin.setting_edit');
                Route::post('/update', 'SettingsController@update')->name('invoice.admin.setting_update');
                Route::post('/delete', 'SettingsController@delete')->name('invoice.admin.setting_delete');
                
            });
        });
        // ------------------------------------------------------------------

        Route::group(['prefix' => '/reports'], function() {
            Route::get('/', 'ReportsController@index')->name('invoice.admin.reports');
            Route::post('/store', 'ReportsController@store')->name('invoice.admin.reports_store');
            Route::post('/get-project', 'ReportsController@getProject')->name('invoice.admin.reports_get_project');
            Route::post('/get-users', 'ReportsController@getUsers')->name('invoice.admin.reports_get_users');
            Route::post('/get-report', 'ReportsController@getReport')->name('invoice.admin.reports_get_report');
            Route::post('/update-report/{id}', 'ReportsController@updateReport')->name('invoice.admin.reports_update_report');
        });

        Route::group(['prefix' => '/invoice'], function () {
            Route::get('/', 'InvoiceController@index')->name('invoice.admin.invoice');
        });

        Route::group(['prefix' => '/desc', 'namespace' => 'Desc'], function () {
            Route::get('/', 'DescController@index')->name('invoice.admin.desc');
            Route::post('/slug', 'DescController@slug')->name('invoice.admin.desc.url_slug');
            Route::post('/field-slug', 'DescFieldController@slug')->name('invoice.admin.desc.url_field_slug');

            Route::group(['prefix' => 'fill'], function() {
                Route::get('/all', 'DescController@allFill')->name('invoice.admin.desc_all_fill');
                Route::get('/create', 'DescController@createFill')->name('invoice.admin.desc_create_fill');
                Route::post('/store', 'DescController@storeFill')->name('invoice.admin.desc_store_fill');
                Route::post('/restore', 'DescDataController@restore')->name('invoice.admin.desc.fill.restore');
                Route::post('/force-delete-create', 'DescDataController@forceDeleteAndCreate')->name('invoice.admin.desc.fill.force_delete_create');

                Route::group(['prefix' => '{id}'], function () {
                    Route::get('/edit', 'DescController@editFill')->name('invoice.admin.desc_edit_fill');
                    Route::post('/update', 'DescController@updateFill')->name('invoice.admin.desc_update_fill');
                    Route::delete('/delete', 'DescController@deleteFill')->name('invoice.admin.desc_delete_fill');
                });
            });

            Route::group(['prefix' => '{slug}'], function () {
                Route::get('/', 'DescController@dynamic')->name('invoice.admin.desc_dynamic');
                Route::get('/create', 'DescController@fillDynamicCreate')->name('invoice.admin.desc_fill_dynamic_create');

                Route::post('/create-grasexans-name', 'DescDataController@createGrasexansName')->name('invoice.admin.desc.create_grasexans_name');
                Route::post('/create-grasexans-data', 'DescDataController@createGrasexansdata')->name('invoice.admin.desc.create_grasexans_data');
            
                Route::group(['prefix' => 'field'], function () {
                    Route::get('/', 'DescFieldController@index')->name('invoice.admin.desc.fill_fields');
                    Route::get('/create', 'DescFieldController@create')->name('invoice.admin.desc.fill_create_field');
                    Route::post('/store', 'DescFieldController@storeField')->name('invoice.admin.desc.fill_store_field');
                    Route::post('/delete', 'DescFieldController@deleteField')->name('invoice.admin.desc.fill_delete_field');
                    Route::group(['prefix' => '{id}'], function () {
                        Route::get('/edit', 'DescFieldController@editField')->name('invoice.admin.desc.fill_edit_field');
                        Route::post('/update', 'DescFieldController@updateField')->name('invoice.admin.desc.fill_update_field');
                    });
                });
                Route::group(['prefix' => '{field_slug}'], function () {
                    Route::get('/', 'DescDataController@index')->name('invoice.admin.desc.fill.field_data');
                    Route::get('/create', 'DescDataController@create')->name('invoice.admin.desc.fill.create_field_data');
                    Route::post('/create-data-name', 'DescDataController@createDataName')->name('invoice.admin.desc.fill.field.create_data_name');
                    Route::post('/delete-data-name', 'DescDataController@deleteDataName')->name('invoice.admin.desc.fill.field.delete_data_name');
                    Route::post('/create-add-prop-name', 'DescDataController@createAddPropName')->name('invoice.admin.desc.fill.field.create_add_prop_name');
                    Route::post('/delete-add-prop-name', 'DescDataController@deleteAddPropName')->name('invoice.admin.desc.fill.field.delete_add_prop_name');
                    Route::post('/create-data', 'DescDataController@createData')->name('invoice.admin.desc.fill.field.create_data');
                    Route::post('/delete-data', 'DescDataController@deleteData')->name('invoice.admin.desc.fill.field.delete_data');
                    Route::post('/get-unit-price', 'DescDataController@unitPrice')->name('invoice.admin.desc.fill.field.unit_price');
                    Route::post('/create-payment', 'DescDataController@createPayment')->name('invoice.admin.desc.fill.field.create_payment');
                    Route::post('/image', 'DescDataController@image')->name('invoice.admin.desc.fill.field.image');
                    Route::post('/filter-data', 'DescDataController@filterData')->name('invoice.admin.desc.fill.field.filter_data');
                });
            });
        });
    });
});