<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    public function fwa_requests(){
        return $this->hasMany(FWARequest::class);
    }
    public function supervisor(){
        return $this->belongsTo(Employee::class,'supervisor_employee_id');
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function supervised_employee(){
        return $this->hasMany(Employee::class,'supervisor_employee_id');
    }

    public function daily_schedules(){
        return $this->hasMany(DailySchedule::class);
    }

    public function role(){
        $role = "employee";
        if($this->supervised_employee()->count() > 0){
            $role = "supervisor";
        }
        return $role;
    }
}
