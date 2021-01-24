<?php


namespace App\Support;


use App\Models\DeviceRecord;
use App\Models\PartRecord;
use App\Models\SoftwareRecord;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Alert;

class Data
{
    /**
     * 发行方式
     * @return string[]
     */
    public static function distribution(): array
    {
        return [
            'u' => '未知',
            'o' => '开源',
            'f' => '免费',
            'b' => '商业授权'
        ];
    }

    /**
     * 性别
     * @return string[]
     */
    public static function genders(): array
    {
        return [
            '无' => '无',
            '男' => '男',
            '女' => '女'
        ];
    }

    /**
     * 物件
     * @return string[]
     */
    public static function items(): array
    {
        return [
            'device' => '设备',
            'part' => '配件',
            'software' => '软件'
        ];
    }

    /**
     * 盘点任务状态
     * @return string[]
     */
    public static function checkRecordStatus(): array
    {
        return [
            0 => '进行',
            1 => '完成',
            2 => '中止'
        ];
    }

    /**
     * 维修状态
     * @return string[]
     */
    public static function maintenanceStatus(): array
    {
        return [
            0 => '等待处理',
            1 => '处理完毕',
            2 => '取消'
        ];
    }

    /**
     * 盘点追踪状态
     * @return string[]
     */
    public static function checkTrackStatus(): array
    {
        return [
            0 => '未盘点',
            1 => '盘盈',
            2 => '盘亏'
        ];
    }

    /**
     * 服务异常状态
     * @return string[]
     */
    public static function serviceIssueStatus(): array
    {
        return [
            0 => '正常',
            1 => '故障',
            2 => '恢复',
            3 => '暂停'
        ];
    }

    /**
     * 软件标签
     * @return array
     */
    public static function softwareTags(): array
    {
        return [
            'windows' => [
                'windows',
                'win10',
                'win8',
                'win7'
            ],
            'macos' => [
                'mac',
                'cheetah',
                'puma',
                'jaguar',
                'panther',
                'tiger',
                'leopard',
                'lion',
                'mavericks',
                'yosemite',
                'capitan',
                'sierra',
                'mojave',
                'catalina',
                'bigsur'
            ],
            'linux' => [
                'linux',
                'centos',
                'ubuntu',
                'kali',
                'debian',
                'arch',
                'deepin'
            ],
            'android' => [
                'cupcake',
                'donut',
                'eclair',
                'froyo',
                'gingerbread',
                'honeycomb',
                'icecreansandwich',
                'jellybean',
                'kitkat',
                'lollipop',
                'marshmallow',
                'nougat',
                'oreo',
                'pie'
            ],
            'ios' => [
                'ios'
            ]
        ];
    }

    /**
     * 返回不支持操作的错误信息 warning
     * @return Alert
     */
    public static function unsupportedOperationWarning(): Alert
    {
        $alert = Alert::make('此功能不允许通过此操作实现。', '未提供的操作');
        $alert->warning();
        $alert->icon('feather icon-alert-triangle');
        return $alert;
    }

    /**
     * 保固状态
     * @return string[]
     */
    public static function expiredStatus(): array
    {
        return [
            'one day' => '一天内过期',
            'three day' => '三天内过期',
            'one week' => '一周内过期',
            'one month' => '一月内过期',
            'normal' => '正常',
            'none' => '无效的设备',
            'default' => '错误'
        ];
    }

    /**
     * 保固状态颜色
     * @return array
     */
    public static function expiredStatusColors(): array
    {
        return [
            'one day' => 'danger',
            'three day' => 'danger',
            'one week' => 'warning',
            'one month' => 'warning',
            'normal' => 'success',
            'none' => 'primary',
            'default' => Admin::color()->gray()
        ];
    }

    /**
     * 获取所有物品的类型和ID，并且以 device:1 形式加入到数组中返回
     * @return array
     */
    public static function getAllItemTypeAndId(): array
    {
        $data = [];
        $device_records = DeviceRecord::all();
        $part_records = PartRecord::all();
        $software_records = SoftwareRecord::all();
        foreach ($device_records as $device_record) {
            array_push($data, 'device:' . $device_record->id . '&#10;');
        }
        foreach ($part_records as $part_record) {
            array_push($data, 'part:' . $part_record->id . '&#10;');
        }
        foreach ($software_records as $software_record) {
            array_push($data, 'software:' . $software_record->id . '&#10;');
        }
        return $data;
    }

    /**
     * 返回时间尺度
     * @return string[]
     */
    public static function timeScales(): array
    {
        return [
            'day' => '天',
            'month' => '月',
            'year' => '年'
        ];
    }

}
