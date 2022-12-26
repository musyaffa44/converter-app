<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\TrxProdukBahanBaku;

class BahanBaku extends Model
{
    use HasFactory;
    public function produk()
    {
        return $this->hasMany(TrxProdukBahanBaku::class);
    }
}
