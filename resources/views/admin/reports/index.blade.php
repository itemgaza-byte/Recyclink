@extends('admin.layouts.admin')

@section('title', 'Laporan Analisis - Admin Recyclink')
@section('header_title', 'Laporan Analisis')

@section('content')
<div class="mb-8">
    <h3 class="text-2xl font-bold text-gray-900">Pusat Laporan & Analisis</h3>
    <p class="text-gray-600 mt-1">Pilih jenis laporan yang ingin Anda akses atau saring.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Card 1: Transaksi -->
    <a href="{{ route('admin.reports.transactions') }}" class="group bg-white border border-gray-200 hover:border-brand rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                <i data-lucide="line-chart" class="w-6 h-6"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-lg">Laporan Transaksi</h4>
            <p class="text-gray-500 text-sm mt-2">Pantau volume transaksi, pendapatan platform, status pembayaran, dan riwayat pesanan.</p>
        </div>
        <div class="mt-6 flex items-center gap-1.5 text-brand font-bold text-sm">
            Buka Laporan <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
        </div>
    </a>

    <!-- Card 2: Produk/Limbah -->
    <a href="{{ route('admin.reports.listings') }}" class="group bg-white border border-gray-200 hover:border-brand rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-lg">Laporan Produk / Limbah</h4>
            <p class="text-gray-500 text-sm mt-2">Analisis data persebaran produk limbah, kuantitas stok terdaftar, dan status verifikasi.</p>
        </div>
        <div class="mt-6 flex items-center gap-1.5 text-brand font-bold text-sm">
            Buka Laporan <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
        </div>
    </a>

    <!-- Card 3: Pengguna -->
    <a href="{{ route('admin.reports.users') }}" class="group bg-white border border-gray-200 hover:border-brand rounded-2xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
        <div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-105 transition-transform">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <h4 class="font-bold text-gray-900 text-lg">Laporan Pengguna</h4>
            <p class="text-gray-500 text-sm mt-2">Pantau perkembangan pendaftaran akun, perbandingan peran penjual/pembeli, dan status aktif.</p>
        </div>
        <div class="mt-6 flex items-center gap-1.5 text-brand font-bold text-sm">
            Buka Laporan <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
        </div>
    </a>
</div>
@endsection
