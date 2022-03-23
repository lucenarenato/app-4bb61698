<?php

namespace App\Models;

use BinaryCats\Sku\HasSku;
use BinaryCats\Sku\Concerns\SkuOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Products extends Model
{
    use HasSku;
    use SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'sku', 'quantity', 'price', 'description', 'arbitrary_sku_field_name'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Get the options for generating the Sku.
     *
     * @return BinaryCats\Sku\SkuOptions
     */
    public function skuOptions(): SkuOptions
    {
        return SkuOptions::make()
            ->from(['id', 'name'])
            ->target('arbitrary_sku_field_name')
            ->using('_')
            ->forceUnique(false)
            ->generateOnCreate(true)
            ->refreshOnUpdate(false);
    }
}
