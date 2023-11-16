<?php

use App\Models\Utility;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index'])->middleware(['XSS']);
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index'])->middleware(['auth', 'XSS']);

// Route::get('/', 'DashboardController@account_dashboard_index')->name('home')->middleware(
//     [
//         'XSS',
//         'revalidate',
//     ]
// );

Route::get('reportnew', 'reportnew@index')->name('diary')->middleware(
    [
        'auth',
        'XSS',
    ]
);

//diary

Route::get('diary', 'DiaryController@index')->name('diary_new')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('diary_data', 'DiaryController@diary_display_table')->name('diary_data')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/company-invitation-consultant/{id}','ConsultantController@createConnection')->middleware('guest');
Route::get('/company-invitation-consultant/{id}/{status}','ConsultantController@submitConnection')->middleware('guest');

Route::get('/company-invitation-subcontractor/{id}','SubContractorController@createConnection')->middleware('guest');
Route::get('/company-invitation-subcontractor/{id}/{status}','SubContractorController@submitConnection')
->middleware('guest');

Route::get('diary/{id}', 'DiaryController@show')->name('diary.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'diary-view', [
        'as' => 'filter.diary.view',
        'uses' => 'DiaryController@filterDiaryView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('show_consultant_direction', 'DiaryController@show_consultant_direction')
    ->name('show_consultant_direction')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('add_consultant_direction', 'DiaryController@add_consultant_direction')
    ->name('add_consultant_direction')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('edit_consultant_direction', 'DiaryController@edit_consultant_direction')
    ->name('edit_consultant_direction')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('save_consultant_direction', 'DiaryController@save_consultant_direction')
    ->name('save_consultant_direction')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('update_consultant_direction', 'DiaryController@update_consultant_direction')
    ->name('update_consultant_direction')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::post('delete_consultant_direction/{id}', 'DiaryController@delete_consultant_direction')
    ->name('delete_consultant_direction')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::get('rfi_show_info', 'DiaryController@rfi_show_info')->name('rfi_show_info')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('get_name_of_consultant', 'DiaryController@get_name_of_consultant')
    ->name('get_name_of_consultant')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('rfi_info_status', 'DiaryController@rfi_info_status')->name('rfi_info_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('rfi_info_main_save', 'DiaryController@rfi_info_main_save')->name('rfi_info_main_save')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('edit_rfi_info_status', 'DiaryController@edit_rfi_info_status')->name('edit_rfi_info_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('update_rfi_info_status', 'DiaryController@update_rfi_info_status')
    ->name('update_rfi_info_status')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('delete_rfi_status', 'DiaryController@delete_rfi_status')->name('delete_rfi_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('add_project_specification', 'DiaryController@add_project_specification')
    ->name('add_project_specification')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('save_project_specification', 'DiaryController@save_project_specification')
    ->name('save_project_specification')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('edit_project_specification', 'DiaryController@edit_project_specification')
    ->name('edit_project_specification')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('update_project_specification', 'DiaryController@update_project_specification')
    ->name('update_project_specification')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::get('show_project_specification', 'DiaryController@show_project_specification')
    ->name('show_project_specification')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('delete_project_specification', 'DiaryController@delete_project_specification')
    ->name('delete_project_specification')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::get('variation_scope_change', 'DiaryController@variation_scope_change')
    ->name('variation_scope_change')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('add_variation_scope_change', 'DiaryController@add_variation_scope_change')
    ->name('add_variation_scope_change')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('save_variation_scope_change', 'DiaryController@save_variation_scope_change')
    ->name('save_variation_scope_change')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('edit_variation_scope_change', 'DiaryController@edit_variation_scope_change')
    ->name('edit_variation_scope_change')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('update_variation_scope_change', 'DiaryController@update_variation_scope_change')
    ->name('update_variation_scope_change')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('delete_variation_scope_change', 'DiaryController@delete_variation_scope_change')
    ->name('delete_variation_scope_change')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::get('procurement_material', 'DiaryController@procurement_material')->name('procurement_material')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('add_procurement_material', 'DiaryController@add_procurement_material')
    ->name('add_procurement_material')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('save_procurement_material', 'DiaryController@save_procurement_material')
    ->name('save_procurement_material')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('edit_procurement_material', 'DiaryController@edit_procurement_material')
    ->name('edit_procurement_material')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('update_procurement_material', 'DiaryController@update_procurement_material')
    ->name('update_procurement_material')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('delete_procurement_material', 'DiaryController@delete_procurement_material')
    ->name('delete_procurement_material')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('save_site_reports', 'DiaryController@save_site_reports')->name('save_site_reports')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('update_site_reports', 'DiaryController@update_site_reports')->name('update_site_reports')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('delete_site_reports', 'DiaryController@delete_site_reports')->name('delete_site_reports')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('check_duplicate_diary_email', 'DiaryController@check_duplicate_diary_email')
    ->name('check_duplicate_diary_email')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('diary_download_file', 'DiaryController@diary_download_file')->name('diary_download_file')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('vo_change_download_file', 'DiaryController@vo_change_download_file')->name('vo_change_download_file')->middleware(
    [
        'auth',
        'XSS',
    ]
);

/* Drawing List */

Route::any('drawing_list', 'DiaryController@drawing_list')->name('drawing_list')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('drawing_selection_list', 'DiaryController@drawing_selection_list')
    ->name('drawing_selection_list')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('create_shop_drawing_list', 'DiaryController@create_shop_drawing_list')
    ->name('create_shop_drawing_list')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('ConstructionDrawingsedit', 'DiaryController@ConstructionDrawingsedit')
        ->name('ConstructionDrawingsedit')->middleware(
            [
                'auth',
                'XSS',
            ]
        );

Route::any('ConstructionDrawingscreate', 'DiaryController@ConstructionDrawingscreate')
    ->name('ConstructionDrawingscreate')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('shopdrawing_listedit', 'DiaryController@shopdrawing_listedit')->name('shopdrawing_listedit')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('shopdrawing_listcreate', 'DiaryController@shopdrawing_listcreate')
    ->name('shopdrawing_listcreate')->middleware(
        [
            'auth',
            'XSS',
        ]
    );

/*Daily  Reports */

Route::any('daily_reports', 'DiaryController@daily_reports')->name('daily_reports')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('daily_reportscreate', 'DiaryController@daily_reportscreate')->name('daily_reportscreate')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('daily_reportsedit/{id}', 'DiaryController@daily_reportsedit')->name('daily_reportsedit')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('/consultant_index', 'DashboardController@consultant_index')->name('consultant_index')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);

Route::get('/home', 'DashboardController@account_dashboard_index')->name('new_home')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);

Route::get('/', 'DashboardController@account_dashboard')->name('new_home')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('/new_home', 'DashboardController@account_dashboard')->name('new_home')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('instance_project_dairy/{instance_id}/{project_id}', 'RevisionController@instance_project_dairy')->name('projects.instance_project_dairy')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('hrm_dashboard', 'DashboardController@hrm_dashboard')->name('hrm_dashboard')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('/hrm_main', 'DashboardController@hrm_main')->name('hrm_main')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);

// HRM Document Setup CRUD
Route::resource('hrm_doc_setup', 'DucumentUploadController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('/hrm_download_file/{id}', 'DucumentUploadController@hrm_download_file')->name('hrm_download_file')->middleware(['XSS', 'revalidate']);

// HRM Company Policy CRUD
Route::resource('hrm_company_policy', 'CompanyPolicyController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('/email-settings', 'SystemController@emailsettings')->name('emailsettings')->middleware(['XSS', 'revalidate']);
Route::get('/company-settings', 'SystemController@companysettings')->name('companysettings')->middleware(['auth', 'XSS', 'revalidate']);
Route::get('/system-settings', 'SystemController@systemsettings')->name('systemsettings')->middleware(['auth', 'XSS', 'revalidate']);

Route::get('/construction_main/productivity', 'DashboardController@construction_main')->name('construction_main')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('/dairy_main/dairy/productivity', 'DashboardController@dairy_main')->name('dairy_main')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('checkDuplicateProject', 'ProjectController@checkDuplicateProject')->name('checkDuplicateProject')->middleware(['auth', 'XSS', 'revalidate']);

Route::get('/paymentPage', 'Auth\RegisteredUserController@paymentPage');
Route::get('/register/{lang?}', 'Auth\RegisteredUserController@showRegistrationForm')->name('register');
//Route::get('/register/{lang?}', function () {
//    $settings = Utility::settings();
//    $lang = $settings['default_language'];
//
//    if($settings['enable_signup'] == 'on'){
//        return view("auth.register", compact('lang'));
//       // Route::get('/register', 'Auth\RegisteredUserController@showRegistrationForm')->name('register');
//    }else{
//        return Redirect::to('login');
//    }
//
//});

Route::post('register', 'Auth\RegisteredUserController@store')->name('register');

Route::get('/login/{lang?}', 'Auth\AuthenticatedSessionController@showLoginForm')->name('login');

// Route::get('/password/resets/{lang?}', 'Auth\AuthenticatedSessionController@showLinkRequestForm')->name('change.langPass');
// Route::get('/password/resets/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Route::get('/', 'DashboardController@account_dashboard_index')->name('dashboard')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);

Route::get('/account-dashboard', 'DashboardController@account_dashboard_index')->name('dashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('/project-dashboard', 'DashboardController@project_dashboard_index')->name('project.dashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('/hrm-dashboard', 'DashboardController@hrm_dashboard_index')->name('hrm.dashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('new_profile', 'UserController@new_profile')->name('new_profile')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('delete_new_profile', 'UserController@delete_new_profile')->name('delete_new_profile')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::post('edit-profile', 'UserController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::post('new_edit_profile', 'UserController@new_edit_profile')->name('new_edit_profile')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('users/edit/{id}/{color_code}', 'UserController@edit')->name('user.edit.new')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('check_duplicate_email', 'UserController@check_duplicate_email')->name('check_duplicate_email')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('check_duplicate_mobile', 'UserController@check_duplicate_mobile')->name('check_duplicate_mobile')
    ->middleware(
        [
            'auth',
            'XSS',
        ]
    );

Route::any('check_duplicate_email_consultant', 'ConsultantController@check_duplicate_email_consultant')->name('check_duplicate_email_consultant')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('view_change_password', 'UserController@view_change_password')->name('view_change_password')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::post('change-password', 'UserController@updatePassword')->name('update.password');
Route::post('newpassword', 'UserController@newpassword')->name('newpassword');
Route::any('user-reset-password/{id}', 'UserController@userPassword')->name('users.reset');
Route::post('user-reset-password/{id}', 'UserController@userPasswordReset')->name('user.password.update');

Route::get(
    '/change/mode', [
        'as' => 'change.mode',
        'uses' => 'UserController@changeMode',
    ]
);

Route::resource('roles', 'RoleController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::any('delete_multi_role', 'RoleController@delete_multi_role')->name('delete_multi_role')->middleware(['auth', 'XSS']);

Route::resource('permissions', 'PermissionController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::get('change-language/{lang}', 'LanguageController@changeLanquage')->name('change.language');
        Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language');
        Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data');
        Route::get('create-language', 'LanguageController@createLanguage')->name('create.language');
        Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language');

        Route::delete('/lang/{lang}', 'LanguageController@destroyLang')->name('lang.destroy');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::resource('systems', 'SystemController');
        Route::post('email-settings', 'SystemController@saveEmailSettings')->name('email.settings');
        Route::post('company-settings', 'SystemController@saveCompanySettings')->name('company.settingssave');
        Route::post('system-settings', 'SystemController@saveSystemSettings')->name('system.settings');
        Route::post('zoom-settings', 'SystemController@saveZoomSettings')->name('zoom.settings');
        Route::post('slack-settings', 'SystemController@saveSlackSettings')->name('slack.settings');
        Route::post('telegram-settings', 'SystemController@saveTelegramSettings')->name('telegram.settings');
        Route::post('twilio-setting', 'SystemController@saveTwilioSettings')->name('twilio.setting');

        Route::get('print-setting', 'SystemController@printIndex')->name('print.setting');
        Route::get('company-setting', 'SystemController@companyIndex')->name('company.setting');
        Route::get('companysetting', 'SystemController@companyIndex1')->name('company.settings');
        Route::post('business-setting', 'SystemController@saveBusinessSettings')->name('business.setting');
        Route::post('company-payment-setting', 'SystemController@saveCompanyPaymentSettings')->name('company.payment.settings');

        Route::get('test-mail', 'SystemController@testMail')->name('test.mail');
        Route::post('test-mail', 'SystemController@testMail')->name('test.mail');
        Route::post('test-mail/send', 'SystemController@testSendMail')->name('test.send.mail');

        Route::post('stripe-settings', 'SystemController@savePaymentSettings')->name('payment.settings');
        Route::post('pusher-setting', 'SystemController@savePusherSettings')->name('pusher.setting');
        Route::post('recaptcha-settings', ['as' => 'recaptcha.settings.store', 'uses' => 'SystemController@recaptchaSettingStore'])->middleware(['auth', 'XSS']);
    }
);

Route::get('productservice/index', 'ProductServiceController@index')->name('productservice.index');
Route::get('productservice/{id}/detail', 'ProductServiceController@warehouseDetail')->name('productservice.detail');
Route::post('empty-cart', 'ProductServiceController@emptyCart')->middleware(['auth', 'XSS']);
Route::post('warehouse-empty-cart', 'ProductServiceController@warehouseemptyCart')->name('warehouse-empty-cart')->middleware(['auth', 'XSS']);
Route::resource('productservice', 'ProductServiceController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//Product Stock
Route::resource('productstock', 'ProductStockController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('customer/{id}/show', 'CustomerController@show')->name('customer.show');
        Route::resource('customer', 'CustomerController');

    }
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('mark-attendance', 'MyDetailsController@markattendance')->name('mark-attendance');
        Route::get('my-info', 'MyDetailsController@info')->name('my-info');
        Route::get('my-leave', 'MyDetailsController@leave')->name('my-leave');
        Route::get('my-payslip', 'MyDetailsController@payslip')->name('my-payslip');
        Route::get('my-performance', 'MyDetailsController@performance')->name('my-performance');
        Route::get('my-goals', 'MyDetailsController@goals')->name('my-goals');
        Route::get('my-relief', 'MyDetailsController@relief')->name('my-relief');
        Route::get('my-appraisal', 'MyDetailsController@appraisal')->name('my-appraisal');
    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('vender/{id}/show', 'VenderController@show')->name('vender.show');
        Route::resource('vender', 'VenderController');

    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::resource('bank-account', 'BankAccountController');

    }
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('bank-transfer/index', 'BankTransferController@index')->name('bank-transfer.index');
        Route::resource('bank-transfer', 'BankTransferController');

    }
);

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('product-category', 'ProductServiceCategoryController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('product-unit', 'ProductServiceUnitController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('invoice/pdf/{id}', 'InvoiceController@invoice')->name('invoice.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('invoice/{id}/duplicate', 'InvoiceController@duplicate')->name('invoice.duplicate');
        Route::get('invoice/{id}/shipping/print', 'InvoiceController@shippingDisplay')->name('invoice.shipping.print');
        Route::get('invoice/{id}/payment/reminder', 'InvoiceController@paymentReminder')->name('invoice.payment.reminder');
        Route::get('invoice/index', 'InvoiceController@index')->name('invoice.index');
        Route::post('invoice/product/destroy', 'InvoiceController@productDestroy')->name('invoice.product.destroy');
        Route::post('invoice/product', 'InvoiceController@product')->name('invoice.product');
        Route::post('invoice/customer', 'InvoiceController@customer')->name('invoice.customer');
        Route::get('invoice/{id}/sent', 'InvoiceController@sent')->name('invoice.sent');
        Route::get('invoice/{id}/resent', 'InvoiceController@resent')->name('invoice.resent');
        Route::get('invoice/{id}/payment', 'InvoiceController@payment')->name('invoice.payment');
        Route::post('invoice/{id}/payment', 'InvoiceController@createPayment')->name('invoice.payment');
        Route::post('invoice/{id}/payment/{pid}/destroy', 'InvoiceController@paymentDestroy')->name('invoice.payment.destroy');
        Route::get('invoice/items', 'InvoiceController@items')->name('invoice.items');

        Route::resource('invoice', 'InvoiceController');
        Route::get('invoice/create/{cid}', 'InvoiceController@create')->name('invoice.create');
    }
);

Route::get(
    '/invoices/preview/{template}/{color}', [
        'as' => 'invoice.preview',
        'uses' => 'InvoiceController@previewInvoice',
    ]
);
Route::post(
    '/invoices/template/setting', [
        'as' => 'template.setting',
        'uses' => 'InvoiceController@saveTemplateSettings',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('credit-note', 'CreditNoteController@index')->name('credit.note');
        Route::get('custom-credit-note', 'CreditNoteController@customCreate')->name('invoice.custom.credit.note');
        Route::post('custom-credit-note', 'CreditNoteController@customStore')->name('invoice.custom.credit.note');
        Route::get('credit-note/invoice', 'CreditNoteController@getinvoice')->name('invoice.get');
        Route::get('invoice/{id}/credit-note', 'CreditNoteController@create')->name('invoice.credit.note');
        Route::post('invoice/{id}/credit-note', 'CreditNoteController@store')->name('invoice.credit.note');
        Route::get('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@edit')->name('invoice.edit.credit.note');
        Route::post('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@update')->name('invoice.edit.credit.note');
        Route::delete('invoice/{id}/credit-note/delete/{cn_id}', 'CreditNoteController@destroy')->name('invoice.delete.credit.note');

    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('debit-note', 'DebitNoteController@index')->name('debit.note');
        Route::get('custom-debit-note', 'DebitNoteController@customCreate')->name('bill.custom.debit.note');
        Route::post('custom-debit-note', 'DebitNoteController@customStore')->name('bill.custom.debit.note');
        Route::get('debit-note/bill', 'DebitNoteController@getbill')->name('bill.get');
        Route::get('bill/{id}/debit-note', 'DebitNoteController@create')->name('bill.debit.note');
        Route::post('bill/{id}/debit-note', 'DebitNoteController@store')->name('bill.debit.note');
        Route::get('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@edit')->name('bill.edit.debit.note');
        Route::post('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@update')->name('bill.edit.debit.note');
        Route::delete('bill/{id}/debit-note/delete/{cn_id}', 'DebitNoteController@destroy')->name('bill.delete.debit.note');

    }
);

Route::get(
    '/bill/preview/{template}/{color}', [
        'as' => 'bill.preview',
        'uses' => 'BillController@previewBill',
    ])->middleware(['auth', 'XSS']);

Route::post(
    '/bill/template/setting', [
        'as' => 'bill.template.setting',
        'uses' => 'BillController@saveBillTemplateSettings',
    ]
);

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('revenue/index', 'RevenueController@index')->name('revenue.index')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('revenue', 'RevenueController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('bill/pdf/{id}', 'BillController@bill')->name('bill.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('bill/{id}/duplicate', 'BillController@duplicate')->name('bill.duplicate');
        Route::get('bill/{id}/shipping/print', 'BillController@shippingDisplay')->name('bill.shipping.print');
        Route::get('bill/index', 'BillController@index')->name('bill.index');
        Route::post('bill/product/destroy', 'BillController@productDestroy')->name('bill.product.destroy');
        Route::post('bill/product', 'BillController@product')->name('bill.product');
        Route::post('bill/vender', 'BillController@vender')->name('bill.vender');
        Route::get('bill/{id}/sent', 'BillController@sent')->name('bill.sent');
        Route::get('bill/{id}/resent', 'BillController@resent')->name('bill.resent');
        Route::get('bill/{id}/payment', 'BillController@payment')->name('bill.payment');
        Route::post('bill/{id}/payment', 'BillController@createPayment')->name('bill.payment');
        Route::post('bill/{id}/payment/{pid}/destroy', 'BillController@paymentDestroy')->name('bill.payment.destroy');
        Route::get('bill/items', 'BillController@items')->name('bill.items');

        Route::resource('bill', 'BillController');
        Route::get('bill/create/{cid}', 'BillController@create')->name('bill.create');
    }
);

Route::get('payment/index', 'PaymentController@index')->name('payment.index')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('payment', 'PaymentController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('report/transaction', 'TransactionController@index')->name('transaction.index');

    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('report/income-summary', 'ReportController@incomeSummary')->name('report.income.summary');
        Route::get('report/expense-summary', 'ReportController@expenseSummary')->name('report.expense.summary');
        Route::get('report/income-vs-expense-summary', 'ReportController@incomeVsExpenseSummary')->name('report.income.vs.expense.summary');
        Route::get('report/tax-summary', 'ReportController@taxSummary')->name('report.tax.summary');
        Route::get('report/profit-loss-summary', 'ReportController@profitLossSummary')->name('report.profit.loss.summary');

        Route::get('report/invoice-summary', 'ReportController@invoiceSummary')->name('report.invoice.summary');
        Route::get('report/bill-summary', 'ReportController@billSummary')->name('report.bill.summary');
        Route::get('report/product-stock-report', 'ReportController@productStock')->name('report.product.stock.report');

        Route::get('report/invoice-report', 'ReportController@invoiceReport')->name('report.invoice');
        Route::get('report/account-statement-report', 'ReportController@accountStatement')->name('report.account.statement');

        Route::get('report/balance-sheet', 'ReportController@balanceSheet')->name('report.balance.sheet');
        Route::get('report/ledger', 'ReportController@ledgerSummary')->name('report.ledger');
        Route::get('report/trial-balance', 'ReportController@trialBalanceSummary')->name('trial.balance');
    }
);

Route::get('proposal/pdf/{id}', 'ProposalController@proposal')->name('proposal.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('proposal/{id}/status/change', 'ProposalController@statusChange')->name('proposal.status.change');
        Route::get('proposal/{id}/convert', 'ProposalController@convert')->name('proposal.convert');
        Route::get('proposal/{id}/duplicate', 'ProposalController@duplicate')->name('proposal.duplicate');
        Route::post('proposal/product/destroy', 'ProposalController@productDestroy')->name('proposal.product.destroy');
        Route::post('proposal/customer', 'ProposalController@customer')->name('proposal.customer');
        Route::post('proposal/product', 'ProposalController@product')->name('proposal.product');
        Route::get('proposal/items', 'ProposalController@items')->name('proposal.items');
        Route::get('proposal/{id}/sent', 'ProposalController@sent')->name('proposal.sent');
        Route::get('proposal/{id}/resent', 'ProposalController@resent')->name('proposal.resent');

        Route::resource('proposal', 'ProposalController');
        Route::get('proposal/create/{cid}', 'ProposalController@create')->name('proposal.create');
    }
);

Route::get(
    '/proposal/preview/{template}/{color}', [
        'as' => 'proposal.preview',
        'uses' => 'ProposalController@previewProposal',
    ]
);
Route::post(
    '/proposal/template/setting', [
        'as' => 'proposal.template.setting',
        'uses' => 'ProposalController@saveProposalTemplateSettings',
    ]
);

Route::resource('goal', 'GoalController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//Budget Planner //

Route::resource('budget', 'BudgetController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('account-assets', 'AssetController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('custom-field', 'CustomFieldController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::post('chart-of-account/subtype', 'ChartOfAccountController@getSubType')->name('charofAccount.subType')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::resource('chart-of-account', 'ChartOfAccountController');

    }
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::post('journal-entry/account/destroy', 'JournalEntryController@accountDestroy')->name('journal.account.destroy');
        Route::resource('journal-entry', 'JournalEntryController');

    }
);

// Client Module

Route::resource('clients', 'ClientController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('clients/edit/{id}/{color_code}', 'ClientController@edit')->name('clients.edit.new')
    ->middleware(
        [
            'auth',
            'XSS',
            'revalidate',
        ]
    );

Route::any('client-reset-password/{id}', 'ClientController@clientPassword')->name('clients.reset');
Route::post('client-reset-password/{id}', 'ClientController@clientPasswordReset')->name('client.password.update');
// Deal Module
Route::post(
    '/deals/user', [
        'as' => 'deal.user.json',
        'uses' => 'DealController@jsonUser',
    ]
);
Route::post(
    '/deals/order', [
        'as' => 'deals.order',
        'uses' => 'DealController@order',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/change-pipeline', [
        'as' => 'deals.change.pipeline',
        'uses' => 'DealController@changePipeline',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/change-deal-status/{id}', [
        'as' => 'deals.change.status',
        'uses' => 'DealController@changeStatus',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/labels', [
        'as' => 'deals.labels',
        'uses' => 'DealController@labels',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/labels', [
        'as' => 'deals.labels.store',
        'uses' => 'DealController@labelStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/users', [
        'as' => 'deals.users.edit',
        'uses' => 'DealController@userEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/users', [
        'as' => 'deals.users.update',
        'uses' => 'DealController@userUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/users/{uid}', [
        'as' => 'deals.users.destroy',
        'uses' => 'DealController@userDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/clients', [
        'as' => 'deals.clients.edit',
        'uses' => 'DealController@clientEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/clients', [
        'as' => 'deals.clients.update',
        'uses' => 'DealController@clientUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/clients/{uid}', [
        'as' => 'deals.clients.destroy',
        'uses' => 'DealController@clientDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/products', [
        'as' => 'deals.products.edit',
        'uses' => 'DealController@productEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/products', [
        'as' => 'deals.products.update',
        'uses' => 'DealController@productUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/products/{uid}', [
        'as' => 'deals.products.destroy',
        'uses' => 'DealController@productDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/sources', [
        'as' => 'deals.sources.edit',
        'uses' => 'DealController@sourceEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/sources', [
        'as' => 'deals.sources.update',
        'uses' => 'DealController@sourceUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/sources/{uid}', [
        'as' => 'deals.sources.destroy',
        'uses' => 'DealController@sourceDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/file', [
        'as' => 'deals.file.upload',
        'uses' => 'DealController@fileUpload',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/file/{fid}', [
        'as' => 'deals.file.download',
        'uses' => 'DealController@fileDownload',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/file/delete/{fid}', [
        'as' => 'deals.file.delete',
        'uses' => 'DealController@fileDelete',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/note', [
        'as' => 'deals.note.store',
        'uses' => 'DealController@noteStore',
    ]
)->middleware(['auth']);
Route::get(
    '/deals/{id}/task', [
        'as' => 'deals.tasks.create',
        'uses' => 'DealController@taskCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/task', [
        'as' => 'deals.tasks.store',
        'uses' => 'DealController@taskStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/task/{tid}/show', [
        'as' => 'deals.tasks.show',
        'uses' => 'DealController@taskShow',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/task/{tid}/edit', [
        'as' => 'deals.tasks.edit',
        'uses' => 'DealController@taskEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/task/{tid}', [
        'as' => 'deals.tasks.update',
        'uses' => 'DealController@taskUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/task_status/{tid}', [
        'as' => 'deals.tasks.update_status',
        'uses' => 'DealController@taskUpdateStatus',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/task/{tid}', [
        'as' => 'deals.tasks.destroy',
        'uses' => 'DealController@taskDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/discussions', [
        'as' => 'deals.discussions.create',
        'uses' => 'DealController@discussionCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/discussions', [
        'as' => 'deals.discussion.store',
        'uses' => 'DealController@discussionStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/permission/{cid}', [
        'as' => 'deals.client.permission',
        'uses' => 'DealController@permission',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/permission/{cid}', [
        'as' => 'deals.client.permissions.store',
        'uses' => 'DealController@permissionStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/list', [
        'as' => 'deals.list',
        'uses' => 'DealController@deal_list',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Deal Calls
Route::get(
    '/deals/{id}/call', [
        'as' => 'deals.calls.create',
        'uses' => 'DealController@callCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/call', [
        'as' => 'deals.calls.store',
        'uses' => 'DealController@callStore',
    ]
)->middleware(['auth']);
Route::get(
    '/deals/{id}/call/{cid}/edit', [
        'as' => 'deals.calls.edit',
        'uses' => 'DealController@callEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/call/{cid}', [
        'as' => 'deals.calls.update',
        'uses' => 'DealController@callUpdate',
    ]
)->middleware(['auth']);
Route::delete(
    '/deals/{id}/call/{cid}', [
        'as' => 'deals.calls.destroy',
        'uses' => 'DealController@callDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Deal Email
Route::get(
    '/deals/{id}/email', [
        'as' => 'deals.emails.create',
        'uses' => 'DealController@emailCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/email', [
        'as' => 'deals.emails.store',
        'uses' => 'DealController@emailStore',
    ]
)->middleware(['auth']);
Route::resource('deals', 'DealController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// end Deal Module

Route::get(
    '/search', [
        'as' => 'search.json',
        'uses' => 'UserController@search',
    ]
);
Route::post(
    '/stages/order', [
        'as' => 'stages.order',
        'uses' => 'StageController@order',
    ]
);
Route::post(
    '/stages/json', [
        'as' => 'stages.json',
        'uses' => 'StageController@json',
    ]
);

Route::resource('stages', 'StageController');
Route::resource('pipelines', 'PipelineController');
Route::resource('labels', 'LabelController');
Route::resource('sources', 'SourceController');
Route::resource('payments', 'PaymentController');
Route::resource('custom_fields', 'CustomFieldController');

// Leads Module
Route::post(
    '/lead_stages/order', [
        'as' => 'lead_stages.order',
        'uses' => 'LeadStageController@order',
    ]
);
Route::resource('lead_stages', 'LeadStageController')->middleware(['auth']);
Route::post(
    '/leads/json', [
        'as' => 'leads.json',
        'uses' => 'LeadController@json',
    ]
);
Route::post(
    '/leads/order', [
        'as' => 'leads.order',
        'uses' => 'LeadController@order',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/list', [
        'as' => 'leads.list',
        'uses' => 'LeadController@lead_list',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/file', [
        'as' => 'leads.file.upload',
        'uses' => 'LeadController@fileUpload',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/file/{fid}', [
        'as' => 'leads.file.download',
        'uses' => 'LeadController@fileDownload',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/file/delete/{fid}', [
        'as' => 'leads.file.delete',
        'uses' => 'LeadController@fileDelete',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/note', [
        'as' => 'leads.note.store',
        'uses' => 'LeadController@noteStore',
    ]
)->middleware(['auth']);
Route::get(
    '/leads/{id}/labels', [
        'as' => 'leads.labels',
        'uses' => 'LeadController@labels',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/labels', [
        'as' => 'leads.labels.store',
        'uses' => 'LeadController@labelStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/users', [
        'as' => 'leads.users.edit',
        'uses' => 'LeadController@userEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/users', [
        'as' => 'leads.users.update',
        'uses' => 'LeadController@userUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/users/{uid}', [
        'as' => 'leads.users.destroy',
        'uses' => 'LeadController@userDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/products', [
        'as' => 'leads.products.edit',
        'uses' => 'LeadController@productEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/products', [
        'as' => 'leads.products.update',
        'uses' => 'LeadController@productUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/products/{uid}', [
        'as' => 'leads.products.destroy',
        'uses' => 'LeadController@productDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/sources', [
        'as' => 'leads.sources.edit',
        'uses' => 'LeadController@sourceEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/sources', [
        'as' => 'leads.sources.update',
        'uses' => 'LeadController@sourceUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/sources/{uid}', [
        'as' => 'leads.sources.destroy',
        'uses' => 'LeadController@sourceDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/discussions', [
        'as' => 'leads.discussions.create',
        'uses' => 'LeadController@discussionCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/discussions', [
        'as' => 'leads.discussion.store',
        'uses' => 'LeadController@discussionStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/show_convert', [
        'as' => 'leads.convert.deal',
        'uses' => 'LeadController@showConvertToDeal',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/convert', [
        'as' => 'leads.convert.to.deal',
        'uses' => 'LeadController@convertToDeal',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Lead Calls
Route::get(
    '/leads/{id}/call', [
        'as' => 'leads.calls.create',
        'uses' => 'LeadController@callCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/call', [
        'as' => 'leads.calls.store',
        'uses' => 'LeadController@callStore',
    ]
)->middleware(['auth']);
Route::get(
    '/leads/{id}/call/{cid}/edit', [
        'as' => 'leads.calls.edit',
        'uses' => 'LeadController@callEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/call/{cid}', [
        'as' => 'leads.calls.update',
        'uses' => 'LeadController@callUpdate',
    ]
)->middleware(['auth']);
Route::delete(
    '/leads/{id}/call/{cid}', [
        'as' => 'leads.calls.destroy',
        'uses' => 'LeadController@callDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Lead Email
Route::get(
    '/leads/{id}/email', [
        'as' => 'leads.emails.create',
        'uses' => 'LeadController@emailCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/email', [
        'as' => 'leads.emails.store',
        'uses' => 'LeadController@emailStore',
    ]
)->middleware(['auth']);
Route::resource('leads', 'LeadController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// end Leads Module

Route::get('user/{id}/plan', 'UserController@upgradePlan')->name('plan.upgrade')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('user/{id}/plan/{pid}', 'UserController@activePlan')->name('plan.active')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/{uid}/notification/seen', [
        'as' => 'notification.seen',
        'uses' => 'UserController@notificationSeen',
    ]
);

//contruction Setting
// Route::get('contruction_setting', 'CompanytypeController@setting')->name('contruction_setting')->middleware(
//     [
//         'auth',
//         'XSS',
//     ]
// );
Route::get(
    'projects-users-con', [
        'as' => 'project.user.con',
        'uses' => 'ProductivityController@loadUser',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::delete(
    'projects-con/{id}/users/{uid}', [
        'as' => 'projects.user.con.destroy',
        'uses' => 'ProductivityController@destroyProjectUser',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

//################################################################

Route::post(
    '/projectscon/{id}/checklist/update/{cid}', [
        'as' => 'checklistcon.update',
        'uses' => 'ProjectTaskconController@checklistUpdate',
    ]
);
Route::delete(
    '/projects/{id}/checklist/{cid}', [
        'as' => 'checklistcon.destroy',
        'uses' => 'ProjectTaskconController@checklistDestroy',
    ]
);
Route::post(
    '/projectscon/{id}/checklist/{tid}', [
        'as' => 'checklistcon.store',
        'uses' => 'ProjectTaskconController@checklistStore',
    ]
);

Route::get(
    '/projectscon/task/{id}/get', [
        'as' => 'projectscon.tasks.get',
        'uses' => 'ProjectTaskconController@taskGet',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/projectscon/{id}/task/{tid}', [
        'as' => 'projectscon.tasks.destroy',
        'uses' => 'ProjectTaskconController@destroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post(
    '/projectscon/{id}/task/update/{tid}', [
        'as' => 'projectscon.tasks.update',
        'uses' => 'ProjectTaskconController@update',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/projectscon/{id}/task/{tid}/edit', [
        'as' => 'projectscon.tasks.edit',
        'uses' => 'ProjectTaskconController@edit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::patch(
    '/projectscon/{id}/task/order', [
        'as' => 'taskscon.update.order',
        'uses' => 'ProjectTaskconController@taskOrderUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projectscon/{pid}/task/{sid}', [
        'as' => 'projectscon.tasks.store',
        'uses' => 'ProjectTaskconController@store',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projectscon/{pid}/task/{sid}', [
        'as' => 'projectscon.tasks.create',
        'uses' => 'ProjectTaskconController@create',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/projectscon/{id}/task', [
        'as' => 'projectscon.tasks.index',
        'uses' => 'ProjectTaskconController@index',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post(
    'con_projects/milestone/{id}', [
        'as' => 'con_project.milestone.update',
        'uses' => 'ProductivityController@milestoneUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    'con_projects/milestone/{id}', [
        'as' => 'con_project.milestone.destroy',
        'uses' => 'ProductivityController@milestoneDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'con_projects/milestone/{id}/edit', [
        'as' => 'con_project.milestone.edit',
        'uses' => 'ProductivityController@milestoneEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'con_projects/milestone/{id}/show', [
        'as' => 'con_project.milestone.show',
        'uses' => 'ProductivityController@milestoneShow',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'con_projects/{id}/milestone', [
        'as' => 'con_project.milestone.store',
        'uses' => 'ProductivityController@milestoneStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'con_projects/{id}/milestone', [
        'as' => 'con.project.milestone',
        'uses' => 'ProductivityController@milestone',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/projectscon/{id}/task/{tid}/show', [
        'as' => 'projectscon.tasks.show',
        'uses' => 'ProjectTaskconController@show',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/projectscon/{id}/expense', [
        'as' => 'projectscon.expenses.index',
        'uses' => 'ExpenseControllercon@index',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('projectscon/time-tracker/{id}', 'ProductivityController@tracker')->name('projecttimecon.tracker')->middleware(['auth', 'XSS']);
Route::get('productivity', 'ProductivityController@index')->middleware(
    [
        'auth',
        'XSS',
    ]
)->name('productivity');

Route::get('productivity_show/{id}', 'ProductivityController@show')->middleware(
    [
        'auth',
        'XSS',
    ]
)->name('productivity_show');

Route::get('productivity_edit/{id}', 'ProductivityController@edit')->middleware(
    [
        'auth',
        'XSS',
    ]
)->name('productivity_edit');

Route::any('productivity_update/{id}', 'ProductivityController@update')->middleware(
    [
        'auth',
        'XSS',
    ]
)->name('productivity_update');

Route::any('productivity_destroy/{id}', 'ProductivityController@destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
)->name('productivity_destroy');

Route::post(
    'invite-cons_project-user-member', [
        'as' => 'invite-cons_project-user-member',
        'uses' => 'ProductivityController@inviteProjectUserMember',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'invite-cons_project-member/{id}', [
        'as' => 'invite-cons_project-member',
        'uses' => 'ProductivityController@inviteMemberView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('construction_project', 'ConstructionprojectController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('construction_project/{id}/show', 'ConstructionprojectController@show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('construction_name_presented', 'ConstructionprojectController@construction_name_presented')->middleware(
    [
        'auth',
        'XSS',
    ]
)->name('construction_name_presented');

Route::resource('project_holiday', 'Project_holiday_Controller')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('construction_asign', 'Construction_asign_Controller')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('construction_asign/{id}/show', 'Construction_asign_Controller@show')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Email Templates
Route::get('email_template_lang/{id}/{lang?}', 'EmailTemplateController@manageEmailLang')->name('manage.email.language')->middleware(['auth']);
Route::put('email_template_store/{pid}', 'EmailTemplateController@storeEmailLang')->name('store.email.language')->middleware(['auth']);
Route::put('email_template_status/{id}', 'EmailTemplateController@updateStatus')->name('status.email.language')->middleware(['auth']);
Route::resource('email_template', 'EmailTemplateController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Email Templates

// HRM

Route::resource('user', 'UserController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('employee/json', 'EmployeeController@json')->name('employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('branch/employee/json', 'EmployeeController@employeeJson')->name('branch.employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee-profile', 'EmployeeController@profile')->name('employee.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('show-employee-profile/{id}', 'EmployeeController@profileShow')->name('show.employee.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('lastlogin', 'EmployeeController@lastLogin')->name('lastlogin')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee_data/{id}', 'EmployeeNewPageController@employee_details')->name('employee.data')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('employeenew', 'EmployeeNewPageController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('employee', 'EmployeeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('employee/getdepartment', 'EmployeeController@getDepartment')->name('employee.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('department', 'DepartmentController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('designation', 'DesignationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('document', 'DocumentController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('branch', 'BranchController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('checkDuplicateRS_HRM', 'BranchController@checkDuplicateRS_HRM')->name('checkDuplicateRS_HRM')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Hrm EmployeeController

Route::get('employee/salary/{eid}', 'SetSalaryController@employeeBasicSalary')->name('employee.basic.salary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
//payslip

Route::resource('paysliptype', 'PayslipTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('allowance', 'AllowanceController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('commission', 'CommissionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('allowanceoption', 'AllowanceOptionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('loanoption', 'LoanOptionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('deductionoption', 'DeductionOptionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('loan', 'LoanController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('saturationdeduction', 'SaturationDeductionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('otherpayment', 'OtherPaymentController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('overtime', 'OvertimeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('employee/salary/{eid}', 'SetSalaryController@employeeBasicSalary')->name('employee.basic.salary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('employee/update/sallary/{id}', 'SetSalaryController@employeeUpdateSalary')->name('employee.salary.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('salary/employeeSalary', 'SetSalaryController@employeeSalary')->name('employeesalary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('setsalary', 'SetSalaryController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('allowances/create/{eid}', 'AllowanceController@allowanceCreate')->name('allowances.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('commissions/create/{eid}', 'CommissionController@commissionCreate')->name('commissions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('loans/create/{eid}', 'LoanController@loanCreate')->name('loans.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('saturationdeductions/create/{eid}', 'SaturationDeductionController@saturationdeductionCreate')->name('saturationdeductions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('otherpayments/create/{eid}', 'OtherPaymentController@otherpaymentCreate')->name('otherpayments.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('overtimes/create/{eid}', 'OvertimeController@overtimeCreate')->name('overtimes.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('payslip/paysalary/{id}/{date}', 'PaySlipController@paysalary')->name('payslip.paysalary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/bulk_pay_create/{date}', 'PaySlipController@bulk_pay_create')->name('payslip.bulk_pay_create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/bulkpayment/{date}', 'PaySlipController@bulkpayment')->name('payslip.bulkpayment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/search_json1', 'PaySlipController@search_json1')->name('payslip.search_json1')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/search_json', 'PaySlipController@search_json')->name('payslip.search_json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/employeepayslip', 'PaySlipController@employeepayslip')->name('payslip.employeepayslip')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/showemployee/{id}', 'PaySlipController@showemployee')->name('payslip.showemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/editemployee/{id}', 'PaySlipController@editemployee')->name('payslip.editemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/editemployee/{id}', 'PaySlipController@updateEmployee')->name('payslip.updateemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/pdf/{id}/{m}', 'PaySlipController@pdf')->name('payslip.pdf')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/payslipPdf/{id}', 'PaySlipController@payslipPdf')->name('payslip.payslipPdf')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/send/{id}/{m}', 'PaySlipController@send')->name('payslip.send')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/delete/{id}', 'PaySlipController@destroy')->name('payslip.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('payslip', 'PaySlipController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('company-policy', 'CompanyPolicyController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('indicator', 'IndicatorController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('appraisal', 'AppraisalController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('branch/employee/json', 'EmployeeController@employeeJson')->name('branch.employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('goaltype', 'GoalTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('goaltracking', 'GoalTrackingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('account-assets', 'AssetController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('event/getdepartment', 'EventController@getdepartment')->name('event.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('event/getemployee', 'EventController@getemployee')->name('event.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('event', 'EventController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('meeting/getdepartment', 'MeetingController@getdepartment')->name('meeting.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('meeting/getemployee', 'MeetingController@getemployee')->name('meeting.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('meeting', 'MeetingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('trainingtype', 'TrainingTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('trainer', 'TrainerController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('training/status', 'TrainingController@updateStatus')->name('training.status')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('training', 'TrainingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// HRM - HR Module

Route::resource('awardtype', 'AwardTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('award', 'AwardController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('resignation', 'ResignationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('travel', 'TravelController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('promotion', 'PromotionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('complaint', 'ComplaintController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('warning', 'WarningController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('termination', 'TerminationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('termination/{id}/description', 'TerminationController@description')->name('termination.description');

Route::resource('terminationtype', 'TerminationTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('announcement/getdepartment', 'AnnouncementController@getdepartment')->name('announcement.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('announcement/getemployee', 'AnnouncementController@getemployee')->name('announcement.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('announcement', 'AnnouncementController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('holiday', 'HolidayController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('holiday-calender', 'HolidayController@calender')->name('holiday.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);

//------------------------------------  Recurtment --------------------------------

Route::resource('job-category', 'JobCategoryController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('job-stage', 'JobStageController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-stage/order', 'JobStageController@order')->name('job.stage.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('job', 'JobController')->middleware(['auth', 'XSS']);
Route::get('career/{id}/{lang}', 'JobController@career')->name('career')->middleware(['XSS']);
Route::get('job/requirement/{code}/{lang}', 'JobController@jobRequirement')->name('job.requirement')->middleware(['XSS']);
Route::get('job/apply/{code}/{lang}', 'JobController@jobApply')->name('job.apply')->middleware(['XSS']);
Route::post('job/apply/data/{code}', 'JobController@jobApplyData')->name('job.apply.data')->middleware(['XSS']);

Route::get('candidates-job-applications', 'JobApplicationController@candidate')->name('job.application.candidate')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('job-application', 'JobApplicationController')->middleware(['auth', 'XSS']);

Route::post('job-application/order', 'JobApplicationController@order')->name('job.application.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/{id}/rating', 'JobApplicationController@rating')->name('job.application.rating')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-application/{id}/archive', 'JobApplicationController@archive')->name('job.application.archive')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('job-application/{id}/skill/store', 'JobApplicationController@addSkill')->name('job.application.skill.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/{id}/note/store', 'JobApplicationController@addNote')->name('job.application.note.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-application/{id}/note/destroy', 'JobApplicationController@destroyNote')->name('job.application.note.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/getByJob', 'JobApplicationController@getByJob')->name('get.job.application')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('job-onboard', 'JobApplicationController@jobOnBoard')->name('job.on.board')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('job-onboard/create/{id}', 'JobApplicationController@jobBoardCreate')->name('job.on.board.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/store/{id}', 'JobApplicationController@jobBoardStore')->name('job.on.board.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('job-onboard/edit/{id}', 'JobApplicationController@jobBoardEdit')->name('job.on.board.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/update/{id}', 'JobApplicationController@jobBoardUpdate')->name('job.on.board.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-onboard/delete/{id}', 'JobApplicationController@jobBoardDelete')->name('job.on.board.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('job-onboard/convert/{id}', 'JobApplicationController@jobBoardConvert')->name('job.on.board.convert')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/convert/{id}', 'JobApplicationController@jobBoardConvertData')->name('job.on.board.convert')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('job-application/stage/change', 'JobApplicationController@stageChange')->name('job.application.stage.change')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('custom-question', 'CustomQuestionController')->middleware(['auth', 'XSS']);
Route::resource('interview-schedule', 'InterviewScheduleController')->middleware(['auth', 'XSS']);
Route::get('interview-schedule/create/{id?}', 'InterviewScheduleController@create')->name('interview-schedule.create')->middleware(['auth', 'XSS']);
Route::get(
    'taskboard/{view?}', [
        'as' => 'taskBoard.view',
        'uses' => 'ProjectTaskController@taskBoard',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('task_autocomplete', 'ProjectTaskController@task_autocomplete')->name('task_autocomplete')
->middleware(['auth','XSS',]);

Route::get('task_autocomplete_main', 'ProjectTaskController@task_autocomplete_main')->name('task_autocomplete_main')
->middleware(['auth','XSS',]);

Route::get('user_autocomplete', 'ProjectTaskController@user_autocomplete')->name('user_autocomplete')
->middleware(['auth','XSS',]);

Route::get('get_all_task', 'ProjectTaskController@get_all_task')->name('get_all_task')->middleware(['auth','XSS',]);
Route::get('main_task_list', 'ProjectTaskController@main_task_list')->name('main_task_list')
->middleware(['auth','XSS',]);

Route::get('edit_assigned_to', 'ProjectTaskController@edit_assigned_to')->name('edit_assigned_to')
->middleware(['auth','XSS',]);

Route::any('update_assigned_to/{task_main_id}', 'ProjectTaskController@update_assigned_to')->name('update_assigned_to')
->middleware(['auth','XSS',]);

// task progress update for construction part

Route::any('con_taskupdate', 'ProjectController@taskupdate')->name('con_taskupdate');
// Route::any(
//     'con_taskupdate', [
//     'as' => 'con_taskupdate',
//     'uses' => 'ProjectController@taskupdate',
// ]
//     );
// end
Route::get(
    'taskboard-view', [
        'as' => 'project.taskboard.view',
        'uses' => 'ProjectTaskController@taskboardView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('task_particular', 'ProjectTaskController@task_particular')->name('task_particular')
->middleware(['auth', 'XSS']);

Route::any('add_particular_task/{task_id}/{get_date}', 'ProjectTaskController@add_particular_task')
->name('add_particular_task')->middleware(['auth', 'XSS']);

Route::any('edit_particular_task/{task_progress_id}/{task_id}',
'ProjectTaskController@edit_particular_task')->name('edit_particular_task')->middleware(['auth', 'XSS']);

Route::get('edit_task_progress', 'ProjectTaskController@edit_task_progress')
->name('edit_task_progress')->middleware(['auth', 'XSS']);

Route::get('task_file_download/{task_id}/{filename}', 'ProjectTaskController@task_file_download')
    ->name('task_file_download')->middleware(['auth', 'XSS']);

Route::get(
    'taskboard-edit', [
        'as' => 'project.taskboard.edit',
        'uses' => 'ProjectTaskController@taskboardEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'fetch_user_details', [
        'as' => 'project_report.fetch_user_details',
        'uses' => 'ProjectTaskController@taskboardEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('taskboard_get', 'projecttaskcontroller@taskboard_get')->name('project.taskboard_get')->middleware(['auth', 'XSS']);
Route::resource('document-upload', 'DucumentUploadController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('transfer', 'TransferController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('attendanceemployee/bulkattendance', 'AttendanceEmployeeController@bulkAttendance')->name('attendanceemployee.bulkattendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('attendanceemployee/bulkattendance', 'AttendanceEmployeeController@bulkAttendanceData')->name('attendanceemployee.bulkattendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('attendanceemployee/attendance', 'AttendanceEmployeeController@attendance')->name('attendanceemployee.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('attendanceemployee', 'AttendanceEmployeeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('leavetype', 'LeaveTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/leave', 'ReportController@leave')->name('report.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee/{id}/leave/{status}/{type}/{month}/{year}', 'ReportController@employeeLeave')->name('report.employee.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('leave/{id}/action', 'LeaveController@action')->name('leave.action')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('leave/changeaction', 'LeaveController@changeaction')->name('leave.changeaction')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('leave/jsoncount', 'LeaveController@jsoncount')->name('leave.jsoncount')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('leave', 'LeaveController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('reports-leave', 'ReportController@leave')->name('report.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee/{id}/leave/{status}/{type}/{month}/{year}', 'ReportController@employeeLeave')->name('report.employee.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('reports-payroll', 'ReportController@payroll')->name('report.payroll')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('reports-monthly-attendance', 'ReportController@monthlyAttendance')->name('report.monthly.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/attendance/{month}/{branch}/{department}', 'ReportController@exportCsv')->name('report.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// User Module
Route::get(
    'users/{view?}', [
        'as' => 'users',
        'uses' => 'UserController@index',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'users-view', [
        'as' => 'filter.user.view',
        'uses' => 'UserController@filterUserView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'checkuserexists', [
        'as' => 'user.exists',
        'uses' => 'UserController@checkUserExists',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'profile', [
        'as' => 'profile',
        'uses' => 'UserController@profile',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/profile', [
        'as' => 'update.profile',
        'uses' => 'UserController@updateProfile',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'user/info/{id}', [
        'as' => 'users.info',
        'uses' => 'UserController@userInfo',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'user/{id}/info/{type}', [
        'as' => 'user.info.popup',
        'uses' => 'UserController@getProjectTask',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    'users/{id}', [
        'as' => 'user.destroy',
        'uses' => 'UserController@destroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End User Module

// Search
Route::get(
    '/search', [
        'as' => 'search.json',
        'uses' => 'UserController@search',
    ]
);

// end

// Milestone Module
Route::get(
    'projects/{id}/milestone', [
        'as' => 'project.milestone',
        'uses' => 'ProjectController@milestone',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/{id}/milestone', [
        'as' => 'project.milestone.store',
        'uses' => 'ProjectController@milestoneStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects/milestone/{id}/edit', [
        'as' => 'project.milestone.edit',
        'uses' => 'ProjectController@milestoneEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/milestone/{id}', [
        'as' => 'project.milestone.update',
        'uses' => 'ProjectController@milestoneUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    'projects/milestone/{id}', [
        'as' => 'project.milestone.destroy',
        'uses' => 'ProjectController@milestoneDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects/milestone/{id}/show', [
        'as' => 'project.milestone.show',
        'uses' => 'ProjectController@milestoneShow',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Milestone

// Project Module
Route::get(
    'invite-project-member/{id}', [
        'as' => 'invite.project.member.view',
        'uses' => 'ProjectController@inviteMemberView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'invite-project-user-member', [
        'as' => 'invite.project.user.member',
        'uses' => 'ProjectController@inviteProjectUserMember',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'check_instance/{id}', [
        'as' => 'projects.check_instance',
        'uses' => 'ProjectController@check_instance',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'check_instance_dairy/{id}', [
        'as' => 'projects.check_instance_dairy',
        'uses' => 'ProjectController@check_instance_dairy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'instance_project/{instance_id}/{project_id}', [
        'as' => 'projects.instance_project',
        'uses' => 'RevisionController@instance_project',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::delete(
    'projects/{id}/users/{uid}', [
        'as' => 'projects.user.destroy',
        'uses' => 'ProjectController@destroyProjectUser',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'project/{view?}', [
        'as' => 'projects.list',
        'uses' => 'ProjectController@index',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects-view', [
    'filter.project.view',
        'uses' => 'ProjectController@filterProjectView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('projects/{id}/store-stages/{slug}', 'ProjectController@storeProjectTaskStages')->name('project.stages.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::patch(
    'remove-user-from-project/{project_id}/{user_id}', [
        'as' => 'remove.user.from.project',
        'uses' => 'ProjectController@removeUserFromProject',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects-users', [
        'as' => 'project.user',
        'uses' => 'ProjectController@loadUser',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'get_member', [
        'as' => 'projects.get_member',
        'uses' => 'ProjectController@get_member',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::any(
    'get_member', [
        'as' => 'projects.criticaltask_update',
        'uses' => 'ProjectController@criticaltask_update',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'projects/{id}/gantt/{duration?}', [
        'as' => 'projects.gantt',
        'uses' => 'ProjectController@gantt',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/{id}/gantt', [
        'as' => 'projects.gantt.post',
        'uses' => 'ProjectController@ganttPost',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// gantt
Route::resource('task', 'TaskController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

//microprogram gantt
Route::resource('microtask', 'TaskMicroController')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::resource('link', 'LinkController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('microlink', 'MicroLinkController')->middleware(
    [
        'auth',
        'XSS',
    ]
);



Route::get(
    'projects/{id}/gantt_data', [
        'as' => 'projects.gantt_data',
        'uses' => 'ProjectController@gantt_data',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::get(
    'projects/{id}/micro_gantt_data', [
        'as' => 'projects.micro_gantt_data',
        'uses' => 'MicroPorgramController@micro_gantt_data',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('freeze_status', 'ProjectController@freeze_status_change')->name('projects.freeze_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);


Route::post('micro_freeze_status', 'MicroPorgramController@micro_freeze_status')->name('projects.micro_freeze_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('get_gantt_task_count', 'ProjectController@get_gantt_task_count')->name('projects.get_gantt_task_count')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('get_micro_gantt_task_count', 'MicroPorgramController@get_micro_gantt_task_count')->name('projects.get_micro_gantt_task_count')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('get_freeze_status', 'ProjectController@get_freeze_status')->name('projects.get_freeze_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('get_micro_freeze_status', 'MicroPorgramController@get_micro_freeze_status')->name('projects.get_micro_freeze_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('projects', 'ProjectController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('projects_dairy/{project_id}', 'ProjectController@show_dairy')->name('show_dairy')->middleware(['auth',
'XSS',
'revalidate']);

Route::get('boq_file/{project_id}', 'ProjectController@boq_file')->name('boq_file')->middleware(['auth', 'XSS']);
Route::any('boq_code_verify', 'ProjectController@boq_code_verify')->name('boq_code_verify')->middleware(['auth', 'XSS']);
Route::any('boq_file_upload', 'ProjectController@boq_file_upload')->name('boq_file_upload')->middleware(['auth', 'XSS']);

// User Permission
Route::get(
    'projects/{id}/user/{uid}/permission', [
        'as' => 'projects.user.permission',
        'uses' => 'ProjectController@userPermission',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/{id}/user/{uid}/permission', [
        'as' => 'projects.user.permission.store',
        'uses' => 'ProjectController@userPermissionStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Project Module
// Task Module
Route::get(
    'stage/{id}/tasks', [
        'as' => 'stage.tasks',
        'uses' => 'ProjectTaskController@getStageTasks',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Project Task Module
Route::get(
    '/projects/{id}/task', [
        'as' => 'projects.tasks.index',
        'uses' => 'ProjectTaskController@index',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{pid}/task/{sid}', [
        'as' => 'projects.tasks.create',
        'uses' => 'ProjectTaskController@create',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{pid}/task/{sid}', [
        'as' => 'projects.tasks.store',
        'uses' => 'ProjectTaskController@store',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{id}/task/{tid}/show', [
        'as' => 'projects.tasks.show',
        'uses' => 'ProjectTaskController@show',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{id}/task/{tid}/edit', [
        'as' => 'projects.tasks.edit',
        'uses' => 'ProjectTaskController@edit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{id}/task/update/{tid}', [
        'as' => 'projects.tasks.update',
        'uses' => 'ProjectTaskController@update',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/projects/{id}/task/{tid}', [
        'as' => 'projects.tasks.destroy',
        'uses' => 'ProjectTaskController@destroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::patch(
    '/projects/{id}/task/order', [
        'as' => 'tasks.update.order',
        'uses' => 'ProjectTaskController@taskOrderUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::patch(
    'update-task-priority-color', [
        'as' => 'update.task.priority.color',
        'uses' => 'ProjectTaskController@updateTaskPriorityColor',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post(
    '/projects/{id}/comment/{tid}/file', [
        'as' => 'comment.store.file',
        'uses' => 'ProjectTaskController@commentStoreFile',
    ]
);
Route::delete(
    '/projects/{id}/comment/{tid}/file/{fid}', [
        'as' => 'comment.destroy.file',
        'uses' => 'ProjectTaskController@commentDestroyFile',
    ]
);
Route::post(
    '/projects/{id}/comment/{tid}', [
        'as' => 'task.comment.store',
        'uses' => 'ProjectTaskController@commentStore',
    ]
);
Route::delete(
    '/projects/{id}/comment/{tid}/{cid}', [
        'as' => 'comment.destroy',
        'uses' => 'ProjectTaskController@commentDestroy',
    ]
);
Route::post(
    '/projects/{id}/checklist/{tid}', [
        'as' => 'checklist.store',
        'uses' => 'ProjectTaskController@checklistStore',
    ]
);
Route::post(
    '/projects/{id}/checklist/update/{cid}', [
        'as' => 'checklist.update',
        'uses' => 'ProjectTaskController@checklistUpdate',
    ]
);
Route::delete(
    '/projects/{id}/checklist/{cid}', [
        'as' => 'checklist.destroy',
        'uses' => 'ProjectTaskController@checklistDestroy',
    ]
);
Route::post(
    '/projects/{id}/change/{tid}/fav', [
        'as' => 'change.fav',
        'uses' => 'ProjectTaskController@changeFav',
    ]
);
Route::post(
    '/projects/{id}/change/{tid}/complete', [
        'as' => 'change.complete',
        'uses' => 'ProjectTaskController@changeCom',
    ]
);
Route::post(
    '/projects/{id}/change/{tid}/progress', [
        'as' => 'change.progress',
        'uses' => 'ProjectTaskController@changeProg',
    ]
);
Route::get(
    '/projects/task/{id}/get', [
        'as' => 'projects.tasks.get',
        'uses' => 'ProjectTaskController@taskGet',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/calendar/{id}/show', [
        'as' => 'task.calendar.show',
        'uses' => 'ProjectTaskController@calendarShow',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/calendar/{id}/drag', [
        'as' => 'task.calendar.drag',
        'uses' => 'ProjectTaskController@calendarDrag',
    ]
);
Route::get(
    'calendar/{task}/{pid?}', [
        'as' => 'task.calendar',
        'uses' => 'ProjectTaskController@calendarView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'calendar_new/{task}/{pid?}', [
        'as' => 'task.newcalendar',
        'uses' => 'ProjectTaskController@new_calendar_view',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('project-task-stages', 'TaskStageController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/project-task-stages/order', [
        'as' => 'project-task-stages.order',
        'uses' => 'TaskStageController@order',
    ]
);
Route::post('project-task-new-stage', 'TaskStageController@storingValue')->name('new-task-stage')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Task Module

// Project Expense Module
Route::get(
    '/projects/{id}/expense', [
        'as' => 'projects.expenses.index',
        'uses' => 'ExpenseController@index',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{pid}/expense/create', [
        'as' => 'projects.expenses.create',
        'uses' => 'ExpenseController@create',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{pid}/expense/store', [
        'as' => 'projects.expenses.store',
        'uses' => 'ExpenseController@store',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{id}/expense/{eid}/edit', [
        'as' => 'projects.expenses.edit',
        'uses' => 'ExpenseController@edit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{id}/expense/{eid}', [
        'as' => 'projects.expenses.update',
        'uses' => 'ExpenseController@update',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/projects/{eid}/expense/', [
        'as' => 'projects.expenses.destroy',
        'uses' => 'ExpenseController@destroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/expense-list', [
        'as' => 'expense.list',
        'uses' => 'ExpenseController@expenseList',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::resource('contractType', 'ContractTypeController');
    }
);

// Project Timesheet
Route::get('append-timesheet-task-html', 'TimesheetController@appendTimesheetTaskHTML')
->name('append.timesheet.task.html')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-table-view', 'TimesheetController@filterTimesheetTableView')
->name('filter.timesheet.table.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-view', 'TimesheetController@filterTimesheetView')->name('filter.timesheet.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-list', 'TimesheetController@timesheetList')->name('timesheet.list')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-list-get', 'TimesheetController@timesheetListGet')->name('timesheet.list.get')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/project/{id}/timesheet', [
        'as' => 'timesheet.index',
        'uses' => 'TimesheetController@timesheetView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/project/{id}/activities', [
        'as' => 'project.activities',
        'uses' => 'ProjectController@projectActivities',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/project/{id}/teammembers', [
        'as' => 'project.teammembers',
        'uses' => 'ProjectController@projectTeamMembers',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/project/{id}/timesheet/create', [
        'as' => 'timesheet.create',
        'uses' => 'TimesheetController@timesheetCreate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/project/timesheet', [
        'as' => 'timesheet.store',
        'uses' => 'TimesheetController@timesheetStore',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/project/timesheet/{project_id}/edit/{timesheet_id}', [
        'as' => 'timesheet.edit',
        'uses' => 'TimesheetController@timesheetEdit',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::any(
    '/project/timesheet/update/{timesheet_id}', [
        'as' => 'timesheet.update',
        'uses' => 'TimesheetController@timesheetUpdate',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/project/timesheet/{timesheet_id}', [
        'as' => 'timesheet.destroy',
        'uses' => 'TimesheetController@timesheetDestroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
        ],
    ], function () {
        Route::resource('projectstages', 'ProjectstagesController');
        Route::post(
            '/projectstages/order', [
                'as' => 'projectstages.order',
                'uses' => 'ProjectstagesController@order',
            ]
        );
        Route::post('projects/bug/kanban/order', 'ProjectController@bugKanbanOrder')->name('bug.kanban.order');
        Route::get('projects/{id}/bug/kanban', 'ProjectController@bugKanban')->name('task.bug.kanban');
        Route::get('projects/{id}/bug', 'ProjectController@bug')->name('task.bug');
        Route::get('projects/{id}/bug/create', 'ProjectController@bugCreate')->name('task.bug.create');
        Route::post('projects/{id}/bug/store', 'ProjectController@bugStore')->name('task.bug.store');
        Route::get('projects/{id}/bug/{bid}/edit', 'ProjectController@bugEdit')->name('task.bug.edit');
        Route::post('projects/{id}/bug/{bid}/update', 'ProjectController@bugUpdate')->name('task.bug.update');
        Route::delete('projects/{id}/bug/{bid}/destroy', 'ProjectController@bugDestroy')->name('task.bug.destroy');
        Route::get('projects/{id}/bug/{bid}/show', 'ProjectController@bugShow')->name('task.bug.show');
        Route::post('projects/{id}/bug/{bid}/comment', 'ProjectController@bugCommentStore')->name('bug.comment.store');
        Route::post('projects/bug/{bid}/file', 'ProjectController@bugCommentStoreFile')->name('bug.comment.file.store');
        Route::delete('projects/bug/comment/{id}', 'ProjectController@bugCommentDestroy')->name('bug.comment.destroy');
        Route::delete('projects/bug/file/{id}', 'ProjectController@bugCommentDestroyFile')
        ->name('bug.comment.file.destroy');
        Route::resource('bugstatus', 'BugStatusController');
        Route::post(
            '/bugstatus/order', [
                'as' => 'bugstatus.order',
                'uses' => 'BugStatusController@order',
            ]
        );

        Route::get(
            'bugs-report/{view?}', [
                'as' => 'bugs.view',
                'uses' => 'ProjectTaskController@allBugList',
            ]
        )->middleware(
            [
                'auth',
                'XSS',
            ]
        );

    }
);
Route::post(
    '/todo/create', [
        'as' => 'todo.store',
        'uses' => 'UserController@todo_store',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/todo/{id}/update', [
        'as' => 'todo.update',
        'uses' => 'UserController@todo_update',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/todo/{id}', [
        'as' => 'todo.destroy',
        'uses' => 'UserController@todo_destroy',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/change/mode', [
        'as' => 'change.mode',
        'uses' => 'UserController@changeMode',
    ]
);

Route::get(
    'dashboard-view', [
        'as' => 'dashboard.view',
        'uses' => 'DashboardController@filterView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'dashboard', [
        'as' => 'client.dashboard.view',
        'uses' => 'DashboardController@clientView',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

// saas
Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('users/{id}/edit/{cid}', ['as' => 'use.edit', 'uses' => 'UserController@edit']);

Route::resource('consultants', 'ConsultantController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);


Route::get('consultants/edit/{id}/{color_code}', 'ConsultantController@edit')->name('consultants.edit.new')
    ->middleware(
        [
            'auth',
            'XSS',
            'revalidate',
        ]
    );

Route::get('drawing_list', 'DrawingsController@index')
->name('drawings.index')->middleware(['auth','XSS','revalidate',]);
Route::get('drawing_reference_add/{drawing_type}/{reference_number}',
'DrawingsController@addReference')->name('drawing.reference.add')->middleware(
    ['auth','XSS']
);
Route::post('add_drawings/{drawing_type_id}/{reference_number}',
'DrawingsController@addDrawings')->name('add.drawings')->middleware(['auth','XSS']);
Route::resource('drawings', 'DrawingsController')->middleware(['auth','XSS','revalidate',]);
Route::delete('drawing_del/{id}/{drawing_type}/{ref_number}/{user}',
'DrawingsController@drawingDestroy')->name('uploaded.drawing.destroy')->middleware(
    ['auth','XSS',]
);
Route::get('drawings_search', 'DrawingsController@index')->name('drawings.search')->middleware(['auth','XSS']);
Route::get('drawing_autocomplete', 'DrawingsController@drawing_autocomplete')
->name('drawing_autocomplete')->middleware(['auth','XSS',]);

Route::post('save_consultant', 'ConsultantController@normal_store')->name('save_consultant')
    ->middleware(
        [
            'auth',
            'XSS',
            'revalidate',
        ]
    );

Route::any('update_consultant/{id}', 'ConsultantController@update_consultant')->name('consultants.update_consultant')
    ->middleware(
        [
            'auth',
            'XSS',
            'revalidate',
        ]
    );

Route::any('consultants-reset-password/{id}', 'ConsultantController@userPassword')->name('consultants.reset');

Route::post('consultants-reset-password/{id}', 'ConsultantController@userPasswordReset')
    ->name('consultants.password.update');

    

    Route::any('consultant-seach_result', 'ConsultantController@seach_result')
    ->name('consultant.seach_result')->middleware(
        [
            'auth',
            'XSS',
            'revalidate',
        ]
    );

    Route::any('invite_consultant', 'ConsultantController@invite_consultant')
    ->name('consultant.invite_consultant')->middleware(
        [
            'auth',
            'XSS',
            'revalidate',
        ]
    );

    



Route::get('get_company_details/{id}', 'ConsultantController@get_company_details')
->name('consultant.get_company_details')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('invitation_status', 'ConsultantController@store_invitation_status')
->name('consultant.invitation_status')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

/* Sub Contractor Start */

Route::resource('subcontractor', 'SubContractorController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::post('save_subcontractor', 'SubContractorController@normal_store')
->name('save_subcontractor')
->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('subcontractorstore', 'SubContractorController@subContractorStore')
->name('subcontractorstore')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('update_subcontractor/{id}', 'SubContractorController@update_subContractor')
->name('subcontractor.update_subcontractor')
->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('get_company_details/{id}', 'SubContractorController@get_company_details')
->name('subcontractor.get_company_details')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::post('subcontractor-reset-password/{id}', 'SubContractorController@userPasswordReset')
    ->name('subcontractor.password.update');

Route::any('invite_sub_contractor', 'SubContractorController@invite_sub_contractor')
->name('subcontractor.invite_sub_contractor')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('subcontractor-scott-search', 'SubContractorController@scott_search')
->name('subcontractor.scott-search')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('subcontractor-scott-result', 'SubContractorController@scott_result')
->name('subcontractor.scott-result')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('subcontractor/edit/{id}/{color_code}', 'SubContractorController@edit')->name('subcontractor.edit.new')
->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('subcontractor-reset-password/{id}', 'SubContractorController@userPassword')->name('subcontractor.reset');

Route::any('subcontractor-seach_result', 'SubContractorController@seach_result')
->name('subcontractor.seach_result')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('subcontractor_invitation_status', 'SubContractorController@store_invitation_status')
->name('subcontractor.subcontractor_invitation_status')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::any('subcontractordashboard', 'DashboardController@subContractorDashboard')
->name('subcontractordashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);


Route::resource('plans', 'PlanController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('coupons', 'CouponController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
// Orders

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {

        Route::get('/orders', 'StripePaymentController@index')->name('order.index');
        Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');

    }
);
Route::get(
    '/apply-coupon', [
        'as' => 'apply.coupon',
        'uses' => 'CouponController@applyCoupon',
    ]
)->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//================================= Form Builder ====================================//

// Form Builder
Route::resource('form_builder', 'FormBuilderController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Form link base view
Route::get('/form/{code}', 'FormBuilderController@formView')->name('form.view')->middleware(['XSS']);
Route::post('/form_view_store', 'FormBuilderController@formViewStore')->name('form.view.store')->middleware(['XSS']);

// Form Field
Route::get('/form_builder/{id}/field', 'FormBuilderController@fieldCreate')->name('form.field.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/form_builder/{id}/field', 'FormBuilderController@fieldStore')->name('form.field.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/form_builder/{id}/field/{fid}/show', 'FormBuilderController@fieldShow')->name('form.field.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/form_builder/{id}/field/{fid}/edit', 'FormBuilderController@fieldEdit')->name('form.field.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/form_builder/{id}/field/{fid}', 'FormBuilderController@fieldUpdate')->name('form.field.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('/form_builder/{id}/field/{fid}', 'FormBuilderController@fieldDestroy')->name('form.field.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Form Response
Route::get('/form_response/{id}', 'FormBuilderController@viewResponse')->name('form.response')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/response/{id}', 'FormBuilderController@responseDetail')->name('response.detail')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Form Field Bind
Route::get('/form_field/{id}', 'FormBuilderController@formFieldBind')->name('form.field.bind')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/form_field_store/{id}', 'FormBuilderController@bindStore')->name('form.bind.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// end Form Builder

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::get('contract/{id}/description', 'ContractController@description')->name('contract.description');
        Route::get('contract/grid', 'ContractController@grid')->name('contract.grid');
        Route::get('contract/boq', 'ContractController@boq')->name('contract.boq');
        Route::get('contract/claimspaymentcertificate', 'ContractController@claimspaymentcertificate')->name('contract.claimspaymentcertificate');
        Route::get('contract/reports', 'ContractController@reports')->name('contract.reports');
        Route::get('contract/reconcilation', 'ContractController@reconcilation')->name('contract.reconcilation');
        Route::get('contract/eot', 'ContractController@eot')->name('contract.eot');

        Route::get('qaqc/concrete', 'QualityAssuranceController@concrete')->name('qaqc.concrete');

        Route::get('qaqc/concrete', 'QualityAssuranceController@concrete')->name('qaqc.concrete');
        Route::get('concrete_create', 'QualityAssuranceController@concrete_create')->name('qaqc.concrete_create')->middleware(
            [
                'auth',
                'XSS',
            ]
        );
        Route::get('concrete_edit', 'QualityAssuranceController@concrete_edit')->name('qaqc.concrete_edit')->middleware(
            [
                'auth',
                'XSS',
            ]
        );

        Route::get('concrete_update', 'QualityAssuranceController@concrete_update')->name('qaqc.concrete_update')->middleware(
            [
                'auth',
                'XSS',
            ]
        );

        Route::post('save_concrete_pouring', 'QualityAssuranceController@save_concrete_pouring')->name('concrete.save_concrete_pouring')->middleware(
            [
                'auth',
                'XSS',
            ]
        );

        Route::post('update_concrete_pouring', 'QualityAssuranceController@update_concrete_pouring')->name('concrete.update_concrete_pouring')->middleware(
            [
                'auth',
                'XSS',
            ]
        );

        Route::post('delete_concrete/{id}', 'QualityAssuranceController@delete_concrete')->name('concrete.delete_concrete')->middleware(
            [
                'auth',
                'XSS',
            ]
        );

        Route::get('qaqc/bricks', 'QualityAssuranceController@bricks')->name('qaqc.bricks');
        Route::get('qaqc/cement', 'QualityAssuranceController@cement')->name('qaqc.cement');
        Route::get('qaqc/sand', 'QualityAssuranceController@sand')->name('qaqc.sand');
        Route::get('qaqc/steel', 'QualityAssuranceController@steel')->name('qaqc.steel');

        Route::resource('contract', 'ContractController');
    }
);
Route::post(
    '/contract/{id}/file', [
        'as' => 'contract.file.upload',
        'uses' => 'ContractController@fileUpload',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('contract/pdf/{id}', 'ContractController@pdffromcontract')->name('contract.download.pdf');
Route::get('contract/{id}/get_contract', 'ContractController@printContract')->name('get.contract');
Route::post('/contract_status_edit/{id}', 'ContractController@contract_status_edit')->name('contract.status')->middleware(['auth', 'XSS']);
Route::post('contract/{id}/contract_description', 'ContractController@contract_descriptionStore')->name('contract.contract_description.store')->middleware(['auth']);
Route::get('/contract/{id}/file/{fid}', ['as' => 'contracts.file.download', 'uses' => 'ContractController@fileDownload'])->middleware(['auth', 'XSS']);
Route::delete('/contract/{id}/file/delete/{fid}', ['as' => 'contracts.file.delete', 'uses' => 'ContractController@fileDelete'])->middleware(['auth', 'XSS']);
Route::get('/contract/copy/{id}', ['as' => 'contract.copy', 'uses' => 'ContractController@copycontract'])->middleware(['auth', 'XSS']);
Route::post('/contract/copy/store', ['as' => 'contract.copy.store', 'uses' => 'ContractController@copycontractstore'])->middleware(['auth', 'XSS']);
Route::get('/contract/{id}/mail', ['as' => 'send.mail.contract', 'uses' => 'ContractController@sendmailContract']);
Route::get('/signature/{id}', 'ContractController@signature')->name('signature')->middleware(['auth', 'XSS']);
Route::post('/signaturestore', 'ContractController@signatureStore')->name('signaturestore')->middleware(['auth', 'XSS']);
Route::post('/contract/{id}/comment', ['as' => 'comment.store',    'uses' => 'ContractController@commentStore']);
Route::post('/contract/{id}/notes', ['as' => 'note_store.store', 'uses' => 'ContractController@noteStore'])->middleware(['auth']);
Route::delete('/contract/{id}/notes', ['as' => 'note_store.destroy', 'uses' => 'ContractController@noteDestroy'])->middleware(['auth']);
Route::delete('/contract/{id}/comment', ['as' => 'comment_store.destroy', 'uses' => 'ContractController@commentDestroy']);

Route::get('get-projects/{client_id}', 'ContractController@clientByProject')->name('project.by.user.id')->middleware(['auth', 'XSS']);
//client wise project show in modal
Route::any('/contract/clients/select/{bid}', 'ContractController@clientwiseproject')->name('contract.clients.select');
//copy contract
Route::get('/contract/copy/{id}', ['as' => 'contract.copy', 'uses' => 'ContractController@copycontract'])->middleware(['auth', 'XSS']);
Route::post('/contract/copy/store', ['as' => 'contract.copy.store', 'uses' => 'ContractController@copycontractstore'])->middleware(['auth', 'XSS']);

//================================= Custom Landing Page ====================================//

Route::get('/landingpage', 'LandingPageSectionController@index')->name('custom_landing_page.index')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/LandingPage/show/{id}', 'LandingPageSectionController@show');
Route::post('/LandingPage/setConetent', 'LandingPageSectionController@setConetent')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/get_landing_page_section/{name}', function ($name) {
        $plans = \DB::table('plans')->get();

        return view('custom_landing_page.'.$name, compact('plans'));
    }
);
Route::post('/LandingPage/removeSection/{id}', 'LandingPageSectionController@removeSection')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/setOrder', 'LandingPageSectionController@setOrder')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/copySection', 'LandingPageSectionController@copySection')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/customer/invoice/{id}/', 'InvoiceController@invoiceLink')->name('invoice.link.copy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('/vender/bill/{id}/', 'BillController@invoiceLink')->name('bill.link.copy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('/vendor/purchase/{id}/', 'PurchaseController@purchaseLink')->name('purchase.link.copy')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('/customer/proposal/{id}/', 'ProposalController@invoiceLink')->name('proposal.link.copy')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::post('plan-pay-with-paypal', 'PaypalController@planPayWithPaypal')->name('plan.pay.with.paypal')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('{id}/plan-get-payment-status', 'PaypalController@planGetPaymentStatus')->name('plan.get.payment.status')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//================================= Plan Payment Gateways  ====================================//

Route::post('/plan-pay-with-paystack', ['as' => 'plan.pay.with.paystack', 'uses' => 'PaystackPaymentController@planPayWithPaystack'])->middleware(['auth', 'XSS']);
Route::get('/plan/paystack/{pay_id}/{plan_id}', ['as' => 'plan.paystack', 'uses' => 'PaystackPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-flaterwave', ['as' => 'plan.pay.with.flaterwave', 'uses' => 'FlutterwavePaymentController@planPayWithFlutterwave'])->middleware(['auth', 'XSS']);
Route::get('/plan/flaterwave/{txref}/{plan_id}', ['as' => 'plan.flaterwave', 'uses' => 'FlutterwavePaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-razorpay', ['as' => 'plan.pay.with.razorpay', 'uses' => 'RazorpayPaymentController@planPayWithRazorpay'])->middleware(['auth', 'XSS']);
Route::get('/plan/razorpay/{txref}/{plan_id}', ['as' => 'plan.razorpay', 'uses' => 'RazorpayPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-paytm', ['as' => 'plan.pay.with.paytm', 'uses' => 'PaytmPaymentController@planPayWithPaytm'])->middleware(['auth', 'XSS']);
Route::post('/plan/paytm/{plan}', ['as' => 'plan.paytm', 'uses' => 'PaytmPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-mercado', ['as' => 'plan.pay.with.mercado', 'uses' => 'MercadoPaymentController@planPayWithMercado'])->middleware(['auth', 'XSS']);
Route::get('/plan/mercado/{plan}/{amount}', ['as' => 'plan.mercado', 'uses' => 'MercadoPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-mollie', ['as' => 'plan.pay.with.mollie', 'uses' => 'MolliePaymentController@planPayWithMollie'])->middleware(['auth', 'XSS']);
Route::get('/plan/mollie/{plan}', ['as' => 'plan.mollie', 'uses' => 'MolliePaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-skrill', ['as' => 'plan.pay.with.skrill', 'uses' => 'SkrillPaymentController@planPayWithSkrill'])->middleware(['auth', 'XSS']);
Route::get('/plan/skrill/{plan}', ['as' => 'plan.skrill', 'uses' => 'SkrillPaymentController@getPaymentStatus']);

Route::post('/plan-pay-with-coingate', ['as' => 'plan.pay.with.coingate', 'uses' => 'CoingatePaymentController@planPayWithCoingate'])->middleware(['auth', 'XSS']);
Route::get('/plan/coingate/{plan}', ['as' => 'plan.coingate', 'uses' => 'CoingatePaymentController@getPaymentStatus']);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::get('order', 'StripePaymentController@index')->name('order.index');
        Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
    }
);

Route::post('plan-pay-with-paypal', 'PaypalController@planPayWithPaypal')->name('plan.pay.with.paypal')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('{id}/plan-get-payment-status', 'PaypalController@planGetPaymentStatus')->name('plan.get.payment.status')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//================================= Invoice Payment Gateways  ====================================//

Route::post('customer/{id}/payment', 'StripePaymentController@addpayment')->name('customer.payment');

Route::post('{id}/pay-with-paypal', 'PaypalController@customerPayWithPaypal')->name('customer.pay.with.paypal');
Route::get('{id}/get-payment-status', 'PaypalController@customerGetPaymentStatus')->name('customer.get.payment.status')->middleware(
    [
        'XSS',

    ]
);

Route::post('/customer-pay-with-paystack', ['as' => 'customer.pay.with.paystack', 'uses' => 'PaystackPaymentController@customerPayWithPaystack'])->middleware(['XSS']);
Route::get('/customer/paystack/{pay_id}/{invoice_id}', ['as' => 'customer.paystack', 'uses' => 'PaystackPaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-flaterwave', ['as' => 'customer.pay.with.flaterwave', 'uses' => 'FlutterwavePaymentController@customerPayWithFlutterwave'])->middleware(['XSS']);
Route::get('/customer/flaterwave/{txref}/{invoice_id}', ['as' => 'customer.flaterwave', 'uses' => 'FlutterwavePaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-razorpay', ['as' => 'customer.pay.with.razorpay', 'uses' => 'RazorpayPaymentController@customerPayWithRazorpay'])->middleware(['XSS']);
Route::get('/customer/razorpay/{txref}/{invoice_id}', ['as' => 'customer.razorpay', 'uses' => 'RazorpayPaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-paytm', ['as' => 'customer.pay.with.paytm', 'uses' => 'PaytmPaymentController@customerPayWithPaytm'])->middleware(['XSS']);
Route::post('/customer/paytm/{invoice}/{amount}', ['as' => 'customer.paytm', 'uses' => 'PaytmPaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-mercado', ['as' => 'customer.pay.with.mercado', 'uses' => 'MercadoPaymentController@customerPayWithMercado'])->middleware(['XSS']);
Route::get('/customer/mercado/{invoice}', ['as' => 'customer.mercado', 'uses' => 'MercadoPaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-mollie', ['as' => 'customer.pay.with.mollie', 'uses' => 'MolliePaymentController@customerPayWithMollie'])->middleware(['XSS']);
Route::get('/customer/mollie/{invoice}/{amount}', ['as' => 'customer.mollie', 'uses' => 'MolliePaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-skrill', ['as' => 'customer.pay.with.skrill', 'uses' => 'SkrillPaymentController@customerPayWithSkrill'])->middleware(['XSS']);
Route::get('/customer/skrill/{invoice}/{amount}', ['as' => 'customer.skrill', 'uses' => 'SkrillPaymentController@getInvoicePaymentStatus']);

Route::post('/customer-pay-with-coingate', ['as' => 'customer.pay.with.coingate', 'uses' => 'CoingatePaymentController@customerPayWithCoingate'])->middleware(['XSS']);
Route::get('/customer/coingate/{invoice}/{amount}', ['as' => 'customer.coingate', 'uses' => 'CoingatePaymentController@getInvoicePaymentStatus']);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::get('support/{id}/reply', 'SupportController@reply')->name('support.reply');
        Route::post('support/{id}/reply', 'SupportController@replyAnswer')->name('support.reply.answer');
        Route::get('support/grid', 'SupportController@grid')->name('support.grid');
        Route::resource('support', 'SupportController');
    }
);

Route::resource('competencies', 'CompetenciesController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::resource('performanceType', 'PerformanceTypeController');
    }
);

// Plan Request Module
Route::get('plan_request', 'PlanRequestController@index')->name('plan_request.index')->middleware(['auth', 'XSS']);
Route::get('request_frequency/{id}', 'PlanRequestController@requestView')->name('request.view')->middleware(['auth', 'XSS']);
Route::get('request_send/{id}', 'PlanRequestController@userRequest')->name('send.request')->middleware(['auth', 'XSS']);
Route::get('request_response/{id}/{response}', 'PlanRequestController@acceptRequest')->name('response.request')->middleware(['auth', 'XSS']);
Route::get('request_cancel/{id}', 'PlanRequestController@cancelRequest')->name('request.cancel')->middleware(['auth', 'XSS']);

//QR Code Module

// company type module
Route::resource('company_type', 'CompanytypeController')->middleware(['auth', 'XSS']);

//--------------------------------------------------------Import/Export Data Route-----------------------------------------------------------------

Route::get('export/productservice', 'ProductServiceController@export')->name('productservice.export');
Route::get('import/productservice/file', 'ProductServiceController@importFile')->name('productservice.file.import');
Route::post('import/productservice', 'ProductServiceController@import')->name('productservice.import');

Route::get('export/customer', 'CustomerController@export')->name('customer.export');
Route::get('import/customer/file', 'CustomerController@importFile')->name('customer.file.import');
Route::post('import/customer', 'CustomerController@import')->name('customer.import');

Route::get('export/vender', 'VenderController@export')->name('vender.export');
Route::get('import/vender/file', 'VenderController@importFile')->name('vender.file.import');
Route::post('import/vender', 'VenderController@import')->name('vender.import');

Route::get('export/invoice', 'InvoiceController@export')->name('invoice.export');

Route::get('export/proposal', 'ProposalController@export')->name('proposal.export');

Route::get('export/bill', 'BillController@export')->name('bill.export');

//=================================== Time-Tracker======================================================================
Route::post('stop-tracker', 'DashboardController@stopTracker')->name('stop.tracker')->middleware(['auth', 'XSS']);
Route::get('time-tracker', 'TimeTrackerController@index')->name('time.tracker')->middleware(['auth', 'XSS']);
Route::delete('tracker/{tid}/destroy', 'TimeTrackerController@Destroy')->name('tracker.destroy');
Route::post('tracker/image-view', ['as' => 'tracker.image.view', 'uses' => 'TimeTrackerController@getTrackerImages']);
Route::delete('tracker/image-remove', ['as' => 'tracker.image.remove', 'uses' => 'TimeTrackerController@removeTrackerImages']);
Route::get('projects/time-tracker/{id}', 'ProjectController@tracker')->name('projecttime.tracker')->middleware(['auth', 'XSS']);

//=================================== Zoom Meeting ======================================================================
Route::resource('zoom-meeting', 'ZoomMeetingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::any('/zoom-meeting/projects/select/{bid}', 'ZoomMeetingController@projectwiseuser')->name('zoom-meeting.projects.select');
Route::get('zoom-meeting-calender', 'ZoomMeetingController@calender')->name('zoom-meeting.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// ------------------------------------- PaymentWall ------------------------------

Route::post('/paymentwalls', ['as' => 'plan.paymentwallpayment', 'uses' => 'PaymentWallPaymentController@paymentwall'])->middleware(['XSS']);
Route::post('/plan-pay-with-paymentwall/{plan}', ['as' => 'plan.pay.with.paymentwall', 'uses' => 'PaymentWallPaymentController@planPayWithPaymentWall'])->middleware(['XSS']);
Route::get('/plan/{flag}', ['as' => 'error.plan.show', 'uses' => 'PaymentWallPaymentController@planeerror']);

Route::post('/paymentwall', ['as' => 'invoice.paymentwallpayment', 'uses' => 'PaymentWallPaymentController@invoicepaymentwall'])->middleware(['XSS']);
Route::post('/invoice-pay-with-paymentwall/{plan}', ['as' => 'invoice.pay.with.paymentwall', 'uses' => 'PaymentWallPaymentController@invoicePayWithPaymentwall'])->middleware(['XSS']);
Route::get('/invoices/{flag}/{invoice}', ['as' => 'error.invoice.show', 'uses' => 'PaymentWallPaymentController@invoiceerror']);

// ------------------------------------- POS System ------------------------------

Route::resource('warehouse', 'WarehouseController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::group(
    [
        'middleware' => [
            'auth',
            'XSS',
            'revalidate',
        ],
    ], function () {
        Route::get('purchase/items', 'PurchaseController@items')->name('purchase.items');

        Route::resource('purchase', 'PurchaseController');
        //    Route::get('/bill/{id}/', 'PurchaseController@purchaseLink')->name('purchase.link.copy');
        Route::get('purchase/{id}/payment', 'PurchaseController@payment')->name('purchase.payment');
        Route::post('purchase/{id}/payment', 'PurchaseController@createPayment')->name('purchase.payment');
        Route::post('purchase/{id}/payment/{pid}/destroy', 'PurchaseController@paymentDestroy')->name('purchase.payment.destroy');

        Route::post('purchase/product/destroy', 'PurchaseController@productDestroy')->name('purchase.product.destroy');
        Route::post('purchase/vender', 'PurchaseController@vender')->name('purchase.vender');
        Route::post('purchase/product', 'PurchaseController@product')->name('purchase.product');
        Route::get('purchase/create/{cid}', 'PurchaseController@create')->name('purchase.create');
        Route::get('purchase/{id}/sent', 'PurchaseController@sent')->name('purchase.sent');
        Route::get('purchase/{id}/resent', 'PurchaseController@resent')->name('purchase.resent');

    }

);
Route::get('pos-print-setting', 'SystemController@posPrintIndex')->name('pos.print.setting')->middleware(['auth', 'XSS']);

Route::get(
    'purchase/preview/{template}/{color}', [
        'as' => 'purchase.preview',
        'uses' => 'PurchaseController@previewPurchase',
    ])->middleware(['auth', 'XSS']);

Route::post(
    '/purchase/template/setting', [
        'as' => 'purchase.template.setting',
        'uses' => 'PurchaseController@savePurchaseTemplateSettings',
    ]
);
Route::get('purchase/pdf/{id}', 'PurchaseController@purchase')->name('purchase.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);

Route::get('pos/data/store', 'PosController@store')->name('pos.data.store')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::resource('pos', 'PosController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('product-categories', 'ProductServiceCategoryController@getProductCategories')->name('product.categories')->middleware(['auth', 'XSS']);
Route::get('add-to-cart/{id}/{session}', 'ProductServiceController@addToCart')->middleware(['auth', 'XSS']);
Route::patch('update-cart', 'ProductServiceController@updateCart')->middleware(['auth', 'XSS']);
Route::delete('remove-from-cart', 'ProductServiceController@removeFromCart')->middleware(['auth', 'XSS']);

Route::get('name-search-products', 'ProductServiceController@searchProductsByName')->name('name.search.products')->middleware(['auth', 'XSS']);
Route::get('search-products', 'ProductServiceController@searchProducts')->name('search.products')->middleware(['auth', 'XSS']);
Route::get('report/pos', 'PosController@report')->name('pos.report')->middleware(['auth', 'XSS']);

//Storage Setting
Route::post('storage-settings', ['as' => 'storage.setting.store', 'uses' => 'SystemController@storageSettingStore'])->middleware(['auth', 'XSS']);

//appricalStar
Route::post('/appraisals', 'AppraisalController@empByStar')->name('empByStar')->middleware(['auth', 'XSS']);
Route::post('/appraisals1', 'AppraisalController@empByStar1')->name('empByStar1')->middleware(['auth', 'XSS']);
Route::post('/getemployee', 'AppraisalController@getemployee')->name('getemployee');

//offer Letter
Route::post('setting/offerlatter/{lang?}', 'SystemController@offerletterupdate')->name('offerlatter.update');
Route::get('setting/offerlatter', 'SystemController@companyIndex')->name('get.offerlatter.language');
Route::get('job-onboard/pdf/{id}', 'JobApplicationController@offerletterPdf')->name('offerlatter.download.pdf');
Route::get('job-onboard/doc/{id}', 'JobApplicationController@offerletterDoc')->name('offerlatter.download.doc');

//joining Letter
Route::post('setting/joiningletter/{lang?}', 'SystemController@joiningletterupdate')->name('joiningletter.update');
Route::get('setting/joiningletter/', 'SystemController@companyIndex')->name('get.joiningletter.language');
Route::get('employee/pdf/{id}', 'EmployeeController@joiningletterPdf')->name('joiningletter.download.pdf');
Route::get('employee/doc/{id}', 'EmployeeController@joiningletterDoc')->name('joininglatter.download.doc');

//Experience Certificate
Route::post('setting/exp/{lang?}', 'SystemController@experienceCertificateupdate')->name('experiencecertificate.update');
Route::get('setting/exp', 'SystemController@companyIndex')->name('get.experiencecertificate.language');
Route::get('employee/exppdf/{id}', 'EmployeeController@ExpCertificatePdf')->name('exp.download.pdf');
Route::get('employee/expdoc/{id}', 'EmployeeController@ExpCertificateDoc')->name('exp.download.doc');

//NOC
Route::post('setting/noc/{lang?}', 'SystemController@NOCupdate')->name('noc.update');
Route::get('setting/noc', 'SystemController@companyIndex')->name('get.noc.language');
Route::get('employee/nocpdf/{id}', 'EmployeeController@NocPdf')->name('noc.download.pdf');
Route::get('employee/nocdoc/{id}', 'EmployeeController@NocDoc')->name('noc.download.doc');

////**===================================== Project Reports =======================================================////

Route::resource('/project_report', 'ProjectReportController')->middleware(['auth', 'XSS']);
Route::post('/project_report_data', 'ProjectReportController@ajax_data')->name('projects.ajax')->middleware(['auth', 'XSS']);

Route::post('/project_report/tasks/{id}', ['as' => 'tasks.report.ajaxdata', 'uses' => 'ProjectReportController@ajax_tasks_report'])->middleware(['auth', 'XSS']);
Route::get('export/task_report/{id}', 'ProjectReportController@export')->name('project_report.export');

Route::post('api/fetch_user_details', 'ProjectReportController@fetch_user_details')->name('project_report.fetch_user_details2')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('api/fetch_task_details', 'ProjectReportController@fetch_task_details')->name('project_report.fetch_task_details')->middleware(
    [
        'auth',
        'XSS',
    ]
);

/* Micro Program Start */
Route::any('microprogram', 'MicroPorgramController@microprogram')->name('microprogram')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('micro_taskboard', 'MicroPorgramController@micro_taskboard')->name('micro_taskboard')
->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('micro_get_all_task', 'MicroPorgramController@micro_get_all_task')->name('micro_get_all_task')->middleware(['auth','XSS',]);
Route::get('micro_main_task_list', 'MicroPorgramController@micro_main_task_list')->name('micro_main_task_list')
->middleware(['auth','XSS',]);

Route::get('micro_task_autocomplete', 'MicroPorgramController@micro_task_autocomplete')->name('micro_task_autocomplete')
->middleware(['auth','XSS',]);

Route::get('micro_task_autocomplete_main', 'MicroPorgramController@micro_task_autocomplete_main')->name('micro_task_autocomplete_main')
->middleware(['auth','XSS',]);

Route::any('micro_task_particular', 'MicroPorgramController@micro_task_particular')->name('micro_task_particular')
->middleware(['auth', 'XSS']);

Route::any('micro_add_particular_task/{task_id}/{get_date}', 'MicroPorgramController@micro_add_particular_task')
->name('micro_add_particular_task')->middleware(['auth', 'XSS']);

Route::any('micro_edit_particular_task/{task_progress_id}/{task_id}','MicroPorgramController@micro_edit_particular_task')
->name('micro_edit_particular_task')->middleware(['auth', 'XSS']);

Route::any('micro_con_taskupdate', 'MicroPorgramController@micro_con_taskupdate')->name('micro_con_taskupdate')
->middleware(['auth', 'XSS']);

Route::any('schedule_complete', 'MicroPorgramController@schedule_complete')->name('schedule_complete')
->middleware(['auth', 'XSS']);

Route::get('micro_task_file_download/{task_id}/{filename}', 'MicroPorgramController@micro_task_file_download')
    ->name('micro_task_file_download')->middleware(['auth', 'XSS']);

Route::any('microprogram_create', 'MicroPorgramController@microprogram_create')->name('microprogram_create')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('change_schedule_status', 'MicroPorgramController@change_schedule_status')->name('change_schedule_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('schedule_store', 'MicroPorgramController@schedule_store')->name('schedule_store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('schedule_task_show/{id}', 'MicroPorgramController@schedule_task_show')->name('schedule_task_show')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('mainschedule_store', 'MicroPorgramController@mainschedule_store')->name('mainschedule_store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'microprogram/{id}/gantt/{duration?}', [
        'as' => 'microprogram.gantt',
        'uses' => 'MicroPorgramController@gantt',
    ]
)->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::any('view_task_report/{id}', 'ProjectTaskController@task_report')->name('project_report.view_task_report');
Route::any('download_excel_report', 'ProjectReportController@download_excel_report')->name('download_excel_report');

Route::any('view_task_revision', 'ProjectTaskController@revsion_task_list')->name('project_report.revsion_task_list');
Route::any('report_task_autocomplete', 'ProjectTaskController@report_task_autocomplete')
->name('report_task_autocomplete');
Route::any('show_task_report', 'ProjectTaskController@show_task_report')->name('show_task_report');
Route::any('excel_report_onsearch', 'ProjectReportController@excel_report_onsearch')->name('excel_report_onsearch');
Route::any('pdf_report_onsearch', 'ProjectReportController@pdf_report_onsearch')->name('pdf_report_onsearch');




Route::any('send_report_con', 'ProjectReportController@send_report_con')->name('send_report_con');
Route::any('download_report', 'ProjectReportController@download_report')->name('download_report');

Route::any('revision', 'RevisionController@revision')->name('revision');
Route::any('revision_store', 'RevisionController@revision_store')->name('revision_store');

/*New Diary route*/
Route::any('new_vo_change', 'DiaryController@new_vo_change')->name('new_vo_change');
Route::any('new_drawing', 'DiaryController@new_drawing')->name('new_drawing');
Route::any('new_rfi', 'DiaryController@new_rfi')->name('new_rfi');

Route::any('{any}', function () {
    return view('error');
})->where('any', '.*');
