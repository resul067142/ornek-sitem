<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EpostaDogrulama extends Model
{
    use HasFactory;

    public function getUye()
    {
        return $this->hasOne(Uyeler::class, 'id', 'uyeler_id');
    }
}
