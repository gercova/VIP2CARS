<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehiculos';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
}