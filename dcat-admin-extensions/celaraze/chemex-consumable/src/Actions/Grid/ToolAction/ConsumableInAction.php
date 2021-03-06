<?php

namespace Celaraze\Chemex\Consumable\Actions\Grid\ToolAction;

use Celaraze\Chemex\Consumable\Forms\ConsumableInForm;
use Dcat\Admin\Grid\Tools\AbstractTool;
use Dcat\Admin\Widgets\Modal;

class ConsumableInAction extends AbstractTool
{
    protected $title = '入库';

    /**
     * 渲染模态框
     * @return Modal|string
     */
    public function render()
    {
        return Modal::make()
            ->lg()
            ->body(new ConsumableInForm())
            ->button("<a class='btn btn-success' style='color: white;'><i class='feather icon-package'></i>&nbsp;$this->title</a>");
    }
}
