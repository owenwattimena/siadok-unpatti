<?php

namespace App\Models;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'cities';

    /**
     * Get all of the alumni for the Lokasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumni()
    {
        // return $this->hasMany(Alumni::class, 'lokasi_id', 'id');
    }
}
