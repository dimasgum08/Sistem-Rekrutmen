<?php

namespace App\Models;

use Mtvs\EloquentHashids\HasHashid;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HashidRouting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interview extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $hidden = ['id'];
    protected $appends = ['hashid'];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'interviewer_id','id');
    }
}
