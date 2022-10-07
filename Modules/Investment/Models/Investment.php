<?php

namespace Modules\Investment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'investable_cash'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Investment\Database\factories\InvestmentFactory::new();
    }
}
