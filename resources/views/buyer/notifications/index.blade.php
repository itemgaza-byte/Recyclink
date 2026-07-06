@extends('buyer.layouts.buyer')
@section('title', 'Notifikasi')
@section('content')

<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="text-gray-500 mt-1">Pemberitahuan terbaru mengenai akun Anda</p>
        </div>
        <a href="{{ route('buyer.dashboard') }}" class="px-5 py-2.5 bg-gray-50 text-gray-700 font-bold rounded-xl hover:bg-gray-100 transition-colors flex items-center gap-2 border border-gray-200">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        @if($notifications->count() > 0)
            <ul class="divide-y divide-gray-100">
                @foreach($notifications as $notification)
                    @php
                        $bgColor = 'bg-white';
                        if (!$notification->is_read) {
                            $bgColor = 'bg-brand/10'; // Notifikasi baru
                        } elseif ($notification->created_at->diffInDays(now()) > 0) {
                            $bgColor = 'bg-gray-50 opacity-80'; // Notifikasi lama (> 1 hari)
                        }
                    @endphp
                    @if(is_null($notification->read_at))
                        <form action="{{ route('buyer.notifications.read', $notification->id) }}" method="POST" class="m-0 p-0 block w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full text-left p-6 transition-colors hover:bg-brand/5 {{ $bgColor }}">
                    @else
                        <div class="p-6 transition-colors {{ $bgColor }}">
                    @endif
                        <div class="flex gap-4">
                            <!-- Icon -->
                            <div class="w-12 h-12 rounded-full shrink-0 flex items-center justify-center
                                {{ ($notification->data['status'] ?? null) === 'active' ? 'bg-emerald-100 text-emerald-600' : '' }}
                                {{ ($notification->data['status'] ?? null) === 'rejected' ? 'bg-red-100 text-red-600' : '' }}
                                {{ ($notification->data['status'] ?? null) === 'suspended' ? 'bg-amber-100 text-amber-600' : '' }}
                            ">
                                @if(($notification->data['status'] ?? null) === 'active')
                                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                                @elseif(($notification->data['status'] ?? null) === 'rejected')
                                    <i data-lucide="x-circle" class="w-6 h-6"></i>
                                @else
                                    <i data-lucide="bell" class="w-6 h-6"></i>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-lg mb-1">
                                    {{ $notification->title ?? ($notification->data['title'] ?? 'Pemberitahuan') }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-2">
                                    {{ $notification->message ?? ($notification->data['message'] ?? '') }}
                                </p>
                                @if(isset($notification->data['reason']) && $notification->data['reason'])
                                    <p class="text-sm text-gray-600 mb-3 bg-white p-3 rounded-xl border border-gray-100 italic">
                                        "{{ $notification->data['reason'] }}"
                                    </p>
                                @endif
                                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                                    <i data-lucide="clock" class="w-3 h-3"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <!-- Actions -->
                            @if(is_null($notification->read_at))
                                <div class="shrink-0 flex items-start">
                                    <span class="text-sm font-bold text-brand hover:text-brand-hover" title="Tandai sudah dibaca">
                                        <i data-lucide="check" class="w-5 h-5"></i>
                                    </span>
                                </div>
                            @endif
                        </div>
                    @if(is_null($notification->read_at))
                            </button>
                        </form>
                    @else
                        </div>
                    @endif
                @endforeach
            </ul>
            
            <div class="p-6 border-t border-gray-100">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="bell-off" class="w-10 h-10 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada notifikasi</h3>
                <p class="text-gray-500 max-w-sm">Anda akan menerima pemberitahuan di sini ketika ada update mengenai akun Anda.</p>
            </div>
        @endif
    </div>
</div>

@endsection
