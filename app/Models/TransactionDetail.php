<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
    public function getItem(){
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
