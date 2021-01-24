<?php


namespace App\Services;


use App\Models\SoftwareRecord;
use App\Models\SoftwareTrack;
use App\Support\Track;

/**
 * 和软件记录相关的功能服务
 * Class SoftwareRecordService
 * @package App\Services
 */
class SoftwareRecordService
{
    /**
     * 获取软件的履历清单
     * @param $id
     * @return array
     */
    public static function history($id): array
    {
        $data = [];

        $single = [
            'type' => '',
            'name' => '',
            'status' => '',
            'style' => '',
            'datetime' => ''
        ];

        $software_tracks = SoftwareTrack::withTrashed()
            ->where('software_id', $id)
            ->get();

        foreach ($software_tracks as $software_track) {
            $single['type'] = '设备';
            $single['name'] = optional($software_track->device)->name;
            $data = Track::itemTrack($single, $software_track, $data);
        }

        $datetime = array_column($data, 'datetime');
        array_multisort($datetime, SORT_DESC, $data);

        return $data;
    }

    /**
     * 删除软件
     * @param $software_id
     */
    public static function deleteSoftware($software_id)
    {
        $software = SoftwareRecord::where('id', $software_id)->first();
        if (!empty($software)) {
            $software_tracks = SoftwareTrack::where('software_id', $software->id)
                ->get();

            foreach ($software_tracks as $software_track) {
                $software_track->delete();
            }

            $software->delete();
        }
    }
}
