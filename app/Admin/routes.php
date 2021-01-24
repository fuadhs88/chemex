<?php

use App\Admin\Controllers\CheckRecordController;
use App\Admin\Controllers\DeviceRecordController;
use App\Admin\Controllers\NotificationController;
use App\Admin\Controllers\SoftwareRecordController;
use Dcat\Admin\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');

    $router->get('/ldap/test', 'ConfigurationLDAPController@test')->name('ldap.test');
    $router->get('/ldap/test_mode', 'LDAPController@testMode');

    /**
     * 辅助信息
     */
    $router->get('/version', 'VersionController@index');
    $router->get('/version/remote', 'VersionController@getRemoteVersion')
        ->name('remote');
    $router->get('/version/migrate', 'VersionController@migrate')
        ->name('migrate');
    $router->get('/version/clear', 'VersionController@clear')
        ->name('clear');

    /**
     * 配置
     */
    $router->get('/configurations/site', 'ConfigurationSiteController@index')
        ->name('configurations.site.index');
    $router->get('/configurations/ldap', 'ConfigurationLDAPController@index')
        ->name('configurations.ldap.index');

    /**
     * 工具
     */
    $router->get('/tools/qrcode_generator', 'ToolQRCodeGeneratorController@index')
        ->name('qrcode_generator');
    $router->get('/tools/chemex_app', 'ToolChemexAppController@index')
        ->name('chemex_app');

    /**
     * 测试
     */
    $router->get('/test', 'HomeController@test');

    /**
     * 设备管理
     */
    $router->resource('/device/records', 'DeviceRecordController', ['names' => [
        'index' => 'device.records.index',
        'show' => 'device.records.show'
    ]]);
    $router->resource('/device/tracks', 'DeviceTrackController', ['names' => [
        'index' => 'device.tracks.index',
        'show' => 'device.tracks.show'
    ]]);
    $router->resource('/device/categories', 'DeviceCategoryController', ['names' => [
        'index' => 'device.categories.index',
        'show' => 'device.categories.show'
    ]]);

    /**
     * 配件管理
     */
    $router->resource('/part/records', 'PartRecordController', ['names' => [
        'index' => 'part.records.index',
        'show' => 'part.records.show'
    ]]);
    $router->resource('/part/tracks', 'PartTrackController', ['names' => [
        'index' => 'part.tracks.index',
        'show' => 'part.tracks.show'
    ]]);
    $router->resource('/part/categories', 'PartCategoryController', ['names' => [
        'index' => 'part.categories.index',
        'show' => 'part.categories.show'
    ]]);

    /**
     * 软件管理
     */
    $router->resource('/software/records', 'SoftwareRecordController', ['names' => [
        'index' => 'software.records.index',
        'show' => 'software.records.show'
    ]]);
    $router->resource('/software/categories', 'SoftwareCategoryController', ['names' => [
        'index' => 'software.categories.index',
        'show' => 'software.categories.show'
    ]]);
    $router->resource('/software/tracks', 'SoftwareTrackController', ['names' => [
        'index' => 'software.tracks.index',
        'show' => 'software.tracks.show'
    ]]);

    /**
     * 耗材管理
     */
    $router->resource('/consumable/records', 'ConsumableRecordController', ['names' => [
        'index' => 'consumable.records.index',
        'show' => 'consumable.records.show'
    ]]);
    $router->resource('/consumable/categories', 'ConsumableCategoryController', ['names' => [
        'index' => 'consumable.categories.index',
        'show' => 'consumable.categories.show'
    ]]);
    $router->resource('/consumable/tracks', 'ConsumableTrackController', ['names' => [
        'index' => 'consumable.tracks.index',
        'show' => 'consumable.tracks.show'
    ]]);

    /**
     * 厂商管理
     */
    $router->resource('/vendor/records', 'VendorRecordController');

    /**
     * 购入途径管理
     */
    $router->resource('/purchased/channels', 'PurchasedChannelController');

    /**
     * 组织管理
     */
    $router->resource('/staff/records', 'StaffRecordController', ['names' => [
        'index' => 'staff.records.index'
    ]]);
    $router->resource('/staff/departments', 'StaffDepartmentController');

    /**
     * 盘点管理
     */
    $router->resource('/check/records', 'CheckRecordController', ['names' => [
        'index' => 'check.records.index',
        'show' => 'check.records.show'
    ]]);
    $router->resource('/check/tracks', 'CheckTrackController');

    /**
     * 服务管理
     */
    $router->resource('/service/records', 'ServiceRecordController', ['names' => [
        'index' => 'service.records.index',
        'show' => 'service.records.show'
    ]]);
    $router->resource('/service/issues', 'ServiceIssueController', ['names' => [
        'index' => 'service.issues.index'
    ]]);
    $router->resource('/service/tracks', 'ServiceTrackController');

    /**
     * 故障维护
     */
    $router->resource('/maintenance/records', 'MaintenanceRecordController');

    /**
     * 折旧规则
     */
    $router->resource('/depreciation/rules', 'DepreciationRuleController');

    /**
     * 图表管理 TODO
     */
    $router->resource('/chart/records', 'ChartRecordController');

    /**
     * 导出
     */
    $router->get('/export/device/{device_id}/history', [DeviceRecordController::class, 'exportHistory'])
        ->name('export.device.history');
    $router->get('/export/software/{software_id}/history', [SoftwareRecordController::class, 'exportHistory'])
        ->name('export.software.history');
    $router->get('/export/check/{check_id}/report', [CheckRecordController::class, 'exportReport'])
        ->name('export.check.report');

    /**
     * 通知
     */
    $router->get('/notifications/read_all', [NotificationController::class, 'readAll'])
        ->name('notification.read.all');
    $router->get('/notifications/read/{id}', [NotificationController::class, 'read'])
        ->name('notification.read');
});
