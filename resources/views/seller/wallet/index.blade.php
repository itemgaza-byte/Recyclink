@extends('seller.layouts.seller')

@section('title', 'Dompet Saya - Seller Recyclink')
@section('header_title', 'Dompet Saya')

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h3 class="text-2xl font-bold text-gray-900">Dompet Digital</h3>
        <p class="text-gray-600 mt-1">Kelola pendapatan dari penjualan limbah daur ulang Anda.</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('seller.withdrawals.create') }}" class="px-5 py-2.5 bg-brand hover:bg-brand-hover text-white text-sm font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
            <i data-lucide="arrow-up-right" class="w-4 h-4"></i> Tarik Saldo
        </a>
        <a href="{{ route('seller.withdrawals.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:border-brand hover:text-brand text-gray-700 text-sm font-bold rounded-xl transition-all flex items-center gap-2">
            <i data-lucide="history" class="w-4 h-4"></i> Riwayat Penarikan
        </a>
    </div>
</div>

{{-- Balance Overview Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Balance Card -->
    <div class="md:col-span-2 bg-gradient-to-br from-brand to-brand-hover text-white rounded-3xl p-8 shadow-md relative overflow-hidden flex flex-col justify-between min-h-[180px]">
        <div class="absolute right-0 bottom-0 opacity-10 translate-x-4 translate-y-4">
            <i data-lucide="wallet" class="w-44 h-44"></i>
        </div>
        <div>
            <p class="text-white/80 text-xs font-bold uppercase tracking-wider">Saldo Utama</p>
            <h2 class="text-3xl font-extrabold mt-2">Rp {{ number_format((float)($wallet->balance ?? 0), 0, ',', '.') }}</h2>
        </div>
        <p class="text-xs text-white/70 mt-6 flex items-center gap-1.5"><i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Saldo dapat ditarik kapan saja.</p>
    </div>

    <!-- Stats Card: Pending Balance -->
    <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm flex items-start gap-4">
        <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
            <i data-lucide="clock" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold">Saldo Tertunda</p>
            <h4 class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format((float)($wallet->pending_balance ?? 0), 0, ',', '.') }}</h4>
            <p class="text-[10px] text-gray-400 mt-1.5">Dana ditahan selama proses pengiriman.</p>
        </div>
    </div>

    <!-- Stats Card: Total Withdrawn -->
    <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-sm flex items-start gap-4">
        <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
            <i data-lucide="arrow-down" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold">Total Ditarik</p>
            <h4 class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format((float)($wallet->total_withdrawn ?? 0), 0, ',', '.') }}</h4>
            <p class="text-[10px] text-gray-400 mt-1.5">Total dana yang berhasil ditarik ke rekening.</p>
        </div>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
        <h4 class="font-bold text-gray-900">Riwayat Mutasi Saldo Terakhir</h4>
        <a href="{{ route('seller.wallet.transactions') }}" class="text-xs font-bold text-brand hover:underline flex items-center gap-1">
            Lihat Semua <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </a>
    </div>

    @php
        // ponytail: list last 5 transactions
        $recentTransactions = $wallet->transactions()->take(5)->get();
    @endphp

    @if($recentTransactions->isEmpty())
        <div class="py-16 text-center flex flex-col items-center justify-center">
            <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-3 border border-gray-100">
                <i data-lucide="history" class="w-6 h-6 text-gray-400"></i>
            </div>
            <h5 class="font-bold text-gray-700">Belum Ada Transaksi</h5>
            <p class="text-xs text-gray-500 mt-1">Mutasi debit/kredit saldo Anda akan tercatat di sini.</p>
        </div>
    @else
        <div class="divide-y divide-gray-100">
            @foreach($recentTransactions as $txn)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center {{ $txn->isCredit() ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                            <i data-lucide="{{ $txn->isCredit() ? 'plus-circle' : 'minus-circle' }}" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $txn->description }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $txn->reference_number }} &bull; {{ $txn->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-extrabold text-sm {{ $txn->isCredit() ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $txn->isCredit() ? '+' : '-' }} Rp {{ number_format((float)($txn->amount ?? 0), 0, ',', '.') }}
                        </span>
                        <p class="text-[10px] text-gray-400 mt-0.5">Saldo: Rp {{ number_format((float)($txn->balance_after ?? 0), 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
