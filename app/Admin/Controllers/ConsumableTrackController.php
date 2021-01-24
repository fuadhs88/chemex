<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ConsumableTrack;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class ConsumableTrackController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ConsumableTrack(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('consumable_id');
            $grid->column('staff_id');
            $grid->column('number');
            $grid->column('purchased');
            $grid->column('expired');
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
    protected function detail($id)
    {
        return Show::make($id, new ConsumableTrack(), function (Show $show) {
            $show->field('id');
            $show->field('consumable_id');
            $show->field('staff_id');
            $show->field('number');
            $show->field('purchased');
            $show->field('expired');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ConsumableTrack(), function (Form $form) {
            $form->display('id');
            $form->text('consumable_id');
            $form->text('staff_id');
            $form->text('number');
            $form->text('purchased');
            $form->text('expired');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
