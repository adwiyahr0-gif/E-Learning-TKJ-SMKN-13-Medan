<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = ['judul', 'deskripsi', 'jenis', 'url', 'file_path', 'user_id'];

    /** Link embed YouTube (null kalau bukan video YouTube / link tidak valid). */
    public function getEmbedUrlAttribute(): ?string
    {
        if ($this->jenis !== 'youtube' || !$this->url) {
            return null;
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{11})~', $this->url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return null;
    }

    /** Alamat file MP4 yang diunggah (null kalau tidak ada). */
    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}