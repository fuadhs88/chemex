<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchAction\PartRecordBatchDeleteAction;
use App\Admin\Actions\Grid\RowAction\MaintenanceCreateAction;
use App\Admin\Actions\Grid\RowAction\PartRecordDeleteAction;
use App\Admin\Actions\Grid\RowAction\PartTrackCreateUpdateAction;
use App\Admin\Actions\Grid\ToolAction\PartRecordImportAction;
use App\Admin\Grid\Displayers\RowActions;
use App\Admin\Metrics\CheckPartPercentage;
use App\Admin\Metrics\PartAboutToExpireCounts;
use App\Admin\Metrics\PartExpiredCounts;
use App\Admin\Repositories\PartRecord;
use App\Models\DepreciationRule;
use App\Models\DeviceRecord;
use App\Models\PartCategory;
use App\Models\PurchasedChannel;
use App\Models\VendorRecord;
use App\Services\ExpirationService;
use App\Support\Info;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;

/**
 * @property DeviceRecord device
 * @property int id
 * @property double price
 * @property string purchased
 */
class PartRecordController extends AdminController
{
    public function index(Content $content): Content
    {
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(3, new CheckPartPercentage());
                        $row->column(3, new PartAboutToExpireCounts());
                        $row->column(3, new PartExpiredCounts());
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
        return Grid::make(new PartRecord(['category', 'vendor', 'device', 'depreciation']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('qrcode')->qrcode(function () {
                return 'part:' . $this->id;
            }, 200, 200);
            $grid->column('asset_number');
            $grid->column('name');
            $grid->column('description');
            $grid->column('category.name');
            $grid->column('vendor.name');
            $grid->column('specification');
            $grid->column('sn');
            $grid->column('expiration_left_days', admin_trans_label('Expiration Left Days'))->display(function () {
                return ExpirationService::itemExpirationLeftDaysRender('part', $this->id);
            });
            $grid->actions(function (RowActions $actions) {
                if (Admin::user()->can('part.record.delete')) {
                    $actions->append(new PartRecordDeleteAction());
                }
                if (Admin::user()->can('part.track.create_update')) {
                    $actions->append(new PartTrackCreateUpdateAction());
                }
                if (Admin::user()->can('part.maintenance.create')) {
                    $actions->append(new MaintenanceCreateAction('part'));
                }
            });
            $grid->column('device.name')->link(function () {
                if (!empty($this->device)) {
                    return route('device.records.show', $this->device['id']);
                }
            });
            $grid->column('depreciation.name');
            $grid->column('location');

            $grid->showColumnSelector();
//            $grid->hideColumns(['description', 'price', 'expired', 'location']);

            $grid->quickSearch(
                'id',
                'name',
                'asset_number',
                'description',
                'category.name',
                'vendor.name',
                'specification',
                'sn',
                'device.name',
                'location'
            )
                ->placeholder('尝试搜索一下')
                ->auto(false);

            $grid->enableDialogCreate();
            $grid->disableDeleteButton();
            $grid->disableBatchDelete();

            $grid->batchActions([
                new PartRecordBatchDeleteAction()
            ]);

            $grid->tools([
                new PartRecordImportAction()
            ]);

            $grid->toolsWithOutline(false);
            $grid->export();
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
        return Show::make($id, new PartRecord(['category', 'vendor', 'channel', 'device', 'depreciation']), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('asset_number');
            $show->field('description');
            $show->field('category.name');
            $show->field('vendor.name');
            $show->field('channel.name');
            $show->field('device.name');
            $show->field('specification');
            $show->field('sn');
            $show->field('price');
            $show->field('expiration_left_days', admin_trans_label('Depreciation Price'))->as(function () {
                $part_record = \App\Models\PartRecord::where('id', $this->id)->first();
                if (!empty($part_record)) {
                    $depreciation_rule_id = Info::getDepreciationRuleId($part_record);
                    return Info::depreciationPrice($this->price, $this->purchased, $depreciation_rule_id);
                }
            });
            $show->field('purchased');
            $show->field('expired');
            $show->field('depreciation.name');
            $show->field('depreciation.termination');
            $show->field('location');
            $show->field('created_at');
            $show->field('updated_at');

            $show->disableDeleteButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new PartRecord(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->select('category_id', admin_trans_label('Category'))
                ->options(PartCategory::selectOptions())
                ->required();
            $form->text('specification')->required();
            $form->select('vendor_id', admin_trans_label('Vendor'))
                ->options(VendorRecord::all()
                    ->pluck('name', 'id'))
                ->required();
            $form->divider();
            $form->text('asset_number');
            $form->text('description');
            $form->select('purchased_channel_id', admin_trans_label('Purchased Channel Id'))
                ->options(PurchasedChannel::all()
                    ->pluck('name', 'id'));
            $form->text('sn');
            $form->currency('price');
            $form->date('purchased');
            $form->date('expired');
            $form->select('depreciation_rule_id', admin_trans_label('Depreciation Rule Id'))
                ->options(DepreciationRule::all()
                    ->pluck('name', 'id'));
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
