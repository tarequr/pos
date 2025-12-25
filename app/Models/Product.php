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
        'name',
        'serial_no',
        'status',
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
        return $query->where('status', 'active');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }
}
