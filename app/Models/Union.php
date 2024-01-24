<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    use HasFactory;
    protected $fillable =['name','thana_id'];

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }
}
