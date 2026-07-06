<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Analisis Eksekutif - Recyclink</title>
    @vite(['resources/css/app.css'])
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            background: #222; /* Dark background for preview area */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            margin: 0;
            padding: 2rem 0;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto 2rem auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .page:last-child {
            margin-bottom: 0;
        }
        @media print {
            body { background: white; padding: 0; }
            .page {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
                min-height: 100vh;
            }
            .page:last-child {
                page-break-after: auto;
            }
            @page { margin: 0; }
        }
        
        .brand-text { color: #7A9C59; }
        .brand-bg { background-color: #7A9C59; }
        .brand-border { border-color: #7A9C59; }
    </style>
</head>
<body onload="window.print()">

    <!-- PAGE 1 -->
    <div class="page">
        <!-- Header -->
        <div class="flex justify-between items-end border-b-2 brand-border pb-4 mb-6">
            <div>
                <h1 class="text-4xl font-bold brand-text">Recyclink</h1>
                <p class="text-gray-400 mt-1 text-sm font-medium">Platform Manajemen & Verifikasi Limbah</p>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-700 tracking-wide uppercase">Laporan Analisis Eksekutif</h2>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-y-4 gap-x-8 bg-gray-50/50 p-6 rounded-xl border border-gray-100 mb-8 text-xs">
            <div class="flex">
                <span class="w-32 font-bold text-gray-700">ID Laporan</span>
                <span class="text-gray-600">: RPT-{{ date('Ym') }}-001</span>
            </div>
            <div class="flex">
                <span class="w-32 font-bold text-gray-700">Tanggal Cetak</span>
                <span class="text-gray-600">: {{ \Carbon\Carbon::now()->translatedFormat('j F Y, H:i') }} WIB</span>
            </div>
            <div class="flex">
                <span class="w-32 font-bold text-gray-700">Periode Mulai</span>
                <span class="text-gray-600">: {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->translatedFormat('j F Y') : '- (Semua Waktu)' }}</span>
            </div>
            <div class="flex">
                <span class="w-32 font-bold text-gray-700">Dibuat Oleh</span>
                <span class="text-gray-600">: {{ auth()->check() ? auth()->user()->name : 'Admin Utama' }} (Administrator)</span>
            </div>
            <div class="flex">
                <span class="w-32 font-bold text-gray-700">Periode Akhir</span>
                <span class="text-gray-600">: {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->translatedFormat('j F Y') : '- (Semua Waktu)' }}</span>
            </div>
            <div class="flex">
                <span class="w-32 font-bold text-gray-700">Status Data</span>
                <span class="text-gray-600">: Terverifikasi Sisi Sistem</span>
            </div>
        </div>

        <!-- Section: Ringkasan Metrik Utama -->
        <div class="mb-4 flex items-center gap-2">
            <div class="w-1 h-5 brand-bg"></div>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Ringkasan Metrik Utama</h3>
        </div>

        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="border border-gray-100 rounded-xl p-4 text-center flex flex-col justify-center items-center h-28 shadow-sm">
                <p class="text-[9px] font-bold text-gray-500 uppercase tracking-wider mb-2">Total Pengguna</p>
                <h4 class="text-2xl font-extrabold text-gray-800">{{ number_format($report['total_users']) }}</h4>
                <p class="text-[9px] text-gray-400 mt-2">{{ number_format($report['total_sellers']) }} Penjual &bull; {{ number_format($report['total_buyers']) }} Pembeli</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4 text-center flex flex-col justify-center items-center h-28 shadow-sm">
                <p class="text-[9px] font-bold text-gray-500 uppercase tracking-wider mb-2">Total Listing</p>
                <h4 class="text-2xl font-extrabold text-gray-800">{{ number_format($report['total_listings']) }}</h4>
                <p class="text-[9px] text-gray-400 mt-2">Jumlah limbah aktif</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4 text-center flex flex-col justify-center items-center h-28 shadow-sm">
                <p class="text-[9px] font-bold text-gray-500 uppercase tracking-wider mb-2">Total Transaksi</p>
                <h4 class="text-2xl font-extrabold text-gray-800">{{ number_format($report['total_transactions']) }}</h4>
                <p class="text-[9px] text-gray-400 mt-2">Transaksi berhasil</p>
            </div>
            <div class="border border-gray-100 rounded-xl p-4 text-center flex flex-col justify-center items-center h-28 shadow-sm">
                <p class="text-[9px] font-bold text-gray-500 uppercase tracking-wider mb-2">Pendapatan Platform</p>
                <h4 class="text-xl font-extrabold text-gray-800">Rp {{ number_format($report['platform_revenue'], 0, ',', '.') }}</h4>
                <p class="text-[9px] text-gray-400 mt-2">Total fee transaksi</p>
            </div>
        </div>

        <!-- Section: Analisis Jenis Limbah Populer -->
        <div class="mb-4 flex items-center gap-2">
            <div class="w-1 h-5 brand-bg"></div>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Analisis Jenis Limbah Populer</h3>
        </div>

        <div class="mb-8 border border-gray-100 rounded-sm">
            <table class="w-full text-left text-xs">
                <thead class="brand-bg text-white">
                    <tr>
                        <th class="py-2 px-4 font-bold w-12">No</th>
                        <th class="py-2 px-4 font-bold">Kategori Limbah</th>
                        <th class="py-2 px-4 font-bold text-center">Jumlah Listing</th>
                        <th class="py-2 px-4 font-bold text-right">Total Transaksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if(empty($report['popular_categories']) || (is_object($report['popular_categories']) && $report['popular_categories']->isEmpty()))
                        <tr>
                            <td colspan="4" class="py-6 text-center text-gray-500 text-xs italic">Belum ada data transaksi untuk visualisasi kategori limbah populer.</td>
                        </tr>
                    @else
                        @foreach($report['popular_categories'] as $index => $category)
                        <tr>
                            <td class="py-2 px-4 text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-gray-900 font-medium">{{ $category->category_name }}</td>
                            <td class="py-2 px-4 text-center text-gray-600">-</td>
                            <td class="py-2 px-4 text-right text-gray-600">{{ number_format($category->total_sales) }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Section: Sebaran Wilayah Aktif -->
        <div class="mb-4 flex items-center gap-2">
            <div class="w-1 h-5 brand-bg"></div>
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Sebaran Wilayah Aktif</h3>
        </div>

        <div class="border border-gray-100 rounded-sm">
            <table class="w-full text-left text-xs">
                <thead class="brand-bg text-white">
                    <tr>
                        <th class="py-2 px-4 font-bold w-12">No</th>
                        <th class="py-2 px-4 font-bold">Wilayah / Kota</th>
                        <th class="py-2 px-4 font-bold text-right">Volume Transaksi Berhasil</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if(empty($report['active_regions']) || (is_object($report['active_regions']) && $report['active_regions']->isEmpty()))
                        <tr>
                            <td colspan="3" class="py-6 text-center text-gray-500 text-xs italic">Belum ada data aktivitas wilayah berdasarkan transaksi yang tersimpan.</td>
                        </tr>
                    @else
                        @foreach($report['active_regions'] as $index => $region)
                        <tr>
                            <td class="py-2 px-4 text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 text-gray-900 font-medium">{{ $region->city ?? 'Tidak diketahui' }}</td>
                            <td class="py-2 px-4 text-right text-gray-600">{{ number_format($region->total_transactions) }}</td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        
        <div class="mt-auto pt-6 flex justify-between text-[10px] text-gray-400 border-t border-gray-100">
            <span>Recyclink Platform &bull; Dokumen Rahasia Internal</span>
            <span>Halaman 1 dari 2</span>
        </div>
    </div>


    <!-- PAGE 2 -->
    <div class="page">
        <!-- Header Page 2 -->
        <div class="flex justify-between items-start mb-12">
            <div>
                <p class="text-xs font-medium text-gray-700">Mendukung digitalisasi ekonomi sirkular.</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-700">Semarang, {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</p>
                <p class="text-xs font-bold text-gray-900 mt-1">Sistem Administrasi Recyclink</p>
            </div>
        </div>

        <div class="flex justify-end mt-12">
            <div class="text-right">
                <p class="text-xs font-bold text-blue-600 underline mb-1">Generated Automatically</p>
                <p class="text-[10px] text-gray-400 leading-tight">Dokumen ini sah dikeluarkan oleh sistem tanpa tanda tangan<br>basah.</p>
            </div>
        </div>

        <div class="mt-auto pt-6 flex justify-between text-[10px] text-gray-400 border-t border-gray-100">
            <span>Recyclink Platform &bull; Dokumen Rahasia Internal</span>
            <span>Halaman 2 dari 2</span>
        </div>
    </div>

</body>
</html>
