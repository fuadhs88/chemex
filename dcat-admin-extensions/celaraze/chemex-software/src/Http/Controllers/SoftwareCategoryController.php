<?php

namespace Celaraze\Chemex\Software\Http\Controllers;

use Celaraze\Chemex\Software\Actions\Tree\ToolAction\SoftwareCategoryImportAction;
use Celaraze\Chemex\Software\Repositories\SoftwareCategory;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Tree;
use Dcat\Admin\Widgets\Tab;
use Illuminate\Http\Request;

class SoftwareCategoryController extends AdminController
{
    public function selectList(Request $request)
    {
        $q = $request->get('q');
        return \Celaraze\Chemex\Software\Models\SoftwareCategory::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    public function index(Content $content): Content
    {
        return $content
            ->title($this->title())
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $tab = new Tab();
                $tab->addLink('软件', route('software.records.index'));
                $tab->add('分类', $this->treeView(), true);
                $tab->addLink('归属', route('software.tracks.index'));
                $row->column(12, $tab->withCard());
            });
    }

    protected function treeView(): Tree
    {
        return new Tree(new \Celaraze\Chemex\Software\Models\SoftwareCategory(), function (Tree $tree) {
            $tree->tools(function (Tree\Tools $tools) {
                $tools->add(new SoftwareCategoryImportAction());
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
        return Grid::make(new SoftwareCategory(['parent']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('name');
            $grid->column('description');
            $grid->column('parent.name');

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
        return Show::make($id, new SoftwareCategory(['parent']), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('description');
            $show->field('parent.name');
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
        return Form::make(new SoftwareCategory(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('description');

            if (\App\Support\Support::ifSelectCreate()) {
                $form->selectCreate('parent_id')
                    ->options(\Celaraze\Chemex\Software\Models\SoftwareCategory::class)
                    ->ajax(route('selection.software.categories'))
                    ->url(route('software.categories.create'));
            } else {
                $form->select('parent_id')
                    ->options(\Celaraze\Chemex\Software\Models\SoftwareCategory::all()
                        ->pluck('name', 'id'));
            }

            $form->display('created_at');
            $form->display('updated_at');

            $form->disableCreatingCheck();
            $form->disableEditingCheck();
            $form->disableViewCheck();
        });
    }
}
