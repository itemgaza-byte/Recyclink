@extends('admin.layouts.admin')

@section('title', 'Manajemen Pengguna - Recyclink')
@section('header_title', 'Manajemen Pengguna')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">Daftar Pengguna</h3>
            <p class="text-gray-600 mt-1">Kelola semua akun pengguna yang terdaftar di Recyclink.</p>
        </div>
        
        <!-- Active Search & Filter Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-2 sm:gap-3">
            <div class="relative flex-1 sm:w-72">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, HP, usaha... (Enter)" class="pl-10 pr-9 py-2 bg-white border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-brand focus:border-brand outline-none text-xs sm:text-sm w-full transition-all">
                @if(request('search'))
                    <a href="{{ route('admin.users.index', request()->only(['role', 'status'])) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </a>
                @endif
            </div>

            <!-- Role Filter -->
            <select name="role" onchange="this.form.submit()" class="py-2 px-3 bg-white border border-gray-200 text-gray-700 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-brand focus:border-brand outline-none font-medium cursor-pointer transition-colors">
                <option value="">Semua Peran</option>
                <option value="buyer" {{ request('role') === 'buyer' ? 'selected' : '' }}>Pembeli</option>
                <option value="seller" {{ request('role') === 'seller' ? 'selected' : '' }}>UMKM / Penjual</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>

            <!-- Status Filter -->
            <select name="status" onchange="this.form.submit()" class="py-2 px-3 bg-white border border-gray-200 text-gray-700 text-xs sm:text-sm rounded-xl focus:ring-2 focus:ring-brand focus:border-brand outline-none font-medium cursor-pointer transition-colors">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>

            @if(request()->hasAny(['search', 'role', 'status']))
                <a href="{{ route('admin.users.index') }}" class="p-2 text-red-600 hover:bg-red-50 border border-red-200 rounded-xl text-xs font-bold transition-all flex items-center gap-1" title="Reset Filter">
                    <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Reset</span>
                </a>
            @endif
        </form>
    </div>

    
    

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50/50 border-b border-gray-200 text-gray-900 font-semibold">
                    <tr>
                        <th class="px-6 py-4">Pengguna</th>
                        <th class="px-6 py-4">Peran (Role)</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal Bergabung</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $currentUserId = auth()->id();
                        $currentUserIsSuperAdmin = auth()->user()->email === 'admin@recyclink.id';
                    @endphp
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    @php
                                        $avatar = $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=7A9C59&color=fff';
                                    @endphp
                                    <img src="{{ $avatar }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->hasRole('admin'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                        Admin
                                    </span>
                                @elseif($user->hasRole('seller'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                        UMKM / Penjual
                                    </span>
                                @elseif($user->hasRole('buyer'))
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                        Pembeli
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                        Belum Pilih Peran
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status === 'active')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @elseif($user->status === 'suspended')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Ditangguhkan
                                    </span>
                                @elseif($user->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @php
                                        $isSuperAdmin = $user->email === 'admin@recyclink.id';
                                        $isAdminUtama = $user->email === 'admin@recyclink.com';
                                        $canUpdateStatus = !($isSuperAdmin || $isAdminUtama);
                                        $canDelete = ($user->id !== $currentUserId && !$isSuperAdmin) && (!$isAdminUtama || $currentUserIsSuperAdmin);
                                    @endphp
                                    
                                    @if($canUpdateStatus)
                                        <!-- Status actions moved to modal -->
                                    @else
                                        <!-- Placeholder to maintain spacing -->
                                        <div class="w-8 inline-block"></div>
                                    @endif

                                    <!-- Button for detail view modal -->
                                    <button type="button" class="p-2 text-brand hover:bg-brand/10 rounded-lg transition-colors tooltip btn-view-user" title="Lihat Detail"
                                        data-user-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-phone="{{ $user->phone_number ?? '-' }}"
                                        data-role="{{ $user->roles->first()->name ?? 'Tidak ada' }}"
                                        data-joined="{{ $user->created_at->format('d M Y, H:i') }}"
                                        data-status="{{ ucfirst($user->status) }}"
                                        data-raw-status="{{ $user->status }}"
                                        data-reason="{{ $user->rejection_reason ?? '-' }}"
                                        data-can-update-status="{{ $canUpdateStatus ? 'true' : 'false' }}"
                                        @if($user->hasRole('buyer') && $user->buyerProfile)
                                            data-profile-type="buyer"
                                            data-company="{{ $user->buyerProfile->company_name ?? '-' }}"
                                            data-btype="{{ $user->buyerProfile->buyer_type ?? '-' }}"
                                            data-industry="{{ $user->buyerProfile->industry_type ?? '-' }}"
                                            data-address="{{ $user->buyerProfile->address ?? '-' }}"
                                            data-city="{{ $user->buyerProfile->city ?? '-' }}"
                                            data-province="{{ $user->buyerProfile->province ?? '-' }}"
                                            data-zip="{{ $user->buyerProfile->postal_code ?? '-' }}"
                                        @elseif($user->hasRole('seller') && $user->sellerProfile)
                                            data-profile-type="seller"
                                            data-business="{{ $user->sellerProfile->business_name ?? '-' }}"
                                            data-btype="{{ $user->sellerProfile->business_type ?? '-' }}"
                                            data-address="{{ $user->sellerProfile->address ?? '-' }}"
                                            data-city="{{ $user->sellerProfile->city ?? '-' }}"
                                            data-province="{{ $user->sellerProfile->province ?? '-' }}"
                                            data-zip="{{ $user->sellerProfile->postal_code ?? '-' }}"
                                            data-lat="{{ $user->sellerProfile->latitude ?? '-' }}"
                                            data-lng="{{ $user->sellerProfile->longitude ?? '-' }}"
                                            data-verification-status="{{ $user->sellerProfile->verification_status ?? '-' }}"
                                            data-npwp="{{ $user->sellerProfile->npwp ?? '-' }}"
                                            data-nib="{{ $user->sellerProfile->nib ?? '-' }}"
                                            data-bank-name="{{ $user->sellerProfile->bank_name ?? '-' }}"
                                            data-bank-acc="{{ $user->sellerProfile->bank_account_number ?? '-' }}"
                                            data-bank-holder="{{ $user->sellerProfile->bank_account_name ?? '-' }}"
                                            data-desc="{{ $user->sellerProfile->description ?? '-' }}"
                                        @else
                                            data-profile-type="none"
                                        @endif
                                    >
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    @if($canDelete)
                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors tooltip btn-delete-user" title="Hapus Permanen">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <i data-lucide="users" class="w-8 h-8 text-gray-400"></i>
                                    </div>
                                    <h5 class="text-gray-900 font-medium">Belum Ada Pengguna</h5>
                                    <p class="text-sm text-gray-500 mt-1">Data pengguna akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

<!-- User Detail Modal -->
<div id="userDetailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div id="modalBackdrop" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    
    <!-- Modal Content -->
    <div id="modalContent" class="bg-white rounded-2xl shadow-xl w-full max-w-2xl transform scale-95 opacity-0 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col">
        <!-- Close Button -->
        <button type="button" id="closeModalBtn" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
        
        <div class="p-6 border-b border-gray-100 flex items-center gap-4 shrink-0">
            <div class="w-12 h-12 rounded-xl bg-brand/10 text-brand flex items-center justify-center shrink-0">
                <i data-lucide="user" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900" id="modalUserName">Nama Pengguna</h3>
                <p class="text-sm text-gray-500" id="modalUserEmail">email@example.com</p>
            </div>
            <div class="ml-auto mr-8 flex items-center gap-2">
                <span id="modalUserStatus" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Status</span>
                <a id="modalUserDetailLink" href="#" class="p-2 text-brand hover:bg-brand/10 rounded-lg transition-colors text-xs font-bold inline-flex items-center gap-1" title="Buka Halaman Detail">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Halaman Detail</span>
                </a>
            </div>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Basic Info -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Data Akun Utama</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">No. WhatsApp</p>
                            <p class="text-sm font-medium text-gray-900" id="modalUserPhone">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Peran (Role)</p>
                            <p class="text-sm font-medium text-gray-900" id="modalUserRole">-</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal Bergabung</p>
                            <p class="text-sm font-medium text-gray-900" id="modalUserJoined">-</p>
                        </div>
                        <div id="modalReasonContainer" class="hidden">
                            <p class="text-xs text-red-500 mb-1 font-bold">Catatan / Alasan</p>
                            <p class="text-sm font-medium text-red-700 bg-red-50 p-3 rounded-xl border border-red-100" id="modalUserReason">-</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Info -->
                <div id="modalProfileSection">
                    <!-- Dynamic content will be injected here -->
                </div>
            </div>
        </div>
        
        <!-- Action Button Container (Full Width Bottom) -->
        <div id="modalActionContainer" class="hidden border-t border-gray-100 p-6 bg-gray-50/50 rounded-b-2xl">
            <!-- Dynamic button will be injected here -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    (function() {
        let isDelegated = false;

        function openModal() {
            const modal = document.getElementById('userDetailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');
            if (!modal) return;

            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop?.classList.remove('opacity-0');
                backdrop?.classList.add('opacity-100');
                content?.classList.remove('scale-95', 'opacity-0');
                content?.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('userDetailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');
            if (!modal) return;

            backdrop?.classList.remove('opacity-100');
            backdrop?.classList.add('opacity-0');
            content?.classList.remove('scale-100', 'opacity-100');
            content?.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function populateAndOpenModal(button) {
            const userId = button.dataset.userId;
            const profileSection = document.getElementById('modalProfileSection');
            const actionContainer = document.getElementById('modalActionContainer');
            if (!profileSection) return;

            document.getElementById('modalUserName').textContent = button.dataset.name || '-';
            document.getElementById('modalUserEmail').textContent = button.dataset.email || '-';
            document.getElementById('modalUserPhone').textContent = button.dataset.phone || '-';
            document.getElementById('modalUserRole').textContent = button.dataset.role || '-';
            document.getElementById('modalUserJoined').textContent = button.dataset.joined || '-';
            document.getElementById('modalUserDetailLink').href = `/dashboard/admin/users/${userId}`;

            const reasonText = button.dataset.reason;
            const reasonContainer = document.getElementById('modalReasonContainer');
            const reasonEl = document.getElementById('modalUserReason');
            if (reasonText && reasonText !== '-') {
                if (reasonEl) reasonEl.textContent = reasonText;
                reasonContainer?.classList.remove('hidden');
            } else {
                reasonContainer?.classList.add('hidden');
            }

            const statusSpan = document.getElementById('modalUserStatus');
            if (statusSpan) {
                statusSpan.textContent = button.dataset.status || 'Status';
                statusSpan.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-medium';
                const rawStatus = button.dataset.rawStatus;
                if (rawStatus === 'active') statusSpan.classList.add('bg-emerald-100', 'text-emerald-700');
                else if (rawStatus === 'suspended') statusSpan.classList.add('bg-red-100', 'text-red-700');
                else if (rawStatus === 'pending') statusSpan.classList.add('bg-amber-100', 'text-amber-700');
                else statusSpan.classList.add('bg-gray-100', 'text-gray-700');
            }

            const type = button.dataset.profileType;
            let html = '';

            if (type === 'buyer') {
                html = `
                    <h4 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Profil Pembeli</h4>
                    <div class="space-y-4">
                        <div><p class="text-xs text-gray-500 mb-1">Nama Perusahaan</p><p class="text-sm font-medium text-gray-900">${button.dataset.company || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Tipe Pembeli</p><p class="text-sm font-medium text-gray-900">${button.dataset.btype || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Jenis Industri</p><p class="text-sm font-medium text-gray-900">${button.dataset.industry || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Alamat Lengkap</p><p class="text-sm font-medium text-gray-900">${button.dataset.address || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Kota / Provinsi</p><p class="text-sm font-medium text-gray-900">${button.dataset.city || '-'}, ${button.dataset.province || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Kode Pos</p><p class="text-sm font-medium text-gray-900">${button.dataset.zip || '-'}</p></div>
                    </div>
                `;
            } else if (type === 'seller') {
                let verificationBadge = '';
                if (button.dataset.verificationStatus === 'pending') {
                    verificationBadge = '<span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold bg-amber-100 text-amber-800 uppercase">Menunggu Verifikasi</span>';
                } else if (button.dataset.verificationStatus === 'verified') {
                    verificationBadge = '<span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold bg-emerald-100 text-emerald-800 uppercase">Terverifikasi</span>';
                } else if (button.dataset.verificationStatus === 'rejected') {
                    verificationBadge = '<span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-bold bg-red-100 text-red-800 uppercase">Ditolak</span>';
                }

                html = `
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Profil Penjual</h4>
                        <div>${verificationBadge}</div>
                    </div>
                    <div class="space-y-4">
                        <div><p class="text-xs text-gray-500 mb-1">Nama Usaha / Pengepul</p><p class="text-sm font-medium text-gray-900">${button.dataset.business || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Tipe Usaha</p><p class="text-sm font-medium text-gray-900">${button.dataset.btype || '-'}</p></div>
                        <div class="grid grid-cols-2 gap-2">
                            <div><p class="text-xs text-gray-500 mb-1">NPWP</p><p class="text-sm font-medium text-gray-900">${button.dataset.npwp || '-'}</p></div>
                            <div><p class="text-xs text-gray-500 mb-1">NIB</p><p class="text-sm font-medium text-gray-900">${button.dataset.nib || '-'}</p></div>
                        </div>
                        <div><p class="text-xs text-gray-500 mb-1">Alamat Lengkap</p><p class="text-sm font-medium text-gray-900">${button.dataset.address || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Kota / Provinsi</p><p class="text-sm font-medium text-gray-900">${button.dataset.city || '-'}, ${button.dataset.province || '-'}</p></div>
                        <div><p class="text-xs text-gray-500 mb-1">Kode Pos</p><p class="text-sm font-medium text-gray-900">${button.dataset.zip || '-'}</p></div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Rekening Bank</p>
                            <p class="text-sm font-medium text-gray-900">${button.dataset.bankName || '-'} - ${button.dataset.bankAcc || '-'} a.n ${button.dataset.bankHolder || '-'}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Titik Lokasi (Maps)</p>
                            <p class="text-sm font-medium text-gray-900">
                                ${button.dataset.lat && button.dataset.lat !== '-' ? 
                                    `<a href="https://www.google.com/maps/search/?api=1&query=${button.dataset.lat},${button.dataset.lng}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1"><i data-lucide="map-pin" class="w-4 h-4"></i> ${button.dataset.lat}, ${button.dataset.lng}</a>` 
                                    : 'Belum diatur'
                                }
                            </p>
                        </div>
                        ${button.dataset.desc && button.dataset.desc !== '-' ? `<div><p class="text-xs text-gray-500 mb-1">Deskripsi</p><p class="text-xs text-gray-700 bg-gray-50 p-2.5 rounded-lg border border-gray-100">${button.dataset.desc}</p></div>` : ''}
                    </div>
                `;
            } else {
                html = `<div class="flex items-center justify-center h-full bg-gray-50 rounded-xl border border-dashed border-gray-200 p-8"><p class="text-sm text-gray-500 text-center">Tidak ada data profil spesifik.</p></div>`;
            }
            profileSection.innerHTML = html;

            if (actionContainer) {
                actionContainer.innerHTML = '';
                let showAction = false;
                const rawStatus = button.dataset.rawStatus;

                if (button.dataset.canUpdateStatus === 'true') {
                    const verificationStatus = button.dataset.verificationStatus;

                    if (rawStatus === 'pending') {
                        actionContainer.innerHTML = `
                            <div class="flex gap-4">
                                <form action="/dashboard/admin/users/${userId}/status" method="POST" class="flex-1 form-reject-user">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="inactive">
                                    <input type="hidden" name="rejection_reason" class="rejection-reason-input" value="">
                                    <button type="button" class="w-full px-4 py-3 bg-red-100 text-red-700 font-bold rounded-xl hover:bg-red-200 transition-all flex items-center justify-center gap-2 btn-reject-user shadow-sm">
                                        <i data-lucide="x-circle" class="w-5 h-5"></i>
                                        Tolak Pendaftaran
                                    </button>
                                </form>
                                <form action="/dashboard/admin/users/${userId}/status" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button type="submit" class="w-full px-4 py-3 bg-[#719149] text-white font-bold rounded-xl hover:bg-[#607d3c] transition-all flex items-center justify-center gap-2 shadow-sm">
                                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                                        Terima (Verifikasi)
                                    </button>
                                </form>
                            </div>
                        `;
                        showAction = true;
                    } else if (rawStatus === 'inactive' || rawStatus === 'suspended') {
                        actionContainer.innerHTML = `
                            <form action="/dashboard/admin/users/${userId}/status" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="active">
                                <button type="submit" class="w-full px-4 py-3 bg-[#719149] text-white font-bold rounded-xl hover:bg-[#607d3c] transition-all flex items-center justify-center gap-2 shadow-sm">
                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                    Aktifkan & Verifikasi Akun
                                </button>
                            </form>
                        `;
                        showAction = true;
                    } else if (rawStatus === 'active') {
                        if (type === 'seller' && (verificationStatus === 'pending' || verificationStatus === 'rejected')) {
                            actionContainer.innerHTML = `
                                <div class="flex gap-4">
                                    <form action="/dashboard/admin/users/${userId}/status" method="POST" class="flex-1 form-suspend-user">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="suspended">
                                        <input type="hidden" name="rejection_reason" class="suspension-reason-input" value="">
                                        <button type="button" class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-all flex items-center justify-center gap-2 btn-suspend-user shadow-sm">
                                            <i data-lucide="ban" class="w-5 h-5"></i>
                                            Tangguhkan Akun
                                        </button>
                                    </form>
                                    <form action="/dashboard/admin/users/${userId}/verify-seller-profile" method="POST" class="flex-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-full px-4 py-3 bg-[#719149] text-white font-bold rounded-xl hover:bg-[#607d3c] transition-all flex items-center justify-center gap-2 shadow-sm">
                                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                                            Verifikasi Profil Penjual
                                        </button>
                                    </form>
                                </div>
                            `;
                        } else {
                            actionContainer.innerHTML = `
                                <form action="/dashboard/admin/users/${userId}/status" method="POST" class="w-full form-suspend-user">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="suspended">
                                    <input type="hidden" name="rejection_reason" class="suspension-reason-input" value="">
                                    <button type="button" class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-all flex items-center justify-center gap-2 btn-suspend-user shadow-sm">
                                        <i data-lucide="ban" class="w-5 h-5"></i>
                                        Tangguhkan Akun
                                    </button>
                                </form>
                            `;
                        }
                        showAction = true;
                    }
                }

                actionContainer.classList.toggle('hidden', !showAction);
            }

            if (window.lucide) lucide.createIcons();
            openModal();
        }

        function setupGlobalDelegation() {
            if (isDelegated) return;
            isDelegated = true;

            document.addEventListener('click', function(e) {
                // 1. View User Button
                const viewBtn = e.target.closest('.btn-view-user');
                if (viewBtn) {
                    e.preventDefault();
                    populateAndOpenModal(viewBtn);
                    return;
                }

                // 2. Close Modal Triggers
                if (e.target.closest('#closeModalBtn') || e.target.id === 'modalBackdrop') {
                    e.preventDefault();
                    closeModal();
                    return;
                }

                // 3. Delete User Button
                const deleteBtn = e.target.closest('.btn-delete-user');
                if (deleteBtn) {
                    e.preventDefault();
                    const form = deleteBtn.closest('form');
                    if (window.Swal) {
                        Swal.fire({
                            title: 'Hapus Pengguna?',
                            text: "Apakah Anda yakin ingin menghapus permanen pengguna ini? Aksi ini tidak dapat dibatalkan.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal',
                            customClass: { popup: 'rounded-2xl shadow-xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
                        }).then((result) => {
                            if (result.isConfirmed) form.submit();
                        });
                    } else if (confirm("Apakah Anda yakin ingin menghapus permanen pengguna ini?")) {
                        form.submit();
                    }
                    return;
                }

                // 4. Reject User Button in Modal
                const rejectBtn = e.target.closest('.btn-reject-user');
                if (rejectBtn) {
                    e.preventDefault();
                    const form = rejectBtn.closest('form');
                    if (window.Swal) {
                        Swal.fire({
                            title: 'Tolak Pendaftaran?',
                            text: 'Apakah Anda yakin ingin menolak pendaftaran pengguna ini?',
                            icon: 'warning',
                            input: 'textarea',
                            inputLabel: 'Alasan Penolakan',
                            inputPlaceholder: 'Tulis alasan penolakan di sini...',
                            showCancelButton: true,
                            confirmButtonColor: '#ef4444',
                            cancelButtonColor: '#6b7280',
                            confirmButtonText: 'Tolak',
                            cancelButtonText: 'Batal',
                            customClass: { popup: 'rounded-2xl shadow-xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' },
                            preConfirm: (reason) => {
                                if (!reason) Swal.showValidationMessage('Alasan penolakan harus diisi');
                                return reason;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.querySelector('.rejection-reason-input').value = result.value;
                                form.submit();
                            }
                        });
                    } else {
                        form.submit();
                    }
                    return;
                }

                // 5. Suspend User Button in Modal
                const suspendBtn = e.target.closest('.btn-suspend-user');
                if (suspendBtn) {
                    e.preventDefault();
                    const form = suspendBtn.closest('form');
                    if (window.Swal) {
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
                            customClass: { popup: 'rounded-2xl shadow-xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.querySelector('.suspension-reason-input').value = result.value || 'Melanggar ketentuan layanan';
                                form.submit();
                            }
                        });
                    } else {
                        form.submit();
                    }
                    return;
                }
            });
        }

        // Initialize icons and setup listener on Turbo load & DOM ready
        function initPage() {
            if (window.lucide) lucide.createIcons();
            setupGlobalDelegation();
        }

        document.addEventListener('turbo:load', initPage);
        if (document.readyState !== 'loading') {
            initPage();
        } else {
            document.addEventListener('DOMContentLoaded', initPage);
        }
    })();
</script>
@endpush
