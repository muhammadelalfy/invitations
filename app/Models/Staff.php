<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'position',
        'user_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guestAssignments(): HasMany
    {
        return $this->hasMany(StaffAssignment::class);
    }

    public function assignedGuests(): HasMany
    {
        return $this->hasMany(Guest::class, 'assigned_staff_id');
    }
}
