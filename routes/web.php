<?php

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

Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('/dashboard');
    } else {
        return redirect('/login');
    }
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/privacy-policy', 'HomeController@privacy_policy');
Route::get('/notification-all', 'AppImageController@all_notification');

Route::group(['middleware' => ['HasPermission']], function () {
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardController@index');
    Route::resource('app-image', 'AppImageController');

    Route::post('app-image/recommendation/{id}', 'AppImageController@recommendation');

    Route::get('publish-app-image/{id}', 'AppImageController@image_approve_second_layer');
    //Route::group(['middleware' => ['HasPermission']], function () {
    Route::group(['namespace' => 'Admin'], function () {

        //Route::resource('package', 'PackageController');
        Route::get('package', 'PackageController@index')->name('package');
        Route::get('/package/create', 'PackageController@create')->name('package.create');
        Route::post('/package', 'PackageController@store')->name('package.store');
        Route::get('/package/{id}', 'PackageController@show')->name('package.show');
        Route::get('/package/{id}/edit', 'PackageController@edit')->name('package.edit');
        Route::put('/package/{id}', 'PackageController@update')->name('package.update');
        Route::delete('/package/{id}', 'PackageController@destroy')->name('package.destroy');

        Route::get('package_settings', 'PackageController@package_settings');
        /* package edit route progress */
        Route::get('package_working_progrss/{id}/package_progrss', 'PackageController@package_progrss');
        /* package update route progress */
        Route::patch('package_working_progrss/{id}', 'PackageController@package_progrss_store');
        Route::get('search_package', 'PackageController@package_search');
    });

    Route::group(['namespace' => 'Training'], function () {
        Route::resource('training-category', 'TrainingCategoryController');

    });

    Route::group(['namespace' => 'Admin'], function () {
        Route::resource('aprroveauthotities', 'ApproveAuthorityController');
        Route::resource('type', 'TypeController');

    });

    Route::group(['namespace' => 'Admin'], function () {
        Route::resource('dashboard_dynamic_image', 'DashboardDynamicImageController');
        Route::resource('aprroveauthotities', 'ApproveAuthorityController');
        Route::resource('type', 'TypeController');
        Route::resource('file-manager-category', 'FileManagerCategoryController');
        Route::resource('package-category-order', 'PackageWiseCategoryController');

        //approving_authorities
        Route::resource('aprroveauthotities', 'ApproveAuthorityController');
        //type
        Route::resource('type', 'TypeController');
        //unit
        Route::resource('unit', 'UnitController');
        //designation
        Route::resource('designation', 'DesignationController');
        //role
        Route::resource('role', 'RolesController');
        //user
        Route::resource('user', 'UserController');
        //activityCategory
        Route::resource('activitycategory', 'ActivityCategoryController');
        //activityIndicator change by app activity
        Route::resource('activityindicator', 'ActivityIndicatorController');
        //activityindicatordata
        Route::resource('activity-indicator-data', 'ActivityIndicatordataControlller');
        //contactors
        Route::resource('contactor', 'ContactsController');
        //department
        Route::resource('department', 'DepartmentsController');
        //ssource of fund
        Route::resource('source_of_fund', 'SourceOfFundController');
        //procurement method
        Route::resource('procurement_method', 'ProcurementMethodController');
        /*create indicator category */
        Route::resource('indicator_category', 'IndicatorCategoryController');
        /*create indicator */
        Route::resource('indicator', 'IndicatorController');
        Route::resource('indicator_data', 'IndicatorDataController');
        Route::resource('camp', 'CampController');

        Route::get('user-permision', 'PermisionRoleController@index');
        Route::patch('user-permision/{id}', 'PermisionRoleController@update_permision');
        //change password
        Route::get('change-password', 'ChangePasswordController@index');
        Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

        // ARE Report
        Route::resource('are-reports', "AREReportController");

        Route::get('are-reports-download', "AREReportController@exportAREDataAcquisitionReport");
        /*
        Route::post('dynamic-report-generate', "AREReportController@exportDynamicReport")->name('dynamic-reports.generate');
        Route::post('dynamic-report-download', "AREReportController@exportDynamicReportDownload")->name('dynamic-reports.download');
        */
    });

    Route::group(['namespace' => 'Training'], function () {
        Route::resource('training', 'TrainingController');
        Route::get('training-module', 'TrainingReportController@training_module');
        Route::get('pdfview', array('as' => 'pdfview', 'uses' => 'TrainingReportController@pdfview'));
        Route::resource('training-activity', 'TrainingActivityController');

    });

//report section
    Route::get('/dashboard/package-wise-report', 'PackagewiseReportController@package_home')->name('report.home');
    Route::get('/dashboard/report', 'PackagewiseReportController@home');
    Route::get('/dashboard/upload/all_report', 'PackagewiseReportController@show_all_upload_report');
    Route::get('/dashboard/package-report', 'PackagewiseReportController@index');
    Route::get('/dashboard/package-wise-report/create', 'PackagewiseReportController@create');
    Route::post('/dashboard/package-wise-report/store', 'PackagewiseReportController@store')->name('package_Report.store');
    Route::get('/dashboard/package-wise-report/manage', 'PackagewiseReportController@manage');
    Route::delete('/dashboard/package-wise-report/{id}', 'PackagewiseReportController@delete')->name('package_Report.delete');
    Route::get('/dashboard/package-wise-report-edit/{id}', 'PackagewiseReportController@edit')->name('package_Report.edit');
    Route::put('/dashboard/package-wise-report/{id}', 'PackagewiseReportController@update')->name('package_Report.update');
    Route::get('/dashboard/package-wise-report/{id}', 'PackagewiseReportController@show')->name('package_Report.show');
    Route::get('dashboard/report-pagination', 'PackagewiseReportController@pagination');
    Route::get('dashboard/report-download/{fileManagerId}', 'FileManagerController@downloadAttachment')->name('package_Report.file_manager.download');
    Route::get('dashboard/report-view/{fileManagerId}', 'FileManagerController@viewAttachment')->name('package_Report.file_manager.view');
// Route::get('dashboard/report/package-wise-pagination','PackagewiseReportController@package_wise_pagination');



//drawing and design
    Route::get('/dashboard/drawing-design-report', 'DrawingDesignController@index')->name('dd.dashboard');
    Route::get('/dashboard/drawing-design-report/create', 'DrawingDesignController@create');
    Route::post('/dashboard/drawing-design-report/store', 'DrawingDesignController@store')->name('dd.store');
    Route::get('/dashboard/drawing-design-report/manage', 'DrawingDesignController@manage');
    Route::delete('/dashboard/drawing-design-report/{id}', 'DrawingDesignController@delete')->name('dd.delete');
    Route::get('/dashboard/drawing-design-report-edit/{id}', 'DrawingDesignController@edit')->name('dd.edit');
    Route::put('/dashboard/drawing-design-report/{id}', 'DrawingDesignController@update')->name('dd.update');
    Route::get('/dashboard/drawing-design-report-home', 'DrawingDesignController@home')->name('dd.home');

//emcrp project information dphe part
    Route::get('/dashboard/emcrp-project-information-dphe', 'ProjectInformationController@index')->name('project_info.index');
    Route::get('/dashboard/emcrp-project-information-dphe/sub-category/{id}', 'ProjectInformationController@subCategory')->name('project_info.subCategory');
    Route::get('/dashboard/emcrp-project-information-dphe/create/{id}', 'ProjectInformationController@create');
    Route::post('/dashboard/emcrp-project-information-dphe/store', 'ProjectInformationController@store')->name('project_info.store');
    Route::get('/dashboard/emcrp-project-information-dphe/manage/{id}', 'ProjectInformationController@manage');
    Route::delete('/dashboard/emcrp-project-information-dphe/{id}', 'ProjectInformationController@delete')->name('project_info.delete');
    Route::get('/dashboard/emcrp-project-information-dphe-edit/{id}', 'ProjectInformationController@edit')->name('project_info.edit');
    Route::put('/dashboard/emcrp-project-information-dphe/{id}', 'ProjectInformationController@update')->name('project_info.update');

//gis
    Route::get('/dashboard/gis', 'GisController@index')->name('gis.index');
    Route::get('/dashboard/gis/create', 'GisController@create');
    Route::post('/dashboard/gis/store', 'GisController@store')->name('gis.store');
    Route::get('/dashboard/gis/manage', 'GisController@manage');
    Route::delete('/dashboard/gis/{id}', 'GisController@delete')->name('gis.delete');
    Route::get('/dashboard/gis-edit/{id}', 'GisController@edit')->name('gis.edit');
    Route::put('/dashboard/gis/{id}', 'GisController@update')->name('gis.update');

    /* package dahboard */
    Route::get('package_dashboard/{id}', 'PackageDashboardController@index');

    Route::get('package_progress', 'PaymentController@progress_details');

//report
    Route::get('report', 'ReportController@index');

//finance
    Route::get('/finance-dashboard', 'Finance\FinanceController@dashboard')->name('dashboard');
    Route::get('/financial-report-upload', 'Finance\FinanceController@report_create');
    Route::post('/financial-report-store', 'Finance\FinanceController@report_store')->name('report.store');
    Route::get('financial-file-manager', 'Finance\FinanceController@show_file')->name('filemanager');
    Route::get('manage-financial-report', 'Finance\FinanceController@manage_Report')->name('manage');
    Route::delete('/finance-report-delete/{id}', 'Finance\FinanceController@delete_Report')->name('report.delete');
    Route::get('/finance-report-edit/{id}', 'Finance\FinanceController@edit_Report')->name('report.edit');
    Route::put('/finance-report-update/{id}', 'Finance\FinanceController@update_Report')->name('report.update');

    Route::resource('financial-target', 'Admin\FinancialTargetController');

    Route::resource('payment', 'PaymentController');
    Route::get('report/monthly-report-planning', 'FinancialController@pmis_report');
    Route::get('report/procurement-monthly-report', 'ProcurementController@report');

//procurement dashboard
    Route::get('procurement-dashboard', 'ProcurementController@index');
    Route::get('procurement-dashboard-pagination', 'ProcurementController@pagination');

//gallery
    Route::get('gallery', 'DashboardController@gallery');

//settings
    Route::resource('settings', 'SettingsController');

//financial-item
    Route::get('financialitem/report', 'Finance\FinancialItemController@report')->name('report');
    Route::resource('financialitem', 'Finance\FinancialItemController');

//adp report
    Route::get('adp-report-template', 'ADP\ADPReportController@adp_report_template');

//Approvla data
    Route::get('approval', 'ApprovalController@index');
    Route::get('report-file-approve', 'ApprovalController@report_file_approve_index');

    Route::get('monitor-and-suppervision-status', 'MonitorAndSuppervisionController@index');

//GIS
    Route::get('gis', 'GisController@index');
}); //end auth

//all ajax
Route::group(['prefix' => 'ajax'], function () {

    Route::group(['namespace' => 'Training'], function () {
        Route::post('get_training_by_id/{id}', 'TrainingActivityController@get_training_name');
        Route::get('training_module_deatails_by_t_cat_id/{id}', 'TrainingReportController@details');
    });

    Route::group(['namespace' => 'Admin'], function () {
        Route::post('/get_indicator/{id}', 'IndicatorController@get_indicator');
        Route::post('/get_active_indicator/{id}', 'ActivityIndicatorController@get_active_indicator');
        Route::post('/package_working_progrss/get_indicator/{id}', 'PackageController@get_progress_indicator');
        Route::post('/get_contractor_by_package_id/{id}', 'PackageController@get_contractor');
        Route::post('/get_unit_by_type_id/{id}', 'UnitController@get_unit');
        Route::get('/get_group_input_field_by_type_id', 'ProcurementMethodController@get_input_group');
        Route::get('/get_indicator_progress/{id}', 'IndicatorDataController@indicator_progress');
    });
    Route::group(['namespace' => 'Finance'], function () {
        Route::post('/get_contractor_by_financial_item_id/{id}', 'FinancialItemController@get_contractor');
        Route::get('finance-report-by-category/{id}', 'FinanceController@get_table_data');
        Route::get('finance-report-by-submit/{catid?}/{date?}', 'FinanceController@get_table_data_by_category_and_Date');
    });

    Route::get('report/monthly_report_planning', 'FinancialController@set_ajax_view');
    Route::get('report/procurement_monthly_report', 'ProcurementController@set_report_view');

    Route::get('show-financial-file', 'Finance\FinanceController@get_financial_file');
    Route::post('/file_for_package_dashboard_page', 'PackageDashboardController@get_file');
    Route::post('/package_wise_payment', 'PackageDashboardController@all_payment');

    Route::get('drawing-design-report-by-category/{id}/{package_id}', 'DrawingDesignController@get_table_data');
    Route::get('drawing-design-report-by-submit', 'DrawingDesignController@get_table_data_by_category_and_Date');

    Route::get('emcrp-project-information-dphe-by-category/{id}', 'ProjectInformationController@get_table_data');
    Route::get('emcrp-project-information-dphe-by-submit/{catid}/{date}', 'ProjectInformationController@get_table_data_by_category_and_Date');

    Route::get('gis-by-category/{id}', 'GisController@get_table_data');
    Route::get('gis-by-submit/{catid?}/{date?}', 'GisController@get_table_data_by_category_and_Date');

    Route::get('get-formate-adp-report-template', 'ADP\ADPReportController@get_formate_adp_report_template');

    Route::get('/approve/{id}', 'ApprovalController@approve');
    Route::get('dis_approve/{id}', 'ApprovalController@dis_approve');
    Route::get('/report-file-approve/{id}', 'ApprovalController@report_file_approve');
    Route::get('report-file-dis_approve/{id}', 'ApprovalController@report_file_dis_approve');

    Route::get('package-list-by-type-id/{id}', 'PackagewiseReportController@choosePackage');
    Route::get('report-by-category/{id}', 'PackagewiseReportController@report_by_category');
    Route::get('dashboard-report-filtering', 'PackagewiseReportController@dashboard_report_filtering');
    Route::get('package-wise-report-by-category', 'PackagewiseReportController@package_wise_report_by_category');
    Route::get('package-wise-report-by-filtering', 'PackagewiseReportController@report_filter');
    Route::get('/indicator-details', 'PackageDashboardController@indicator_details');

    // Route::get('dashboard/package-report','PackagewiseReportController@package_wise_pagination');
    Route::get('/dashboard/package-report', 'PackagewiseReportController@index');
    Route::get('/procurement/package_details_by_id', 'ProcurementController@get_package');
    Route::get('/app_image_approve/{id}', 'AppImageController@image_approve');
    Route::get('/second_layer_app_image_approve/{id}', 'AppImageController@image_approve_second_layer');
    Route::get('/get_activity_list/{id}', 'AppImageController@get_activity_list');
    Route::get('/get_union_list/{id}', 'AppImageController@get_union_list');

    Route::get('/get_category_by_package_id/{id}', 'PackagewiseReportController@get_category_list');

});

// Route::get('phpinfo', function () {
//     phpinfo();
// });

// Route::get('{slug}/{id?}/{name?}', function ($slug, $id = null, $name = null) {
//     return $slug . $id . '-' . $name;
// });
