<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductRule;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'internal_external',
        'width',
        'length',
        'height',
        'image',
        'color',
        'quantity',
        'length_units',
        'fitment_time',
        'included_or_optional',
        'depends_on_products',
    ];

    public function productRules()
    {
        return ProductRule::whereJsonContains('allowed_products', $this->id)->get();
    }
}
