<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationOption extends Model
{
    use HasFactory;

    protected $fillable = ['variation_id','value','sku','price_modifier','stock'];

    protected $casts = [
        'price_modifier' => 'decimal:2'
    ];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}