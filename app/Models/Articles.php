<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    // Menentukan kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'slug',
        'title',
        'image_url',
        'keywords',
        'meta_description',
        'content',
        'excerpt',
        'published_at',
        'author',
        'is_featured',
        'read_time',
    ];

    // Menentukan kolom yang tidak boleh diisi (mass assignable)
    protected $guarded = [];

    // Menentukan tipe data untuk kolom tertentu
    protected $casts = [
        'published_at' => 'datetime',  // Pastikan 'published_at' di-cast ke tipe data datetime
        'is_featured' => 'boolean',    // Pastikan 'is_featured' di-cast ke tipe data boolean
        'read_time' => 'integer',     // Pastikan 'read_time' di-cast ke tipe data integer
    ];

    // Fungsi untuk mendapatkan waktu baca artikel dalam menit
    public function calculateReadTime()
    {
        $wordCount = str_word_count(strip_tags($this->content)); // Menghitung jumlah kata tanpa tag HTML
        $readTime = ceil($wordCount / 200); // Mengasumsikan rata-rata 200 kata per menit
        return $readTime;
    }
}