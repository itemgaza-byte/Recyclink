@extends('seller.layouts.seller')

@section('title', 'Laporan Penjualan - Recyclink')
@section('header_title', 'Laporan Penjualan')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h3 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h3>
        <p class="text-gray-600 mt-1">Pantau performa penjualan dan pendapatan toko Anda.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="window.print()" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-colors">
            <i data-lucide="download" class="w-4 h-4"></i> Export Laporan
        </button>
    </div>
</div>

<!-- Filter Periode -->
<div class="bg-white rounded-2xl border border-gray-200 p-6 mb-8 shadow-sm">
    <form action="{{ route('seller.reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
        <div class="w-full sm:w-auto">
            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" value="{{ $startDate ?? '' }}" 
                class="w-full sm:w-48 px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand outline-none transition-all">
        </div>
        <div class="w-full sm:w-auto">
            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Akhir</label>
            <input type="date" name="end_date" id="end_date" value="{{ $endDate ?? '' }}" 
                class="w-full sm:w-48 px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand outline-none transition-all">
        </div>
        <button type="submit" class="w-full sm:w-auto bg-brand hover:bg-brand-hover text-white font-bold px-6 py-2 rounded-xl shadow-sm transition-colors">
            Terapkan Filter
        </button>
        @if(!empty($startDate) || !empty($endDate))
            <a href="{{ route('seller.reports.index') }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-2 rounded-xl shadow-sm transition-colors text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- Key Metrics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Total Transaksi -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Penjualan Berhasil</p>
                <h4 class="text-2xl font-extrabold text-gray-900">{{ number_format($totalSales) }} Transaksi</h4>
            </div>
        </div>
    </div>

    <!-- Pendapatan Total -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Pendapatan Kotor</p>
                <h4 class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Chart: Pendapatan -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm lg:col-span-2">
        <h4 class="text-lg font-bold text-gray-900 mb-6">Grafik Pendapatan</h4>
        <div class="w-full h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Tabel Data Transaksi Terbaru -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h4 class="text-lg font-bold text-gray-900 mb-4">Penjualan Terakhir</h4>
        @if($recentOrders->isEmpty())
            <div class="text-center py-6 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                Belum ada penjualan.
            </div>
        @else
            <div class="space-y-4">
                @foreach($recentOrders as $order)
                <div class="flex items-center justify-between border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                    <div>
                        <p class="font-bold text-gray-900">{{ $order->order_code }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-emerald-600">+Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart');
        if (ctx) {
            const labels = {!! json_encode($chartData['labels']) !!};
            const data = {!! json_encode($chartData['data']) !!};
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.length ? labels : ['Belum ada data'],
                    datasets: [{
                        label: 'Pendapatan',
                        data: data.length ? data : [0],
                        backgroundColor: 'rgba(59, 130, 246, 0.8)', // blue-500
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4]
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
