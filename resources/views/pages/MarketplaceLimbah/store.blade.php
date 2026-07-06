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
                            <div class="w-full h-full bg-brand text-white flex items-center justify-center text-4xl font-bold">
                                {{ strtoupper(substr($user->sellerProfile->business_name ?? $user->name, 0, 2)) }}
                            </div>
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
                            @auth
                            <form method="POST" action="{{ route('conversations.start', $user->id) }}">
                                @csrf
                                <button type="submit" class="bg-brand hover:bg-brand-hover text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                    Chat Penjual
                                </button>
                            </form>
                            @else
                            <button type="button" onclick="showToast('Anda harus login terlebih dahulu untuk melakukan chat.')" class="bg-brand hover:bg-brand-hover text-white font-semibold text-sm px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                                Chat Penjual
                            </button>
                            @endauth
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
                            <a href="{{ route('marketplace.store', $user->id) }}" class="block px-4 py-2.5 rounded-lg {{ !isset($tab) || $tab !== 'terjual' ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }} text-sm">Semua Produk</a>
                        </li>
                        <li>
                            <a href="{{ route('marketplace.store', ['user' => $user->id, 'tab' => 'terjual']) }}" class="block px-4 py-2.5 rounded-lg {{ isset($tab) && $tab === 'terjual' ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }} text-sm">Produk Terjual</a>
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Main Products Grid --}}
            <div class="flex-1 min-w-0">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <h2 class="text-xl font-bold text-gray-900">{{ isset($tab) && $tab === 'terjual' ? 'Produk Terjual' : 'Semua Produk' }}</h2>
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
                    <p class="text-gray-500 font-medium">{{ isset($tab) && $tab === 'terjual' ? 'Toko ini belum memiliki produk terjual.' : 'Toko ini belum memiliki produk limbah.' }}</p>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($listings as $l)
                    <a href="{{ route('marketplace.show', $l->id) }}?ref=store" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col">
                        <div class="relative h-52 bg-gray-100 shrink-0 overflow-hidden">
                            <img src="{{ $l->primaryImage ? (str_starts_with($l->primaryImage->image_url, 'http') ? $l->primaryImage->image_url : asset('storage/'.$l->primaryImage->image_url)) : '' }}" alt="{{ $l->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <span class="absolute top-3 left-3 bg-brand text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">{{ $l->category->category_name ?? 'Limbah' }}</span>
                        </div>
                        <div class="p-4 flex flex-col grow">
                            <h5 class="text-base font-bold text-gray-900 line-clamp-2 leading-snug mb-1 group-hover:text-brand transition-colors">{{ $l->title }}</h5>
                            <div class="flex items-center gap-1 text-xs text-gray-400 mb-4">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $l->city }}</span>
                            </div>
                            <div class="grow"></div>
                            <div class="flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-xl font-bold text-brand leading-tight">
                                        Rp {{ number_format($l->price_per_unit, 0, ',', '.') }} <span class="text-xs font-normal text-gray-400">/ {{ $l->unit }}</span>
                                    </p>
                                    <div class="flex items-center gap-1 text-xs text-gray-400 mt-0.5">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                        Stok: {{ number_format($l->quantity, 0, ',', '.') }} {{ $l->unit }}
                                    </div>
                                </div>
                                <span class="shrink-0 text-xs font-semibold border border-gray-200 text-gray-600 group-hover:bg-brand group-hover:text-white group-hover:border-brand px-4 py-1.5 rounded-lg transition-all">Detail</span>
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
