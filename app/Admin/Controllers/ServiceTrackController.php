<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\RowAction\ServiceTrackDeleteAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Repositories\ServiceTrack;
use App\Support\Data;
use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Alert;

/**
 * @property string deleted_at
 */
class ServiceTrackController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new ServiceTrack(['service', 'device']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('service.name');
            $grid->column('device.name');
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->toolsWithOutline(false);

            $grid->disableCreateButton();
            $grid->disableRowSelector();
            $grid->disableBatchActions();
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();

            $grid->actions(function (RowActions $actions) {
                if (Admin::user()->can('service.track.delete') && $this->deleted_at == null) {
                    $actions->append(new ServiceTrackDeleteAction());
                }
            });

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->scope('history', '查看历史归属记录')->onlyTrashed();
            });

            $grid->quickSearch('id', 'service.name', 'device.name')
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
