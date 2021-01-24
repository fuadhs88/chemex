<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumableTrack extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'consumable_tracks';

    public function consumable(): HasOne
    {
        return $this->hasOne(ConsumableRecord::class, 'id', 'consumable_id');
    }
}
