<?php

namespace Celaraze\Chemex\Consumable\Http\Controllers;

use App\Models\VendorRecord;
use Celaraze\Chemex\Consumable\Actions\Grid\ToolAction\ConsumableInAction;
use Celaraze\Chemex\Consumable\Actions\Grid\ToolAction\ConsumableOutAction;
use Celaraze\Chemex\Consumable\Models\ConsumableCategory;
use Celaraze\Chemex\Consumable\Repositories\ConsumableRecord;
use Celaraze\Chemex\Consumable\Support;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Widgets\Tab;

class ConsumableRecordController extends AdminController
{
    public function index(Content $content): Content
    {
        return $content
            ->title($this->title())
            ->description(trans('admin.list'))
            ->body(function (Row $row) {
                $tab = new Tab();
                $tab->add('耗材', $this->grid(), true);
                $tab->addLink('分类', route('consumable.categories.index'));
                $tab->addLink('记录', route('consumable.tracks.index'));
                $row->column(12, $tab->withCard());
            });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        return Grid::make(new ConsumableRecord(['category', 'vendor']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('name');
            $grid->column('description');
            $grid->column('specification');
            $grid->column('category.name');
            $grid->column('vendor.name');
            $grid->column('price');
            $grid->column('number')->display(function () {
                return Support::consumableAllNumber($this->id);
            });

            $grid->toolsWithOutline(false);

            $grid->tools([
                new ConsumableInAction(),
                new ConsumableOutAction()
            ]);

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
            $form->text('name')
                ->required();
            $form->text('description');
            $form->text('specification')
                ->required();
            $form->select('category_id', admin_trans_label('Category Id'))
                ->options(ConsumableCategory::all()
                    ->pluck('name', 'id'))
                ->required();
            $form->select('vendor_id', admin_trans_label('Vendor Id'))
                ->options(VendorRecord::all()
                    ->pluck('name', 'id'))
                ->required();
            $form->text('price');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
