<?php

namespace Kanexy\InternationalTransfer\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Partner extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

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
        'kyc_url',
        'status'
    ];

    public function getFullNameAttribute()
    {
        return implode(' ', [$this->first_name, $this->middle_name, $this->last_name]);
    }

    public function getFullName()
    {
        return implode(' ', [$this->first_name, $this->middle_name, $this->last_name]);
    }

    public function notifyThroughWebhook(array $data)
    {
        
        Log::info(json_encode(['data' => $data, 'partner' => $this->toArray()]));
        //$url = 'https://events.hookdeck.com/e/src_0ayzCad3MHBl';
        $url = $this->webhook_url;
        if (is_null($url)) { return; }

        try {
            Http::post($url, $data);
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }
    }
}
