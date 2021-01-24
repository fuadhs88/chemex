<?php

namespace App\Admin\Repositories;

use App\Models\PartRecord as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class PartRecord extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
