<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;
use Spatie\Permission\Models\Permission as Model;

class Permission extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $hidden = ['id'];
    protected $appends = ['hashid'];
}
