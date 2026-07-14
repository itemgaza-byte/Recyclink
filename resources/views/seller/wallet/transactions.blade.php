@extends('seller.layouts.seller')

@section('title', 'Riwayat Transaksi Dompet - Seller Recyclink')
@section('header_title', 'Riwayat Transaksi')

@section('content')
<div class="mb-8">
    <a href="{{ route('seller.wallet.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-brand transition-colors mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Dompet
    </a>
    <h3 class="text-2xl font-bold text-gray-900">Riwayat Mutasi Dompet</h3>
    <p class="text-gray-600 mt-1">Daftar lengkap transaksi kredit dan debit pada akun Anda.</p>
</div>

<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    @if($transactions->isEmpty())
        <div class="py-20 text-center flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                <i data-lucide="history" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h4 class="font-bold text-gray-700">Belum Ada Transaksi</h4>
            <p class="text-sm text-gray-500 mt-1">Semua transaksi mutasi dompet digital Anda akan tercatat di sini.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-200 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nomor Referensi</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Sisa Saldo</th>
                        <th class="px-6 py-4">Tanggal & Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transactions as $txn)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-gray-900">{{ $txn->reference_number }}</td>
                            <td class="px-6 py-4 font-medium text-gray-850">{{ $txn->description }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $txn->isCredit() ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : 'bg-rose-50 border-rose-200 text-rose-700' }}">
                                    {{ $txn->isCredit() ? 'KREDIT' : 'DEBIT' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-extrabold {{ $txn->isCredit() ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $txn->isCredit() ? '+' : '-' }} Rp {{ number_format((float)($txn->amount ?? 0), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-700">Rp {{ number_format((float)($txn->balance_after ?? 0), 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $txn->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 font-semibold">
                {{ $transactions->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
