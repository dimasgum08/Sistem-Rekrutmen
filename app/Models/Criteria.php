<?php

namespace App\Models;

use Mtvs\EloquentHashids\HasHashid;
use Illuminate\Database\Eloquent\Model;
use Mtvs\EloquentHashids\HashidRouting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Criteria extends Model
{
    use HasFactory, HasHashid, HashidRouting;

    protected $guarded = [];
    protected $hidden = ['id'];
    protected $appends = ['hashid'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function documents()
    {
        return $this->hasOne(Document::class);
    }

    public function criterias()
    {
        return $this->hasMany(Criteria::class);
    }

    public function interview()
    {
        return $this->hasOne(Interview::class);
    }
}
