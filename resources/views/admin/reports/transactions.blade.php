@extends('admin.layouts.admin')

@section('title', 'Laporan Transaksi - Admin Recyclink')
@section('header_title', 'Laporan Transaksi')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-brand transition-colors mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Pusat Laporan
        </a>
        <h3 class="text-2xl font-bold text-gray-900">Laporan Transaksi</h3>
    </div>
</div>

{{-- Filters Card --}}
<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
    <form action="{{ route('admin.reports.transactions') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
        <div>
            <label for="start_date" class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-brand focus:ring-brand/20">
        </div>
        <div>
            <label for="end_date" class="block text-xs font-bold text-gray-500 uppercase mb-2">Tanggal Selesai</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full rounded-xl border-gray-200 text-sm focus:border-brand focus:ring-brand/20">
        </div>
        <div>
            <label for="status" class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Pesanan</label>
            <select name="status" id="status" class="w-full rounded-xl border-gray-200 text-sm focus:border-brand focus:ring-brand/20">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="waiting_payment" {{ request('status') === 'waiting_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 py-2.5 bg-brand hover:bg-brand-hover text-white text-sm font-bold rounded-xl transition-colors">
                Saring
            </button>
            @if(request()->anyFilled(['start_date', 'end_date', 'status']))
                <a href="{{ route('admin.reports.transactions') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors flex items-center justify-center">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Summary Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex items-start gap-4">
        <div class="p-3 bg-brand/10 text-brand rounded-xl">
            <i data-lucide="line-chart" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Transaksi Sesuai Filter</p>
            <h4 class="text-2xl font-bold text-gray-900 mt-1">{{ $report['count'] }} Pesanan</h4>
        </div>
    </div>
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex items-start gap-4">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
            <i data-lucide="circle-dollar-sign" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold font-medium">Total Nilai Transaksi</p>
            <h4 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($report['total_amount'], 0, ',', '.') }}</h4>
        </div>
    </div>
</div>

{{-- Results Table --}}
<div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
    @if($report['data']->isEmpty())
        <div class="py-20 text-center flex flex-col items-center justify-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h4 class="font-bold text-gray-700">Tidak Ada Data</h4>
            <p class="text-sm text-gray-500 mt-1">Gunakan saringan yang berbeda untuk mencari riwayat transaksi.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-200 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Kode Pesanan</th>
                        <th class="px-6 py-4">Pembeli</th>
                        <th class="px-6 py-4">Penjual</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        // ponytail: status labels mapping
                        $statusConfig = [
                            'pending' => ['bg' => 'bg-amber-50 border-amber-200 text-amber-700', 'label' => 'Menunggu Konfirmasi'],
                            'waiting_payment' => ['bg' => 'bg-blue-50 border-blue-200 text-blue-700', 'label' => 'Menunggu Pembayaran'],
                            'paid' => ['bg' => 'bg-emerald-50 border-emerald-200 text-emerald-700', 'label' => 'Sudah Dibayar'],
                            'processing' => ['bg' => 'bg-indigo-50 border-indigo-200 text-indigo-700', 'label' => 'Sedang Diproses'],
                            'completed' => ['bg' => 'bg-gray-100 border-gray-200 text-gray-700', 'label' => 'Selesai'],
                            'rejected' => ['bg' => 'bg-rose-50 border-rose-200 text-rose-700', 'label' => 'Ditolak'],
                            'cancelled' => ['bg' => 'bg-red-50 border-red-200 text-red-700', 'label' => 'Dibatalkan']
                        ];
                    @endphp
                    @foreach($report['data'] as $order)
                        @php
                            $status = $statusConfig[$order->order_status] ?? ['bg' => 'bg-gray-50 border-gray-200 text-gray-700', 'label' => strtoupper($order->order_status)];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-gray-900">{{ $order->order_code }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $order->buyer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $order->seller->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-brand">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $status['bg'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
