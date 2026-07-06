@extends('admin.layouts.admin')

@section('title', 'Laporan Pengguna - Admin Recyclink')
@section('header_title', 'Laporan Pengguna')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-brand transition-colors mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Pusat Laporan
        </a>
        <h3 class="text-2xl font-bold text-gray-900">Laporan Pengguna</h3>
    </div>
</div>

{{-- Filters Card --}}
<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-8">
    <form action="{{ route('admin.reports.users') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
        <div>
            <label for="status" class="block text-xs font-bold text-gray-500 uppercase mb-2">Status Akun</label>
            <select name="status" id="status" class="w-full rounded-xl border-gray-200 text-sm focus:border-brand focus:ring-brand/20">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 py-2.5 bg-brand hover:bg-brand-hover text-white text-sm font-bold rounded-xl transition-colors">
                Saring
            </button>
            @if(request()->anyFilled(['status']))
                <a href="{{ route('admin.reports.users') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-colors flex items-center justify-center">
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
            <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-semibold font-medium">Total Akun Terdaftar</p>
            <h4 class="text-2xl font-bold text-gray-900 mt-1">{{ $report['count'] }} Pengguna</h4>
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
            <p class="text-sm text-gray-500 mt-1">Gunakan saringan yang berbeda untuk mencari pengguna.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600 border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-200 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        // ponytail: status labels map
                        $statusConfig = [
                            'active' => ['bg' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'label' => 'Aktif'],
                            'pending' => ['bg' => 'bg-amber-50 text-amber-700 border-amber-100', 'label' => 'Pending'],
                            'rejected' => ['bg' => 'bg-red-50 text-red-700 border-red-100', 'label' => 'Ditolak'],
                            'suspended' => ['bg' => 'bg-gray-100 text-gray-600 border-gray-200', 'label' => 'Suspended']
                        ];
                    @endphp
                    @foreach($report['data'] as $user)
                        @php
                            $status = $statusConfig[$user->status] ?? ['bg' => 'bg-gray-50 text-gray-700 border-gray-100', 'label' => strtoupper($user->status)];
                            
                            $roleLabel = 'Admin';
                            if ($user->isSeller()) {
                                $roleLabel = 'Penjual (Seller)';
                            } elseif ($user->isBuyer()) {
                                $roleLabel = 'Pembeli (Buyer)';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=64748b" class="w-8 h-8 rounded-full border border-gray-100" alt="">
                                    <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-600">{{ $roleLabel }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $status['bg'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
