<?php

namespace App\Models;

use App\Models\User;
use App\Models\CostCenter;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'service_provider',
        'service_name',
        'details',
        'status',
        'approved_by',
        'assigned',
        'service_rating',
        'additional_field',
        'e_signature',
        'date_served',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedPersonnel()
    {
        return $this->belongsTo(User::class, 'assigned');
    }

    
}
