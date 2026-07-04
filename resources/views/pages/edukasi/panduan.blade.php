<section class="py-16 bg-gray-50 border-t border-gray-100 min-h-[70vh] flex flex-col justify-center">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="mb-12">
            <span class="inline-block bg-brand/10 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">
                Panduan Pengelolaan Limbah
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">Langkah Strategis Operasional</h2>
            <p class="text-gray-500 max-w-2xl text-lg">
                Panduan teknis dan manajerial yang dirancang khusus untuk meningkatkan efisiensi pengelolaan limbah industri Anda.
            </p>
        </div>

        {{-- Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($guides as $guide)
                @php
                    // ponytail: parse custom pipe level|link format in one line
                    $parts = explode('|', $guide->content . '|');
                    $level = strtolower($parts[0] ?: 'pemula');
                    $link = $parts[1] ?: '#';
                    
                    $levelConfigs = [
                        'pemula' => [
                            'bg' => 'bg-brand/10 text-brand',
                            'iconBg' => 'bg-brand/10',
                            'iconColor' => 'text-brand',
                            'label' => 'Pemula'
                        ],
                        'menengah' => [
                            'bg' => 'bg-orange-50 text-orange-600',
                            'iconBg' => 'bg-orange-50',
                            'iconColor' => 'text-orange-500',
                            'label' => 'Menengah'
                        ],
                        'lanjutan' => [
                            'bg' => 'bg-red-50 text-red-600',
                            'iconBg' => 'bg-red-50',
                            'iconColor' => 'text-red-500',
                            'label' => 'Lanjutan'
                        ]
                    ];
                    $config = $levelConfigs[$level] ?? $levelConfigs['pemula'];
                @endphp
                
                <a href="{{ $link }}" target="_blank" class="bg-white border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 rounded-2xl p-6 flex flex-col group cursor-pointer">
                    <div class="flex justify-between items-start mb-6">
                        <div class="w-10 h-10 {{ $config['iconBg'] }} rounded-xl flex items-center justify-center">
                            <i data-lucide="book" class="w-5 h-5 {{ $config['iconColor'] }}"></i>
                        </div>
                        <span class="{{ $config['bg'] }} px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest">
                            {{ $config['label'] }}
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-brand transition-colors leading-snug">
                        {{ $guide->title }}
                    </h3>
                    <p class="text-gray-500 text-sm mb-8 leading-relaxed">
                        {{ $guide->excerpt }}
                    </p>
                    <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-3 text-[11px] font-bold text-gray-400">
                            <span>PANDUAN</span>
                            <span>{{ strtoupper($guide->published_at ? \Carbon\Carbon::parse($guide->published_at)->translatedFormat('F Y') : '') }}</span>
                        </div>
                        <span class="text-brand text-xs font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform uppercase tracking-wider">
                            Buka <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-3 py-12 text-center text-gray-500 font-semibold">
                    Belum ada panduan pengelolaan limbah yang tersedia.
                </div>
            @endforelse
        </div>
    </div>
</section>
