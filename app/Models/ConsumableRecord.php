<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumableRecord extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'consumable_records';

    public function category(): HasOne
    {
        return $this->hasOne(ConsumableCategory::class, 'id', 'category_id');
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(VendorRecord::class, 'id', 'vendor_id');
    }
}
