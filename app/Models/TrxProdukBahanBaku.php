<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\BahanBaku;


class TrxProdukBahanBaku extends Model
{
    use HasFactory;
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
