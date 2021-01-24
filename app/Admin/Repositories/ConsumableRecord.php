<?php

namespace App\Admin\Repositories;

use App\Models\ConsumableRecord as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ConsumableRecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
