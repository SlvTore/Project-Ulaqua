<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EresAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CalendarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::controller(App\Http\Controllers\EresAdminController::class)->group(function () {
        Route::get('/', 'dashboard');
        Route::get('/app-calender', 'app_calender');
        Route::get('/app-profile', 'app_profile');
        Route::get('/appointment', 'appointment');
        Route::get('/chart-chartist', 'chart_chartist');
        Route::get('/chart-chartjs', 'chart_chartjs');
        Route::get('/chart-flot', 'chart_flot');
        Route::get('/chart-morris', 'chart_morris');
        Route::get('/chart-peity', 'chart_peity');
        Route::get('/chart-sparkline', 'chart_sparkline');
        Route::get('/doctor-detail', 'doctor_detail');
        Route::get('/doctor-list', 'doctor_list');
        Route::get('/ecom-checkout', 'ecom_checkout');
        Route::get('/ecom-customers', 'ecom_customers');
        Route::get('/ecom-invoice', 'ecom_invoice');
        Route::get('/ecom-product-detail', 'ecom_product_detail');
        Route::get('/ecom-product-grid', 'ecom_product_grid');
        Route::get('/ecom-product-list', 'ecom_product_list');
        Route::get('/ecom-product-order', 'ecom_product_order');
        Route::match(['get','post'],'/email-compose','email_compose');
        Route::get('/email-inbox', 'email_inbox');
        Route::get('/email-read', 'email_read');
        Route::get('/form-ckeditor', 'form_ckeditor');
        Route::get('/form-element', 'form_element');
        Route::get('/form-pickers', 'form_pickers');
        Route::get('/form-validation-jquery', 'form_validation_jquery');
        Route::get('/form-wizard', 'form_wizard');
        Route::get('/index-2', 'dashboard_2');
        Route::get('/index', 'dashboard');
        Route::get('/map-jqvmap', 'map_jqvmap');
        Route::get('/page-error-400', 'page_error_400');
        Route::get('/page-error-403', 'page_error_403');
        Route::get('/page-error-404', 'page_error_404');
        Route::get('/page-error-500', 'page_error_500');
        Route::get('/page-error-503', 'page_error_503');
        Route::get('/page-forgot-password', 'page_forgot_password');
        Route::get('/page-lock-screen', 'page_lock_screen');
        Route::get('/page-login', 'page_login');
        Route::get('/page-register', 'page_register');
        Route::get('/page-review', 'page_review');
        Route::get('/patient-details', 'patient_details');
        Route::get('/patient-list', 'patient_list');
        Route::match(['get','post'],'/post-details','post_details');
        Route::get('/staff-profile', 'staff_profile');
        Route::get('/staff', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::post('/staff', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::put('/staff/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/staff/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/table-bootstrap-basic', 'table_bootstrap_basic');
        Route::get('/table-datatable-basic', 'table_datatable_basic');
        Route::get('/uc-lightgallery', 'uc_lightgallery');
        Route::get('/uc-nestable', 'uc_nestable');
        Route::get('/uc-noui-slider', 'uc_noui_slider');
        Route::get('/uc-select2', 'uc_select2');
        Route::get('/uc-sweetalert', 'uc_sweetalert');
        Route::get('/uc-toastr', 'uc_toastr');
        Route::get('/ui-accordion', 'ui_accordion');
        Route::get('/ui-alert', 'ui_alert');
        Route::get('/ui-badge', 'ui_badge');
        Route::get('/ui-button-group', 'ui_button_group');
        Route::get('/ui-button', 'ui_button');
        Route::get('/ui-card', 'ui_card');
        Route::get('/ui-carousel', 'ui_carousel');
        Route::get('/ui-dropdown', 'ui_dropdown');
        Route::get('/ui-grid', 'ui_grid');
        Route::get('/ui-list-group', 'ui_list_group');
        Route::get('/ui-media-object', 'ui_media_object');
        Route::get('/ui-modal', 'ui_modal');
        Route::get('/ui-pagination', 'ui_pagination');
        Route::get('/ui-popover', 'ui_popover');
        Route::get('/ui-progressbar', 'ui_progressbar');
        Route::get('/ui-tab', 'ui_tab');
        Route::get('/ui-typography', 'ui_typography');
        Route::get('/widget-basic', 'widget_basic');
    });

    // Menu Khusus Manager untuk kelola user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Rute Master WAREHOUSE (Fase 2)
    Route::get('/warehouse/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/warehouse/items', [ItemController::class, 'store'])->name('items.store');
    Route::put('/warehouse/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/warehouse/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
    Route::patch('/warehouse/items/{item}/toggle-status', [ItemController::class, 'toggleStatus'])->name('items.toggle_status');

    // RUTE TRANSAKSI GUDANG
    Route::get('/warehouse/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/warehouse/inventory', [App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');

    // RUTE STOK OPNAME (BARU)
    Route::get('/warehouse/opname', [App\Http\Controllers\InventoryController::class, 'opname'])->name('inventory.opname');
    Route::post('/warehouse/opname', [App\Http\Controllers\InventoryController::class, 'storeOpname'])->name('inventory.storeOpname');

    // RUTE MASTER BOM
    Route::resource('/warehouse/boms', App\Http\Controllers\BomController::class);

    // ============================================
    // RUTE FINANCE & PRODUKSI (FASE 4)
    // ============================================

    Route::resource('/finance/productions', App\Http\Controllers\ProductionController::class);

    // Route Penjualan (Kas Masuk Gudang / Finance Sales)
    Route::resource('/finance/sales', App\Http\Controllers\SaleController::class);

    // Route Report / Dashboard Arus Kas
    Route::get('/finance/reports/cashflow', [App\Http\Controllers\FinanceReportController::class, 'dashboard'])->name('finance.reports.cashflow');

    // Rute Kalender Klien (Pindahkan ke dalam sini, sebelum resource /clients)
    Route::get('/clients/calendar', [CalendarController::class, 'index'])->name('clients.calendar');
    Route::get('/clients/calendar/events', [CalendarController::class, 'getEvents'])->name('clients.calendar.events');
    Route::post('/clients/calendar/store', [CalendarController::class, 'storeEvent'])->name('clients.calendar.store');
    Route::post('/clients/calendar/update/{id}', [CalendarController::class, 'updateEventDrop'])->name('clients.calendar.update');
    Route::delete('/clients/calendar/delete/{id}', [CalendarController::class, 'destroyEvent'])->name('clients.calendar.destroy');

    Route::resource('/clients', \App\Http\Controllers\ClientController::class);
    Route::patch('/clients/{id}/update-tag', [\App\Http\Controllers\ClientController::class, 'updateTag'])->name('clients.update_tag');
    Route::patch('/clients/{id}/update-photo', [\App\Http\Controllers\ClientController::class, 'updatePhoto'])->name('clients.update_photo');
});

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

