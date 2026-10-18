<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soals';

    protected $fillable = [
        'tipe', 'pertanyaan',
        'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d',
        'jawaban_benar', 'kunci_essay', 'urutan', 'user_id',
    ];

    public function isPilihanGanda(): bool
    {
        return $this->tipe === 'pilihan_ganda';
    }
}