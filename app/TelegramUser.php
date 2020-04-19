<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $table = 'telegram_users';

    protected $fillable = ['id', 'current_action', 'updated_at'];

    public function getCurrentActionAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setCurrentActionAttribute($value)
    {
        if (is_string($value))
        {
            $this->attributes['current_action'] = $value;
        }
        else if (is_array($value))
        {
            $this->attributes['current_action'] = json_encode($value);
        }
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->current_action = '{}';
        });
    }
}
