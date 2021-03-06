<?php

namespace Celaraze\Chemex\Consumable\Actions\Tree\ToolAction;

use Celaraze\Chemex\Consumable\Forms\ConsumableCategoryImportForm;
use Dcat\Admin\Tree\AbstractTool;
use Dcat\Admin\Widgets\Modal;

class ConsumableCategoryImportAction extends AbstractTool
{
    protected $title = '导入';

    /**
     * 渲染模态框
     * @return Modal|string
     */
    public function render()
    {

        return Modal::make()
            ->lg()
            ->body(new ConsumableCategoryImportForm())
            ->button("<a class='btn btn-sm btn-success' style='color: white;'><i class='feather icon-package'></i>&nbsp;$this->title</a>");
    }
}
