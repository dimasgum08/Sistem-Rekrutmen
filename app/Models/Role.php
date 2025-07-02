<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;
class Role extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $hidden = ['id'];
    protected $appends = ['hashid'];

}
