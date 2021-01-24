<?php


namespace App\Support;


use App\Models\CheckRecord;
use App\Models\CheckTrack;
use App\Models\DeviceTrack;
use App\Models\PartTrack;
use App\Models\ServiceIssue;
use App\Models\ServiceRecord;
use App\Models\ServiceTrack;
use App\Models\SoftwareRecord;
use App\Models\SoftwareTrack;
use Illuminate\Database\Eloquent\Collection;

class Track
{
    /**
     * 获取设备当前最新的使用者
     * @param $device_id
     * @return string
     */
    public static function currentDeviceTrackStaff($device_id)
    {
        $device_track = DeviceTrack::where('device_id', $device_id)->first();
        if (empty($device_track)) {
            return 0;
        } else {
            $staff = $device_track->staff;
            if (empty($staff)) {
                return -1;
            } else {
                return $staff->id;
            }
        }
    }

    /**
     * 获取配件当前归属的设备
     * @param $part_id
     * @return string
     */
    public static function currentPartTrack($part_id): string
    {
        $part_track = PartTrack::where('part_id', $part_id)->first();
        if (empty($part_track)) {
            return '闲置';
        } else {
            $device = $part_track->device;
            if (empty($device)) {
                return '设备失踪';
            } else {
                return $device->name;
            }
        }
    }

    /**
     * 获取软件当前剩余授权数量
     * @param $software_id
     * @return int|string
     */
    public static function leftSoftwareCounts($software_id)
    {
        $software = SoftwareRecord::where('id', $software_id)->first();
        if (empty($software)) {
            return '软件状态异常';
        }
        $software_tracks = SoftwareTrack::where('software_id', $software_id)->get();
        $used = count($software_tracks);
        if ($software->counts == -1) {
            return '不受限';
        } else {
            return $software->counts - $used;
        }
    }

    /**
     * 获取服务异常总览（看板）
     * @return ServiceRecord[]|Collection
     */
    public static function getServiceIssueStatus()
    {
        $services = ServiceRecord::all();
        foreach ($services as $service) {
            $service_status = $service->status;
            $service->start = null;
            $service->end = null;
            $service_track = ServiceTrack::where('service_id', $service->id)
                ->first();
            if (empty($service_track) || empty($service_track->device)) {
                $service->device_name = '未知';
            } else {
                $service->device_name = $service_track->device->name;
            }
            $issues = [];
            $service_issues = ServiceIssue::where('service_id', $service->id)
                ->get();
            foreach ($service_issues as $service_issue) {
                if (empty($service->start)) {
                    $service->start = $service_issue->start;
                }
                if (strtotime($service_issue->start) < strtotime($service->start)) {
                    $service->start = $service_issue->start;
                }
                // 如果异常待修复
                if ($service_issue->status == 1) {
                    $service->status = 1;
                    $issue = $service_issue->issue . '<br>';
                    array_push($issues, $issue);
                }
                // 如果是修复的
                if ($service_issue->status == 2) {
                    $service->status = 0;
                    $issue = '<span class="status-recovery">[已修复最近一个问题]</span> ' . $service_issue->issue . '<br>';
                    if ((time() - strtotime($service_issue->end)) > (24 * 60 * 60)) {
                        $issue = '';
                        $service->start = '';
                    } else {
                        // 如果结束时间是空，还没修复
                        if (empty($service->end)) {
                            $service->end = $service_issue->end;
                        }
                        // 如果结束时间大于开始时间，修复了
                        if (strtotime($service_issue->end) > strtotime($service->end)) {
                            $service->end = $service_issue->end;
                        }
                    }
                    array_push($issues, $issue);
                }
            }
            // 如果暂停了
            if ($service_status == 1) {
                $service->status = 3;
                $service->start = date('Y-m-d H:i:s', strtotime($service->updated_at));
            }
            $service->issues = $issues;
        }
        $services = json_decode($services, true);
        return $services;
    }

    /**
     * 物品履历 形成清单数组（未排序）
     * @param $template
     * @param $item_track
     * @param array $data
     * @return array
     */
    public static function itemTrack($template, $item_track, $data = []): array
    {
        $template['status'] = '+';
        $template['datetime'] = json_decode($item_track, true)['created_at'];
        array_push($data, $template);
        if (!empty($item_track->deleted_at)) {
            $template['status'] = '-';
            $template['datetime'] = json_decode($item_track, true)['deleted_at'];
            array_push($data, $template);
        }
        return $data;
    }

    /**
     * 计算盘点任务记录的数量
     * @param $check_id
     * @param string $type
     * @return int
     */
    public static function checkTrackCounts($check_id, $type = 'A'): int
    {
        $check_record = CheckRecord::where('id', $check_id)->first();
        if (empty($check_record)) {
            return 0;
        }

        switch ($type) {
            case 'Y':
                $count = CheckTrack::where('check_id', $check_id)
                    ->where('status', 1)
                    ->count();
                break;
            case 'N':
                $count = CheckTrack::where('check_id', $check_id)
                    ->where('status', 2)
                    ->count();
                break;
            case 'L':
                $count = CheckTrack::where('check_id', $check_id)
                    ->where('status', 0)
                    ->count();
                break;
            default:
                $count = CheckTrack::where('check_id', $check_id)
                    ->withTrashed()
                    ->count();

        }

        return $count;
    }
}
