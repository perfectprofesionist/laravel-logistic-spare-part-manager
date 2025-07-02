<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class ProductRule extends Model
{
    use HasFactory;

    protected $table = 'product_rules';

    protected $primaryKey = 'id';

    public $timestamps = true; // Laravel will manage created_at and updated_at automatically

    protected $fillable = [
        'allowed_products',
        'max_total',
    ];

   

    protected $casts = [
        'allowed_products' => 'array', // or 'array' if you plan to store JSON
        'max_total' => 'integer',
    ];

    public function allowedProducts()
    {
        return Product::whereIn('id', $this->allowed_products)->get();
    }
}