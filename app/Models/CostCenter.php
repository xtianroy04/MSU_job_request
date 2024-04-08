<?php

namespace App\Models;

use App\Models\User;
use App\Models\Service;
use App\Models\CostCenter;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostCenter extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['name', 'code'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($costCenter) {
            $lastCostCenter = self::orderBy('id', 'desc')->first();
            $code = $costCenter->name . '-' . str_pad(optional($lastCostCenter)->id + 1, 4, '0', STR_PAD_LEFT);
            $costCenter->code = $code;
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'cost_center_id');
    }
}
