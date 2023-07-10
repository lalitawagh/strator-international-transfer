<?php

namespace Kanexy\InternationalTransfer\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CcCurrencyConversion extends Model
{
    use HasFactory;

    protected $table_name = 'cc_currency_conversions';

    protected $fillable = [
        'holder_type',
        'holder_id',
        'currency',
        'balance',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function holder()
    {
        return $this->morphTo();
    }

    public function scopeForHolder($query, Model $model)
    {
        return $query->where(['holder_id' => $model->getKey(), 'holder_type' => $model->getMorphClass()]);
    }
}
