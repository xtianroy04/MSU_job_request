<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceType extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['name'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
}
