<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerUnit extends Model
{
    protected $table = 'owner_unit';

    public function rentConfigurations()
    {
        return $this->hasMany(Rent::class, 'unit_id');
    }
}
