<?php

namespace App\Models;
use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['name','ip', 'port'];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

}
