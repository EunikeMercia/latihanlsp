<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\TransactionDetail;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCategory(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function detail(){
        return $this->hasMany(TransactionDetail::class);
    }
}
