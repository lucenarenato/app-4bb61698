<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'historics';

    protected $primaryKey = 'id';

    protected $fillable = ['sku', 'quantity', 'qtd', 'productID'];

    protected $dates = ['created_at', 'updated_at'];
}
