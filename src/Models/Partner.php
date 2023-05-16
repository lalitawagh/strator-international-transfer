<?php

namespace Kanexy\InternationalTransfer\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Partner extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'title_id',
        'company',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'country_code',
        'country_id',
        'password',
        'webhook_url',
        'status'
    ];

    public function getFullNameAttribute()
    {
        return implode(' ', [$this->first_name, $this->middle_name, $this->last_name]);
    }
}
