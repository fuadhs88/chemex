<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\RowAction\CheckRecordUpdateNoAction;
use App\Admin\Actions\Grid\RowAction\CheckRecordUpdateYesAction;
use App\Admin\Actions\Grid\RowAction\CheckTrackUpdateAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Repositories\CheckRecord;
use App\Models\AdminUser;
use App\Models\CheckTrack;
use App\Models\DeviceRecord;
use App\Models\PartRecord;
use App\Models\SoftwareRecord;
use App\Services\CheckRecordService;
use App\Support\Data;
use App\Support\Track;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;

/**
 * @property int status
 * @property int check_id
 */
class CheckRecordController extends AdminController
{

    public function exportReport($check_id)
    {
        return CheckRecordService::report($check_id);
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content): Content
    {
        $grid = Grid::make(new \App\Admin\Repositories\CheckTrack(['checker']), function (Grid $grid) use ($id) {
            $grid->model()->where('check_id', $id);

            $grid->column('id');
            $grid->column('item_id')->display(function ($item_id) {
                $check = \App\Models\CheckRecord::where('id', $this->check_id)->first();
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
                if (Admin::user()->can('check.track') && $this->status == 0) {
                    $actions->append(new CheckTrackUpdateAction());
                }
            });

            $grid->toolsWithOutline(false);

            $grid->quickSearch('id', 'check_id', 'checker.name')
                ->placeholder('试着搜索一下')
                ->auto(false);
        });

        return $content
            ->title($this->title())
            ->description($this->description()['show'] ?? trans('admin.show'))
            ->body(function (Row $row) use ($grid, $id) {
                $row->column(12, $this->detail($id));
                $row->column(12, '<div class="mt-2"></div>');
                $row->column(12, $grid);
            });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id): Show
    {
        return Show::make($id, new CheckRecord(['user']), function (Show $show) {
            $show->field('id');
            $show->field('check_item')->using(Data::items());;
            $show->field('start_time');
            $show->field('end_time');
            $show->field('user.name');
            $show->field('status')->using(Data::checkRecordStatus());
            $show->field('check_all_counts')->as(function () {
                return Track::checkTrackCounts($this->id);
            });
            $show->field('check_yes_counts')->as(function () {
                return Track::checkTrackCounts($this->id, 'Y');
            });
            $show->field('check_no_counts')->as(function () {
                return Track::checkTrackCounts($this->id, 'N');
            });
            $show->field('check_left_counts')->as(function () {
                return Track::checkTrackCounts($this->id, 'L');
            });
            $show->field('created_at');
            $show->field('updated_at');

            $show->disableEditButton();
            $show->disableDeleteButton();
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new CheckRecord(['user']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('check_item')->using(Data::items());
            $grid->column('start_time');
            $grid->column('end_time');
            $grid->column('user.name');
            $grid->column('status')->using(Data::checkRecordStatus());
            $grid->column('check_all_counts')->display(function () {
                return Track::checkTrackCounts($this->id);
            });
            $grid->column('check_yes_counts')->display(function () {
                return Track::checkTrackCounts($this->id, 'Y');
            });
            $grid->column('check_no_counts')->display(function () {
                return Track::checkTrackCounts($this->id, 'N');
            });
            $grid->column('check_left_counts')->display(function () {
                return Track::checkTrackCounts($this->id, 'L');
            });

            $grid->disableRowSelector();
            $grid->disableBatchActions();
            $grid->disableEditButton();
            $grid->disableDeleteButton();

            $grid->actions(function (RowActions $actions) {
                if ($this->status == 0) {
                    if (Admin::user()->can('check.record.update.yes')) {
                        $actions->append(new CheckRecordUpdateYesAction());
                    }
                    if (Admin::user()->can('check.record.update.no')) {
                        $actions->append(new CheckRecordUpdateNoAction());
                    }
                }
                $report_url = route('export.check.report', ['check_id' => $this->id]);
                $actions->append("<a href='$report_url' target='_blank'>✨ 生成报告</a>");
            });

            $grid->toolsWithOutline(false);

            $grid->enableDialogCreate();

            $grid->quickSearch('id', 'user.name')
                ->placeholder('试着搜索一下')
                ->auto(false);

            $grid->export();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new CheckRecord(), function (Form $form) {
            $form->display('id');
            $form->select('check_item')
                ->options(Data::items())
                ->required();
            $form->datetime('start_time')
                ->required();
            $form->datetime('end_time')
                ->required();
            $form->select('user_id', admin_trans_label('User'))
                ->options(AdminUser::all()
                    ->pluck('name', 'id'))
                ->required();

            $form->display('created_at');
            $form->display('updated_at');

            // 提交回调，为了检测在盘点任务创建时，是否有已存在的盘点任务
            // 如果有，就中止，如果没有，就继续
            $form->submitted(function (Form $form) {
                $check_record = \App\Models\CheckRecord::where('check_item', $form->check_item)
                    ->where('status', 0)
                    ->first();
                if (!empty($check_record)) {
                    return $form->response()
                        ->error('还有未完成的相同盘点内容，请先处理');
                }
            });

            // 保存回调，创建盘点任务的同时，自动生成与之相关的全部盘点追踪记录
            $form->saved(function (Form $form) {
                switch ($form->check_item) {
                    case 'part':
                        $items = PartRecord::all();
                        break;
                    case 'software':
                        $items = SoftwareRecord::all();
                        break;
                    default:
                        $items = DeviceRecord::all();
                }
                foreach ($items as $item) {
                    $check_track = new CheckTrack();
                    $check_track->check_id = $form->getKey();
                    $check_track->item_id = $item->id;
                    $check_track->status = 0;
                    $check_track->checker = 0;
                    $check_track->save();
                }
            });

            $form->disableCreatingCheck();
            $form->disableEditingCheck();
            $form->disableViewCheck();
        });
    }
}
