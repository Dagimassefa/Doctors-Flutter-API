<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;
    protected $fillable =['file','doctor_id','college','degree','years','specialization','reg_no','reg_doc'];

    protected function file(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => file_exists(public_path().'/files/'.$value) && $value ? asset('files/'.$value) :null ,
        );
    }
}
