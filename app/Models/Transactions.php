<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected  $fillable = [
        'trans_name',
        'user_id',
        'category_id',
        'price',
        'description',
        'is_income',
        'trans_date'
    ];

    protected $table = 'transactions';
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
