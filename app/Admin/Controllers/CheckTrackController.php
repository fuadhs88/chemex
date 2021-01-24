<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\RowAction\CheckTrackUpdateAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Repositories\CheckTrack;
use App\Models\CheckRecord;
use App\Models\DeviceRecord;
use App\Models\PartRecord;
use App\Models\SoftwareRecord;
use App\Support\Data;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

/**
 * @property int check_id
 * @property int status
 */
class CheckTrackController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new CheckTrack(['checker']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('check_id');
            $grid->column('item_id')->display(function ($item_id) {
                $check = CheckRecord::where('id', $this->check_id)->first();
                if (empty($check)) {
                    return '任务状态异常';
                } else {
                    $check_item = $check->check_item;
                    switch ($check_item) {
                        case 'part':
                            $item = PartRecord::where('id', $item_id)->first();
                            break;
                        case 'software':
                            $item = SoftwareRecord::where('id', $item_id)->first();
                            break;
                        default:
                            $item = DeviceRecord::where('id', $item_id)->first();
                    }
                    if (empty($item)) {
                        return '物品状态异常';
                    } else {
                        return $item->name;
                    }
                }
            });
            $grid->column('status')->using(Data::checkTrackStatus());
            $grid->column('checker.name');
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->disableRowSelector();
            $grid->disableBatchActions();
            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->disableDeleteButton();

            $grid->actions(function (RowActions $actions) {
                if (Admin::user()->can('check.track.update') && $this->status == 0) {
                    $actions->append(new CheckTrackUpdateAction());
                }
            });

            $grid->toolsWithOutline(false);

            $grid->quickSearch('id', 'check_id', 'checker.name')
                ->placeholder('试着搜索一下')
                ->auto(false);
        });
    }

    /**
     * Make a show builder.
     *
     * @return Alert
     */
    protected function detail(): Alert
    {
        return Data::unsupportedOperationWarning();
    }

    /**
     * Make a form builder.
     *
     * @return Alert
     */
    protected function form(): Alert
    {
        return Data::unsupportedOperationWarning();
    }
}
