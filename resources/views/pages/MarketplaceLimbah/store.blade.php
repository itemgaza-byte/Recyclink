@extends('layouts.master')
@section('title', 'Toko ' . ($user->sellerProfile->business_name ?? $user->name) . ' - Recyclink')
@section('content')
<div class="bg-gray-50 min-h-screen pb-20">
    {{-- Tabs Navigation --}}
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-20 hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="-mb-px flex gap-8" aria-label="Tabs">
                <button class="border-brand text-brand border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2">
                    Produk
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-1 text-sm font-medium flex items-center gap-2 transition-colors">
                    Ulasan
                </button>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Store Header Profile --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full overflow-hidden border border-gray-100 shrink-0 shadow-sm relative">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->sellerProfile->business_name ?? $user->name) }}&background=14b8a6&color=fff" alt="{{ $user->name }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute bottom-0 right-0 bg-brand text-white rounded-full p-1 border-2 border-white">
                            <i data-lucide="star" class="w-3 h-3 fill-white"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900 mb-1 flex items-center gap-2">
                            {{ $user->sellerProfile->business_name ?? $user->name }}
                        </h1>
                        <p class="text-sm text-gray-500 flex items-center gap-1.5 mb-4">
                            {{ $user->sellerProfile->city ?? 'Lokasi tidak diketahui' }}
                        </p>
                        <div class="flex flex-wrap gap-2 md:gap-3">
                            <button class="bg-brand hover:bg-brand-hover text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                Chat Penjual
                            </button>
                            <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg transition-colors flex items-center justify-center">
                                <i data-lucide="store" class="w-4 h-4"></i>
                            </button>
                            <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded-lg transition-colors flex items-center justify-center">
                                <i data-lucide="share-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Store Content --}}
        <div class="flex flex-col lg:flex-row gap-8 mt-6">
            {{-- Left Sidebar --}}
            <aside class="w-full lg:w-64 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-32">
                    <div class="p-4 border-b border-gray-100 bg-white">
                        <h3 class="font-bold text-gray-900">Etalase Toko (2)</h3>
                    </div>
                    <ul class="p-2 space-y-1 bg-white">
                        <li>
                            <a href="#" class="block px-4 py-2.5 rounded-lg bg-gray-100 text-gray-900 font-semibold text-sm">Semua Produk</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2.5 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors font-medium text-sm">Produk Terjual</a>
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Main Products Grid --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Semua Produk</h2>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="text-sm text-gray-500">Urutkan:</span>
                        <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition cursor-pointer">
                            <option>Terbaru</option>
                            <option>Harga Tertinggi</option>
                            <option>Harga Terendah</option>
                        </select>
                    </div>
                </div>

                @if($listings->isEmpty())
                <div class="text-center py-20 bg-white border border-gray-200 border-dashed rounded-2xl">
                    <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <i data-lucide="package-x" class="w-8 h-8 text-gray-300"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Toko ini belum memiliki produk limbah.</p>
                </div>
                @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($listings as $l)
                    <a href="{{ route('marketplace.show', $l->id) }}" class="group bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col">
                        <div class="relative h-44 bg-gray-100 shrink-0 overflow-hidden">
                            <img src="{{ $l->primaryImage ? $l->primaryImage->url : '' }}" alt="{{ $l->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            {{-- Promo Badge like in Tokopedia --}}
                            <div class="absolute top-0 left-0 bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-br-lg z-10">
                                >50%
                            </div>
                        </div>
                        <div class="p-3 flex flex-col grow">
                            <h5 class="text-sm text-gray-700 line-clamp-2 leading-snug mb-1 group-hover:text-brand transition-colors">{{ $l->title }}</h5>
                            <p class="text-base font-bold text-gray-900 mt-1">Rp {{ number_format($l->price_per_unit, 0, ',', '.') }}</p>
                            
                            {{-- Fake Promo --}}
                            <div class="flex items-center gap-1 mt-1">
                                <span class="bg-rose-100 text-rose-500 text-[9px] font-bold px-1 rounded">Hemat s.d 15%</span>
                            </div>

                            <div class="flex items-center gap-1 text-[11px] text-gray-500 mt-2">
                                {{ $l->sold_quantity ?? 0 }} terjual
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
