<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $fillable = ['nama_kategori'];

    public function alat(): HasMany {
        return $this->hasMany(Alat::class);
    }
}
