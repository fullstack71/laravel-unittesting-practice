<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','type','value','starts_at','ends_at'];

    protected $dates = ['starts_at','ends_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}