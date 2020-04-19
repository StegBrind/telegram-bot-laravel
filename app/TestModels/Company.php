<?php

namespace App\TestModels;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';

    protected $fillable = ['name', 'description', 'is_active'];
}
