<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use HasFactory;

    protected $fillable = [
        'nit',
        'name',
        'address',
        'phone',
        'status',
    ];

    public const DEFAULT_PAGINATION_SIZE = 10;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->status)) {
                $company->status = 'active';
            }
        });
    }
}
