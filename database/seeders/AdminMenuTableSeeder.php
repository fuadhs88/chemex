<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Index',
                'icon' => 'feather icon-bar-chart-2',
                'uri' => '/',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:20',
                'updated_at' => '2020-12-29 21:39:06',
            ),
            1 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 25,
                'title' => 'Vendor Records',
                'icon' => 'feather icon-zap',
                'uri' => 'vendor/records',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:23',
                'updated_at' => '2020-11-18 21:14:55',
            ),
            2 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 4,
                'title' => 'Device Management',
                'icon' => 'feather icon-monitor',
                'uri' => '',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:25',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            3 => 
            array (
                'id' => 17,
                'parent_id' => 16,
                'order' => 6,
                'title' => 'Device Categories',
                'icon' => '',
                'uri' => 'device/categories',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:27',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            4 => 
            array (
                'id' => 18,
                'parent_id' => 0,
                'order' => 16,
                'title' => 'Staff Management',
                'icon' => 'feather icon-user-check',
                'uri' => '',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:25',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            5 => 
            array (
                'id' => 19,
                'parent_id' => 18,
                'order' => 18,
                'title' => 'Staff Departments',
                'icon' => '',
                'uri' => 'staff/departments',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:27',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            6 => 
            array (
                'id' => 20,
                'parent_id' => 18,
                'order' => 17,
                'title' => 'Staff Records',
                'icon' => '',
                'uri' => 'staff/records',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:26',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            7 => 
            array (
                'id' => 21,
                'parent_id' => 16,
                'order' => 5,
                'title' => 'Device Records',
                'icon' => '',
                'uri' => 'device/records',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:28',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            8 => 
            array (
                'id' => 24,
                'parent_id' => 16,
                'order' => 7,
                'title' => 'Device Tracks',
                'icon' => '',
                'uri' => 'device/tracks',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:29',
                'updated_at' => '2020-12-19 01:10:31',
            ),
            9 => 
            array (
                'id' => 25,
                'parent_id' => 0,
                'order' => 22,
                'title' => 'Check Management',
                'icon' => 'feather icon-check-circle',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-04 10:22:42',
                'updated_at' => '2020-12-19 01:10:21',
            ),
            10 => 
            array (
                'id' => 26,
                'parent_id' => 25,
                'order' => 23,
                'title' => 'Check Records',
                'icon' => NULL,
                'uri' => 'check/records',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-04 10:23:17',
                'updated_at' => '2020-12-19 01:10:21',
            ),
            11 => 
            array (
                'id' => 27,
                'parent_id' => 25,
                'order' => 24,
                'title' => 'Check Tracks',
                'icon' => NULL,
                'uri' => 'check/tracks',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-04 10:23:33',
                'updated_at' => '2020-12-19 01:10:21',
            ),
            12 => 
            array (
                'id' => 53,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Maintenance Records',
                'icon' => 'feather icon-shield',
                'uri' => 'maintenance/records',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-10 15:06:15',
                'updated_at' => '2020-12-19 01:10:21',
            ),
            13 => 
            array (
                'id' => 54,
                'parent_id' => 56,
                'order' => 32,
                'title' => 'Version',
                'icon' => 'feather icon-chevrons-down',
                'uri' => 'version',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-10-22 15:05:00',
                'updated_at' => '2020-12-24 21:21:34',
            ),
            14 => 
            array (
                'id' => 55,
                'parent_id' => 56,
                'order' => 38,
                'title' => 'Menu',
                'icon' => NULL,
                'uri' => 'auth/menu',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-11-03 14:22:49',
                'updated_at' => '2020-12-24 21:21:34',
            ),
            15 => 
            array (
                'id' => 56,
                'parent_id' => 0,
                'order' => 31,
                'title' => 'Settings',
                'icon' => 'feather icon-settings',
                'uri' => NULL,
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-11-03 14:23:14',
                'updated_at' => '2020-12-24 21:21:34',
            ),
            16 => 
            array (
                'id' => 57,
                'parent_id' => 56,
                'order' => 35,
                'title' => 'Users',
                'icon' => NULL,
                'uri' => 'auth/users',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-11-03 14:25:13',
                'updated_at' => '2020-12-24 21:21:34',
            ),
            17 => 
            array (
                'id' => 58,
                'parent_id' => 56,
                'order' => 36,
                'title' => 'Roles',
                'icon' => NULL,
                'uri' => 'auth/roles',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-11-03 14:25:25',
                'updated_at' => '2020-12-24 21:21:34',
            ),
            18 => 
            array (
                'id' => 59,
                'parent_id' => 56,
                'order' => 37,
                'title' => 'Permissions',
                'icon' => NULL,
                'uri' => 'auth/permissions',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-11-03 14:26:37',
                'updated_at' => '2020-12-24 21:21:34',
            ),
            19 => 
            array (
                'id' => 60,
                'parent_id' => 0,
                'order' => 26,
                'title' => 'Purchased Channels',
                'icon' => 'feather icon-shopping-cart',
                'uri' => 'purchased/channels',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-11-18 21:08:58',
                'updated_at' => '2020-11-18 21:14:55',
            ),
            20 => 
            array (
                'id' => 61,
                'parent_id' => 0,
                'order' => 27,
                'title' => 'Depreciation Rules',
                'icon' => 'feather icon-trending-down',
                'uri' => '/depreciation/rules',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-12-14 19:38:17',
                'updated_at' => '2020-12-19 01:11:08',
            ),
            21 => 
            array (
                'id' => 62,
                'parent_id' => 56,
                'order' => 33,
                'title' => 'Configuration Platform',
                'icon' => NULL,
                'uri' => '/configurations/platform',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-12-14 19:38:17',
                'updated_at' => '2020-12-26 17:33:08',
            ),
            22 => 
            array (
                'id' => 63,
                'parent_id' => 0,
                'order' => 28,
                'title' => 'Tools',
                'icon' => 'feather icon-layers',
                'uri' => '',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-12-14 19:38:17',
                'updated_at' => '2020-12-19 01:11:08',
            ),
            23 => 
            array (
                'id' => 64,
                'parent_id' => 63,
                'order' => 29,
                'title' => 'Chemex App',
                'icon' => '',
                'uri' => '/tools/chemex_app',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-12-14 19:38:17',
                'updated_at' => '2020-12-19 01:11:08',
            ),
            24 => 
            array (
                'id' => 65,
                'parent_id' => 63,
                'order' => 30,
                'title' => 'QRCode Generator',
                'icon' => '',
                'uri' => '/tools/qrcode_generator',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-12-14 19:38:17',
                'updated_at' => '2020-12-19 01:11:08',
            ),
            25 => 
            array (
                'id' => 66,
                'parent_id' => 56,
                'order' => 34,
                'title' => 'Configuration LDAP',
                'icon' => NULL,
                'uri' => '/configurations/ldap',
                'extension' => '',
                'show' => 1,
                'created_at' => '2020-12-24 21:21:27',
                'updated_at' => '2020-12-24 21:21:27',
            ),
            26 => 
            array (
                'id' => 67,
                'parent_id' => 0,
                'order' => 39,
                'title' => 'Part Management',
                'icon' => 'feather icon-server',
                'uri' => '',
                'extension' => 'celaraze.chemex-part',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:32',
                'updated_at' => '2021-01-28 16:17:32',
            ),
            27 => 
            array (
                'id' => 68,
                'parent_id' => 67,
                'order' => 40,
                'title' => 'Part Records',
                'icon' => '',
                'uri' => 'part/records',
                'extension' => 'celaraze.chemex-part',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:32',
                'updated_at' => '2021-01-28 16:17:32',
            ),
            28 => 
            array (
                'id' => 69,
                'parent_id' => 67,
                'order' => 41,
                'title' => 'Part Categories',
                'icon' => '',
                'uri' => 'part/categories',
                'extension' => 'celaraze.chemex-part',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:32',
                'updated_at' => '2021-01-28 16:17:32',
            ),
            29 => 
            array (
                'id' => 70,
                'parent_id' => 67,
                'order' => 42,
                'title' => 'Part Tracks',
                'icon' => '',
                'uri' => 'part/tracks',
                'extension' => 'celaraze.chemex-part',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:32',
                'updated_at' => '2021-01-28 16:17:32',
            ),
            30 => 
            array (
                'id' => 71,
                'parent_id' => 0,
                'order' => 43,
                'title' => 'Service Management',
                'icon' => 'feather icon-activity',
                'uri' => '',
                'extension' => 'celaraze.chemex-service',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:38',
                'updated_at' => '2021-01-28 16:17:38',
            ),
            31 => 
            array (
                'id' => 72,
                'parent_id' => 71,
                'order' => 44,
                'title' => 'Service Records',
                'icon' => '',
                'uri' => 'service/records',
                'extension' => 'celaraze.chemex-service',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:38',
                'updated_at' => '2021-01-28 16:17:38',
            ),
            32 => 
            array (
                'id' => 73,
                'parent_id' => 71,
                'order' => 45,
                'title' => 'Service Tracks',
                'icon' => '',
                'uri' => 'service/tracks',
                'extension' => 'celaraze.chemex-service',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:38',
                'updated_at' => '2021-01-28 16:17:38',
            ),
            33 => 
            array (
                'id' => 74,
                'parent_id' => 71,
                'order' => 46,
                'title' => 'Service Issues',
                'icon' => '',
                'uri' => 'service/issues',
                'extension' => 'celaraze.chemex-service',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:38',
                'updated_at' => '2021-01-28 16:17:38',
            ),
            34 => 
            array (
                'id' => 75,
                'parent_id' => 0,
                'order' => 47,
                'title' => 'Software Management',
                'icon' => 'feather icon-disc',
                'uri' => '',
                'extension' => 'celaraze.chemex-software',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:40',
                'updated_at' => '2021-01-28 16:17:40',
            ),
            35 => 
            array (
                'id' => 76,
                'parent_id' => 75,
                'order' => 48,
                'title' => 'Software Records',
                'icon' => '',
                'uri' => 'software/records',
                'extension' => 'celaraze.chemex-software',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:40',
                'updated_at' => '2021-01-28 16:17:40',
            ),
            36 => 
            array (
                'id' => 77,
                'parent_id' => 75,
                'order' => 49,
                'title' => 'Software Categories',
                'icon' => '',
                'uri' => 'software/categories',
                'extension' => 'celaraze.chemex-software',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:40',
                'updated_at' => '2021-01-28 16:17:40',
            ),
            37 => 
            array (
                'id' => 78,
                'parent_id' => 75,
                'order' => 50,
                'title' => 'Software Tracks',
                'icon' => '',
                'uri' => 'software/tracks',
                'extension' => 'celaraze.chemex-software',
                'show' => 1,
                'created_at' => '2021-01-28 16:17:40',
                'updated_at' => '2021-01-28 16:17:40',
            ),
            38 => 
            array (
                'id' => 79,
                'parent_id' => 0,
                'order' => 51,
                'title' => 'Dcat Plus',
                'icon' => 'feather icon-settings',
                'uri' => 'dcat-plus/site',
                'extension' => 'celaraze.dcat-extension-plus',
                'show' => 1,
                'created_at' => '2021-01-28 16:39:46',
                'updated_at' => '2021-01-28 16:39:46',
            ),
        ));
        
        
    }
}