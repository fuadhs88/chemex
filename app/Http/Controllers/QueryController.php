<?php

namespace App\Http\Controllers;

use App\Models\DeviceRecord;
use App\Models\PartRecord;
use App\Models\SoftwareRecord;
use Illuminate\Http\JsonResponse;
use Pour\Base\Uni;

class QueryController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * 移动端扫码查看设备配件软件详情
     * @param $string
     * @return JsonResponse
     */
    public function query($string): JsonResponse
    {
        $item = explode(':', $string)[0];
        $id = explode(':', $string)[1];
        switch ($item) {
            case 'device':
                $item = DeviceRecord::where('id', $id)
                    ->first();
                optional($item->staff)->department;
                break;
            case 'part':
                $item = PartRecord::where('id', $id)
                    ->first();
                break;
            case 'software':
                $item = SoftwareRecord::where('id', $id)
                    ->first();
                break;
            default:
                $item = [];
        }
        $item->category;
        $item->vendor;
        $item->channel;
        $return = Uni::rr(200, '查询成功', $item);
        return response()->json($return);
    }
}
