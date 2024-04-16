<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getDetail(){
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }
}
