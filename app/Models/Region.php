<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable =['name','zone_id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);

    }
}
