<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone_number', 'invitation_id',
        'assigned_staff_id', 'status', 'arrival_time'
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
    ];

    public function invitation()
    {
        return $this->belongsTo(Invitation::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function assignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }
}
