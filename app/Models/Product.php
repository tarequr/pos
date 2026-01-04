<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Branch;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'branch_id',
        'serial_no',
        'status',
        'stock_in_by',
        'stock_in_date',
        'stock_out_by',
        'stock_out_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeInStock($query)
    {
        return $query->where('products.status', 'stock_in');
    }

    public function scopeStockOut($query)
    {
        return $query->where('products.status', 'stock_out');
    }
}
