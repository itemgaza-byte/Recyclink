@extends('admin.layouts.admin')

@section('title', 'Detail Pengguna - ' . $user->name . ' - Admin Recyclink')
@section('header_title', 'Detail Pengguna')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 mb-10">
    {{-- Navigation Bar --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-brand transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Daftar Pengguna
        </a>
        <div class="flex items-center gap-3">
            @php
                $isSuperAdmin = $user->email === 'admin@recyclink.id';
                $isAdminUtama = $user->email === 'admin@recyclink.com';
                $currentUserIsSuperAdmin = auth()->user()->email === 'admin@recyclink.id';
                $isSelf = $user->id === auth()->id();
                $canUpdateStatus = !($isSuperAdmin || $isAdminUtama);
            @endphp

            @if($user->status === 'active')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Aktif
                </span>
            @elseif($user->status === 'pending')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    Menunggu Verifikasi
                </span>
            @elseif($user->status === 'suspended')
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    Ditangguhkan
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                    Tidak Aktif
                </span>
            @endif
        </div>
    </div>

    {{-- Main Profile Overview Card --}}
    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                @php
                    $avatar = $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7A9C59&color=fff';
                @endphp
                <img src="{{ $avatar }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-brand/20 p-0.5">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($user->hasRole('admin'))
                            <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">Admin</span>
                        @elseif($user->hasRole('seller'))
                            <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">UMKM / Penjual</span>
                        @elseif($user->hasRole('buyer'))
                            <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">Pembeli</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">Belum Pilih Peran</span>
                        @endif

                        <span class="text-xs text-gray-400">&bull; Bergabung {{ $user->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Status Action Buttons --}}
            @if($canUpdateStatus)
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    @if($user->status === 'pending')
                        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="inline-block form-reject-user">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="inactive">
                            <input type="hidden" name="rejection_reason" class="rejection-reason-input" value="">
                            <button type="button" class="px-4 py-2 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-colors text-sm flex items-center gap-1.5 btn-reject-user">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                                Tolak
                            </button>
                        </form>
                        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="px-4 py-2 bg-brand text-white font-bold rounded-xl hover:bg-brand/90 transition-colors text-sm flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Terima (Verifikasi)
                            </button>
                        </form>
                    @elseif($user->status === 'inactive' || $user->status === 'suspended')
                        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="px-4 py-2 bg-brand text-white font-bold rounded-xl hover:bg-brand/90 transition-colors text-sm flex items-center gap-1.5 shadow-sm">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Aktifkan & Verifikasi Akun
                            </button>
                        </form>
                    @elseif($user->status === 'active')
                        @if($user->isSeller() && $user->sellerProfile && $user->sellerProfile->verification_status !== 'verified')
                            <form action="{{ route('admin.users.verifySellerProfile', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-brand text-white font-bold rounded-xl hover:bg-brand/90 transition-colors text-sm flex items-center gap-1.5 shadow-sm">
                                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                                    Verifikasi Profil Penjual
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="inline-block form-suspend-user">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="suspended">
                            <input type="hidden" name="rejection_reason" class="suspension-reason-input" value="">
                            <button type="button" class="px-4 py-2 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-colors text-sm flex items-center gap-1.5 btn-suspend-user">
                                <i data-lucide="ban" class="w-4 h-4"></i>
                                Tangguhkan
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Left Column: User Account Information --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                <i data-lucide="user" class="w-5 h-5 text-brand"></i>
                Informasi Akun Utama
            </h3>
            
            <div class="divide-y divide-gray-100 text-sm">
                <div class="py-3 flex justify-between">
                    <span class="text-gray-500">Nama Lengkap</span>
                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                </div>
                <div class="py-3 flex justify-between">
                    <span class="text-gray-500">Alamat Email</span>
                    <span class="font-medium text-gray-900">{{ $user->email }}</span>
                </div>
                <div class="py-3 flex justify-between">
                    <span class="text-gray-500">Nomor WhatsApp</span>
                    <span class="font-medium text-gray-900">{{ $user->phone_number ?? '-' }}</span>
                </div>
                <div class="py-3 flex justify-between">
                    <span class="text-gray-500">Peran Sistem</span>
                    <span class="font-medium text-gray-900 capitalize">{{ $user->roles->first()->name ?? 'Belum Pilih' }}</span>
                </div>
                <div class="py-3 flex justify-between">
                    <span class="text-gray-500">Tanggal Terdaftar</span>
                    <span class="font-medium text-gray-900">{{ $user->created_at->format('d M Y, H:i') }}</span>
                </div>
                @if($user->rejection_reason)
                    <div class="py-3">
                        <span class="text-xs text-red-500 font-bold block mb-1">Catatan / Alasan Rejeki & Suspensi:</span>
                        <p class="text-sm text-red-700 bg-red-50 p-3 rounded-xl border border-red-100">{{ $user->rejection_reason }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Role Specific Profile Details --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
            @if($user->isSeller() && $user->sellerProfile)
                <div class="flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                        <i data-lucide="store" class="w-5 h-5 text-brand"></i>
                        Profil Usaha (Penjual)
                    </h3>
                    @if($user->sellerProfile->verification_status === 'verified')
                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">Terverifikasi</span>
                    @elseif($user->sellerProfile->verification_status === 'pending')
                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">Menunggu Verifikasi</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded text-xs font-bold bg-red-100 text-red-800">Ditolak</span>
                    @endif
                </div>

                <div class="divide-y divide-gray-100 text-sm">
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Nama Usaha / Pengepul</span>
                        <span class="font-medium text-gray-900">{{ $user->sellerProfile->business_name ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Tipe Usaha</span>
                        <span class="font-medium text-gray-900">{{ $user->sellerProfile->business_type ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Nomor NPWP</span>
                        <span class="font-medium text-gray-900">{{ $user->sellerProfile->npwp ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Nomor NIB</span>
                        <span class="font-medium text-gray-900">{{ $user->sellerProfile->nib ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Kota / Provinsi</span>
                        <span class="font-medium text-gray-900">{{ $user->sellerProfile->city ?? '-' }}, {{ $user->sellerProfile->province ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Kode Pos</span>
                        <span class="font-medium text-gray-900">{{ $user->sellerProfile->postal_code ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Alamat Lengkap</span>
                        <span class="font-medium text-gray-900 text-right max-w-xs">{{ $user->sellerProfile->address ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-gray-500">Rekening Bank</span>
                        <span class="font-medium text-gray-900">
                            {{ $user->sellerProfile->bank_name ?? '-' }} - {{ $user->sellerProfile->bank_account_number ?? '-' }} 
                            @if($user->sellerProfile->bank_account_name)
                                (a.n {{ $user->sellerProfile->bank_account_name }})
                            @endif
                        </span>
                    </div>
                    <div class="py-3 flex justify-between items-center">
                        <span class="text-gray-500">Titik Lokasi (Maps)</span>
                        @if($user->sellerProfile->latitude && $user->sellerProfile->longitude)
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $user->sellerProfile->latitude }},{{ $user->sellerProfile->longitude }}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1 font-medium">
                                <i data-lucide="map-pin" class="w-4 h-4"></i>
                                {{ $user->sellerProfile->latitude }}, {{ $user->sellerProfile->longitude }}
                            </a>
                        @else
                            <span class="text-gray-400 font-medium">Belum diatur</span>
                        @endif
                    </div>
                    @if($user->sellerProfile->description)
                        <div class="py-3">
                            <span class="text-gray-500 block mb-1">Deskripsi Pengepul:</span>
                            <p class="text-xs text-gray-700 bg-gray-50 p-3 rounded-xl border border-gray-100">{{ $user->sellerProfile->description }}</p>
                        </div>
                    @endif
                </div>
            @elseif($user->isBuyer() && $user->buyerProfile)
                <h3 class="font-bold text-gray-900 text-base flex items-center gap-2">
                    <i data-lucide="building" class="w-5 h-5 text-brand"></i>
                    Profil Industri (Pembeli)
                </h3>

                <div class="divide-y divide-gray-100 text-sm">
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Nama Perusahaan</span>
                        <span class="font-medium text-gray-900">{{ $user->buyerProfile->company_name ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Tipe Pembeli</span>
                        <span class="font-medium text-gray-900">{{ $user->buyerProfile->buyer_type ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Jenis Industri</span>
                        <span class="font-medium text-gray-900">{{ $user->buyerProfile->industry_type ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Kota / Provinsi</span>
                        <span class="font-medium text-gray-900">{{ $user->buyerProfile->city ?? '-' }}, {{ $user->buyerProfile->province ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Kode Pos</span>
                        <span class="font-medium text-gray-900">{{ $user->buyerProfile->postal_code ?? '-' }}</span>
                    </div>
                    <div class="py-3 flex justify-between">
                        <span class="text-gray-500">Alamat Lengkap</span>
                        <span class="font-medium text-gray-900 text-right max-w-xs">{{ $user->buyerProfile->address ?? '-' }}</span>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                        <i data-lucide="info" class="w-6 h-6 text-gray-400"></i>
                    </div>
                    <h5 class="text-gray-900 font-medium">Tidak Ada Detail Profil</h5>
                    <p class="text-xs text-gray-500 mt-1">Pengguna ini belum melengkapi profil khusus.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rejectBtn = document.querySelector('.btn-reject-user');
        if (rejectBtn) {
            rejectBtn.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Tolak Pendaftaran?',
                    text: 'Apakah Anda yakin ingin menolak pengguna ini?',
                    icon: 'warning',
                    input: 'textarea',
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Tulis alasan penolakan di sini...',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Tolak',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl',
                        input: 'rounded-xl p-3 border-gray-300 focus:border-brand focus:ring-brand/20'
                    },
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Alasan penolakan harus diisi')
                        }
                        return reason;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.querySelector('.rejection-reason-input').value = result.value;
                        form.submit();
                    }
                });
            });
        }

        const suspendBtn = document.querySelector('.btn-suspend-user');
        if (suspendBtn) {
            suspendBtn.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Tangguhkan Akun?',
                    text: 'Apakah Anda yakin ingin menangguhkan akun pengguna ini?',
                    icon: 'warning',
                    input: 'textarea',
                    inputLabel: 'Alasan Penangguhan',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Tangguhkan',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.querySelector('.suspension-reason-input').value = result.value || 'Melanggar ketentuan layanan';
                        form.submit();
                    }
                });
            });
        }
    });
</script>
@endpush
