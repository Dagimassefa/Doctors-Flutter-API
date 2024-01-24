<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    use HasFactory;

    protected $fillable =['name','division_id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function unions()
    {
        return $this->hasMany(Union::class);
    }
}
