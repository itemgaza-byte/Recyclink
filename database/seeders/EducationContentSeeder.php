<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EducationContent;
use App\Models\User;
use Illuminate\Support\Str;

class EducationContentSeeder extends Seeder
{
    public function run()
    {
        // Temukan admin untuk dikaitkan dengan konten (ambil user pertama jika tidak spesifik)
        $admin = User::first(); 
        $adminId = $admin ? $admin->id : 1;

        $contents = [
            // Artikel
            [
                'title' => 'Cara Memilah Sampah Plastik Industri',
                'content_type' => 'article',
                'excerpt' => 'Panduan dasar cara memilah plastik industri agar nilai jualnya tetap tinggi di pasaran.',
                'content' => '<p>Pemisahan plastik berdasarkan jenisnya (PET, HDPE, PVC, dll) sangat penting untuk menjaga kualitas daur ulang. Artikel ini membahas cara mengidentifikasi jenis plastik di lapangan.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Potensi Ekonomi Sirkular di Indonesia 2026',
                'content_type' => 'article',
                'excerpt' => 'Memahami bagaimana ekonomi sirkular dapat memberikan keuntungan bagi perusahaan manufaktur.',
                'content' => '<p>Ekonomi sirkular bukan hanya tentang lingkungan, tapi juga efisiensi biaya produksi. Perusahaan besar kini mulai mencari bahan baku dari limbah daur ulang lokal.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&q=80&w=800',
            ],
            
            // Video
            [
                'title' => 'Video: Proses Daur Ulang Logam Berat',
                'content_type' => 'video',
                'excerpt' => 'Saksikan bagaimana logam berat didaur ulang menjadi bahan baku siap pakai dalam industri.',
                'content' => '<p>Dalam video ini kami menunjukkan alur dari peleburan hingga pencetakan logam, serta alat-alat keselamatan kerja yang wajib dikenakan.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1504917595217-d4bf597b8196?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Webinar: Tren Harga Limbah Kertas & Kardus',
                'content_type' => 'video',
                'excerpt' => 'Diskusi panel mengenai prediksi harga limbah kardus tahun ini dan peluang ekspor.',
                'content' => '<p>Bersama para pakar daur ulang, kita membahas fluktuasi harga pasar limbah dan bagaimana cara menjaga kualitas kertas baling.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1516382799247-87df95d790b7?auto=format&fit=crop&q=80&w=800',
            ],

            // Panduan
            [
                'title' => 'Panduan K3 dalam Pengelolaan Limbah B3',
                'content_type' => 'guide',
                'excerpt' => 'Langkah-langkah operasional standar keselamatan kerja dalam menangani limbah berbahaya.',
                'content' => '<p>Kesehatan dan Keselamatan Kerja (K3) adalah prioritas utama saat bersentuhan dengan limbah B3. Berikut adalah checklist alat pelindung diri (APD) yang wajib disediakan perusahaan.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'title' => 'Manual Pengemasan Limbah Ekspor (Baling)',
                'content_type' => 'guide',
                'excerpt' => 'Cara melakukan baling limbah sesuai dengan standar ekspor internasional dan pelabuhan.',
                'content' => '<p>Untuk mengekspor limbah kertas/kardus, mesin baling harus diatur pada tekanan tertentu agar memenuhi spesifikasi kontainer pengiriman. Panduan ini menjelaskan metrik yang diwajibkan oleh bea cukai.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1603533867307-b354255e4c32?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($contents as $data) {
            EducationContent::create([
                'admin_id' => $adminId,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'content' => $data['content'],
                'excerpt' => $data['excerpt'],
                'thumbnail_url' => $data['thumbnail_url'],
                'content_type' => $data['content_type'],
                'status' => 'published',
                'published_at' => now(),
                'view_count' => rand(15, 200),
                'is_featured' => false,
            ]);
        }
    }
}
