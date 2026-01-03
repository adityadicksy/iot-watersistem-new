<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model
{
    use HasFactory;

    // Ini kuncinya: Kita mengizinkan kolom-kolom ini diisi data
    protected $fillable = [
        'tds_value',
        'water_level',
        'door_status',
    ];
}
