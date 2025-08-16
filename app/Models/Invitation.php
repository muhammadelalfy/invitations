<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'event_date', 'template_id',
        'created_by', 'status', 'qr_code', 'whatsapp_message'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function staffAssignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }
}
