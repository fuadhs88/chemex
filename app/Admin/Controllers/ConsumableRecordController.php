<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ConsumableRecord;
use App\Models\ConsumableCategory;
use App\Models\VendorRecord;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class ConsumableRecordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new ConsumableRecord(['category', 'vendor']), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('description');
            $grid->column('specification');
            $grid->column('category.name');
            $grid->column('vendor.name');
            $grid->column('price');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
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
        return Show::make($id, new ConsumableRecord(['category', 'vendor']), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('description');
            $show->field('specification');
            $show->field('category.name');
            $show->field('vendor.name');
            $show->field('price');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make(new ConsumableRecord(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('description');
            $form->text('specification')->required();
            $form->select('category_id')
                ->options(ConsumableCategory::all()
                    ->pluck('name', 'id'))
                ->required();
            $form->select('vendor_id')
                ->options(VendorRecord::all()
                    ->pluck('name', 'id'))
                ->required();
            $form->text('price');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
