<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Device;

class Log extends Model
{
    protected $fillable = ['device_id','uid', 'timestamp'];
    public $timestamps = false;

    public function logs()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }
}
