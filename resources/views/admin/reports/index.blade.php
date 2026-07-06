@extends('admin.layouts.admin')

@section('title', 'Laporan Analisis - Admin Recyclink')
@section('header_title', 'Laporan Analisis')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h3 class="text-2xl font-bold text-gray-900">Laporan & Analitik</h3>
        <p class="text-gray-600 mt-1">Ringkasan data analitik platform Recyclink.</p>
    </div>
    <div class="flex items-center gap-3">
        <!-- Export Laporan -->
        <a href="{{ route('admin.reports.print', request()->query()) }}" target="_blank" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-xl font-bold flex items-center gap-2 shadow-sm transition-colors">
            <i data-lucide="download" class="w-4 h-4"></i> Export Laporan
        </a>
    </div>
</div>

<!-- Filter Periode -->
<div class="bg-white rounded-2xl border border-gray-200 p-6 mb-8 shadow-sm">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
        <div class="w-full sm:w-auto">
            <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" value="{{ $report['filters']['start_date'] ?? '' }}" 
                class="w-full sm:w-48 px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand outline-none transition-all">
        </div>
        <div class="w-full sm:w-auto">
            <label for="end_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Akhir</label>
            <input type="date" name="end_date" id="end_date" value="{{ $report['filters']['end_date'] ?? '' }}" 
                class="w-full sm:w-48 px-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand focus:border-brand outline-none transition-all">
        </div>
        <button type="submit" class="w-full sm:w-auto bg-brand hover:bg-brand-hover text-white font-bold px-6 py-2 rounded-xl shadow-sm transition-colors">
            Terapkan Filter
        </button>
        @if(!empty($report['filters']['start_date']) || !empty($report['filters']['end_date']))
            <a href="{{ route('admin.reports.index') }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-2 rounded-xl shadow-sm transition-colors text-center">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- Key Metrics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Pengguna -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Pengguna</p>
                <h4 class="text-2xl font-extrabold text-gray-900">{{ number_format($report['total_users']) }}</h4>
            </div>
        </div>
        <div class="flex items-center gap-4 text-sm font-medium text-gray-600 border-t border-gray-100 pt-3 mt-1">
            <span>{{ number_format($report['total_sellers']) }} Penjual</span>
            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
            <span>{{ number_format($report['total_buyers']) }} Pembeli</span>
        </div>
    </div>

    <!-- Total Listing -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Listing</p>
                <h4 class="text-2xl font-extrabold text-gray-900">{{ number_format($report['total_listings']) }}</h4>
            </div>
        </div>
        <div class="text-sm font-medium text-gray-600 border-t border-gray-100 pt-3 mt-1">
            Jumlah limbah aktif
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                <h4 class="text-2xl font-extrabold text-gray-900">{{ number_format($report['total_transactions']) }}</h4>
            </div>
        </div>
        <div class="text-sm font-medium text-gray-600 border-t border-gray-100 pt-3 mt-1">
            Jumlah transaksi berhasil
        </div>
    </div>

    <!-- Pendapatan Platform -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
                <i data-lucide="wallet" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Pendapatan Platform</p>
                <h4 class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($report['platform_revenue'], 0, ',', '.') }}</h4>
            </div>
        </div>
        <div class="text-sm font-medium text-gray-600 border-t border-gray-100 pt-3 mt-1">
            Total fee transaksi
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Chart: Transaksi -->
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h4 class="text-lg font-bold text-gray-900 mb-6">Grafik Transaksi Berhasil</h4>
        <div class="w-full h-72">
            <canvas id="transactionsChart"></canvas>
        </div>
    </div>

    <!-- Tabel Data Populer -->
    <div class="flex flex-col gap-8">
        <!-- Jenis Limbah Populer -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex-1">
            <h4 class="text-lg font-bold text-gray-900 mb-4">Jenis Limbah Populer</h4>
            @if($report['popular_categories']->isEmpty())
                <div class="text-center py-6 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    Belum ada data transaksi.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-200">
                                <th class="pb-3 font-bold">Kategori</th>
                                <th class="pb-3 font-bold text-right">Jumlah Terjual</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($report['popular_categories'] as $category)
                            <tr>
                                <td class="py-3 text-gray-900 font-medium">{{ $category->category_name }}</td>
                                <td class="py-3 text-right text-gray-600">{{ number_format($category->total_sales) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Wilayah Aktif -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex-1">
            <h4 class="text-lg font-bold text-gray-900 mb-4">Wilayah Aktif (Berdasarkan Transaksi)</h4>
            @if($report['active_regions']->isEmpty())
                <div class="text-center py-6 text-gray-500 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    Belum ada data wilayah.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-gray-500 border-b border-gray-200">
                                <th class="pb-3 font-bold">Kota/Wilayah</th>
                                <th class="pb-3 font-bold text-right">Total Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($report['active_regions'] as $region)
                            <tr>
                                <td class="py-3 text-gray-900 font-medium">{{ $region->city ?? 'Tidak diketahui' }}</td>
                                <td class="py-3 text-right text-gray-600">{{ number_format($region->total_transactions) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('transactionsChart');
        if (ctx) {
            const labels = {!! json_encode($report['chart_data']['labels']) !!};
            const data = {!! json_encode($report['chart_data']['data']) !!};
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.length ? labels : ['Belum ada data'],
                    datasets: [{
                        label: 'Transaksi Berhasil',
                        data: data.length ? data : [0],
                        borderColor: '#10b981', // emerald-500
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#10b981'
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
                                    return ' ' + context.parsed.y + ' Transaksi';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            },
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
