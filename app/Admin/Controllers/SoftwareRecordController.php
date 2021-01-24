<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchAction\SoftwareRecordBatchDeleteAction;
use App\Admin\Actions\Grid\RowAction\SoftwareRecordDeleteAction;
use App\Admin\Actions\Grid\RowAction\SoftwareTrackCreateUpdateAction;
use App\Admin\Actions\Grid\RowAction\SoftwareTrackDeleteAction;
use App\Admin\Actions\Grid\ToolAction\SoftwareRecordImportAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Metrics\CheckSoftwarePercentage;
use App\Admin\Metrics\SoftwareAboutToExpireCounts;
use App\Admin\Metrics\SoftwareExpiredCounts;
use App\Admin\Repositories\SoftwareRecord;
use App\Admin\Repositories\SoftwareTrack;
use App\Models\DeviceRecord;
use App\Models\PurchasedChannel;
use App\Models\SoftwareCategory;
use App\Models\VendorRecord;
use App\Services\ExpirationService;
use App\Services\ExportService;
use App\Services\SoftwareRecordService;
use App\Support\Data;
use App\Support\Track;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Card;

/**
 * @property  DeviceRecord device
 * @property  int id
 * @property  string deleted_at
 */
class SoftwareRecordController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(3, new CheckSoftwarePercentage());
                        $row->column(3, new SoftwareAboutToExpireCounts());
                        $row->column(3, new SoftwareExpiredCounts());
                    });
                });
                $row->column(12, $this->grid());
            });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new SoftwareRecord(['category', 'vendor']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('qrcode')->qrcode(function () {
                return 'software:' . $this->id;
            }, 200, 200);
            $grid->column('name');
            $grid->column('description');
            $grid->column('asset_number');
            $grid->column('category.name');
            $grid->column('version');
            $grid->column('vendor.name');
            $grid->column('price');
            $grid->column('purchased');
            $grid->column('expired');
            $grid->column('distribution')->using(Data::distribution());
            $grid->column('counts');
            $grid->column('', admin_trans_label('Left Counts'))->display(function () {
                return Track::leftSoftwareCounts($this->id);
            });
            $grid->column('', admin_trans_label('Expiration Left Days'))->display(function () {
                return ExpirationService::itemExpirationLeftDaysRender('software', $this->id);
            });
            $grid->column('location');

            $grid->actions(function (RowActions $actions) {
                if (Admin::user()->can('software.record.delete')) {
                    $actions->append(new SoftwareRecordDeleteAction());
                }
                if (Admin::user()->can('software.track.create_update')) {
                    $actions->append(new SoftwareTrackCreateUpdateAction());
                }
                if (Admin::user()->can('software.track.list')) {
                    $tracks_route = route('software.tracks.index', ['_search_' => $this->id]);
                    $actions->append("<a href='$tracks_route'>💿 管理归属</a>");
                }
            });

            $grid->showColumnSelector();
            $grid->hideColumns(['description', 'price', 'expired', 'location']);

            $grid->quickSearch(
                'id',
                'name',
                'asset_number',
                'category.name',
                'version',
                'price',
                'location'
            )
                ->placeholder('试着搜索一下')
                ->auto(false);

            $grid->enableDialogCreate();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();

            $grid->batchActions([
                new SoftwareRecordBatchDeleteAction()
            ]);

            $grid->tools([
                new SoftwareRecordImportAction()
            ]);

            $grid->toolsWithOutline(false);

            $grid->export();
        });
    }

    public function show($id, Content $content): Content
    {
        $history = SoftwareRecordService::history($id);
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.show'))
            ->body(function (Row $row) use ($id, $history) {
                // 判断权限
                if (!Admin::user()->can('software.track.list')) {
                    $row->column(12, $this->detail($id));
                } else {
                    $row->column(6, $this->detail($id));
                    $row->column(6, function (Column $column) use ($id, $history) {
                        $grid = Grid::make(new SoftwareTrack(['software', 'device', 'device.staff']), function (Grid $grid) use ($id) {
                            $grid->model()->where('software_id', '=', $id);
                            $grid->tableCollapse(false);
                            $grid->withBorder();

                            $grid->column('id');
                            $grid->column('device.name')->link(function () {
                                if (!empty($this->device)) {
                                    return route('device.records.show', $this->device['id']);
                                }
                            });
                            $grid->column('device.staff.name');

                            $grid->disableToolbar();
                            $grid->disableBatchDelete();
                            $grid->disableRowSelector();
                            $grid->disableViewButton();
                            $grid->disableEditButton();
                            $grid->disableDeleteButton();

                            $grid->actions(function (RowActions $actions) {
                                if (Admin::user()->can('software.track.disable') && $this->deleted_at == null) {
                                    $actions->append(new SoftwareTrackDeleteAction());
                                }
                            });
                        });
                        $column->row(new Card('管理归属（授权）', $grid));
                        $card = new Card('履历', view('history')->with('data', $history));
                        $column->row($card->tool('<a class="btn btn-primary btn-xs" href="' . route('export.software.history', $id) . '" target="_blank">导出到 Excel</a>'));
                    });
                }
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
        return Show::make($id, new SoftwareRecord(['category', 'vendor', 'channel']), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('asset_number');
            $show->field('description');
            $show->field('category.name');
            $show->field('version');
            $show->field('vendor.name');
            $show->field('channel.name');
            $show->field('price');
            $show->field('purchased');
            $show->field('expired');
            $show->field('distribution')->using(Data::distribution());
            $show->field('counts');
            $show->field('location');
            $show->field('created_at');
            $show->field('updated_at');

            $show->disableDeleteButton();
        });
    }

    /**
     * 履历导出
     * @param $software_id
     * @return mixed
     */
    public function exportHistory($software_id)
    {
        return ExportService::SoftwareHistory($software_id);
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new SoftwareRecord(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('version')->required();
            $form->select('category_id', admin_trans_label('Category'))
                ->options(SoftwareCategory::selectOptions())
                ->required();
            $form->select('vendor_id', admin_trans_label('Vendor'))
                ->options(VendorRecord::all()->pluck('name', 'id'))
                ->required();
            $form->select('distribution')
                ->options(Data::distribution())
                ->default('u')
                ->required();
            $form->number('counts')
                ->min(-1)
                ->default(1)
                ->required()
                ->help('"-1"表示无限制。');
            $form->divider();
            $form->text('sn');
            $form->text('description');
            $form->text('asset_number');
            $form->select('purchased_channel_id', admin_trans_label('Purchased Channel Id'))
                ->options(PurchasedChannel::all()->pluck('name', 'id'));
            $form->currency('price')->default(0);
            $form->date('purchased');
            $form->date('expired');
            $form->text('location')
                ->help('记录存放位置，例如某个货架、某个抽屉。');

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableDeleteButton();

            $form->disableCreatingCheck();
            $form->disableEditingCheck();
            $form->disableViewCheck();
        });
    }
}
