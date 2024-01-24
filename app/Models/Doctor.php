<?php

namespace App\Models;

use App\Notifications\DoctorResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth as Authenticatable;

class Doctor extends Model implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_no',
        'email',
        'gender',
        'password',
        'zone_id',
        'region_id',
        'branch_id',
        'district_id',
        'division_id',
        'thana_id',
        'union_id',
    ];

    protected $hidden = ['password'];
    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate');
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
    public function sendPasswordResetNotification($token)
    {
        // Send password reset notification to the doctor via email
        $this->notify(new DoctorResetPasswordNotification($token));
    }

    public function availability()
    {
        return $this->hasMany(Availability::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }

    public function union()
    {
        return $this->belongsTo(Union::class);
    }
}
