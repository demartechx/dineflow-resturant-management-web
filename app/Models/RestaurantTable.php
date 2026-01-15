<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $fillable = [
        'number',
        'qr_code_string',
        'capacity',
        'zone',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($table) {
            if (empty($table->qr_code_string)) {
                $table->qr_code_string = \Illuminate\Support\Str::uuid()->toString();
            }
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'restaurant_table_id');
    }
}
