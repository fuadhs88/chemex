<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Tree\ToolAction\PartCategoryImportAction;
use App\Admin\Repositories\PartCategory;
use App\Models\DepreciationRule;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Tree;

class PartCategoryController extends AdminController
{
    public function index(Content $content): Content
    {
        return $content
            ->title($this->title())
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $row->column(12, $this->treeView());
            });
    }

    protected function treeView(): Tree
    {
        return new Tree(new \App\Models\PartCategory(), function (Tree $tree) {
            $tree->tools(function (Tree\Tools $tools) {
                $tools->add(new PartCategoryImportAction());
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new PartCategory(['parent', 'depreciation']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('name');
            $grid->column('description');
            $grid->column('parent.name');
            $grid->column('depreciation.name');

            $grid->enableDialogCreate();

            $grid->toolsWithOutline(false);

            $grid->quickSearch('id', 'name', 'description')
                ->placeholder('试着搜索一下')
                ->auto(false);
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
        return Show::make($id, new PartCategory(['parent', 'depreciation']), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('description');
            $show->field('parent.name');
            $show->field('depreciation.name');
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
        return Form::make(new PartCategory(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('description');
            $form->select('parent_id', admin_trans_label('Parent'))
                ->options(\App\Models\PartCategory::all()
                    ->pluck('name', 'id'));
            $form->select('depreciation_rule_id', admin_trans_label('Depreciation Rule Id'))
                ->options(DepreciationRule::all()
                    ->pluck('name', 'id'));
            $form->display('created_at');
            $form->display('updated_at');

            $form->disableCreatingCheck();
            $form->disableEditingCheck();
            $form->disableViewCheck();
        });
    }
}
