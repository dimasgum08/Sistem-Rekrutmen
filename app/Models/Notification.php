<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class Notification extends Model
{
     use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $hidden = ['id'];
    protected $appends = ['hashid'];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }
    public function fromRole()
    {
        return $this->belongsTo(Role::class, 'from_role_id');
    }
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
    public function toRole()
    {
        return $this->belongsTo(Role::class, 'to_role_id');
    }
}
