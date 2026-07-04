<section class="py-16 bg-gray-50 border-t border-gray-100 min-h-[70vh] flex flex-col justify-center">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="mb-10">
            <span class="inline-block bg-brand/10 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">
                Wawasan Terbaru
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">Artikel & Strategi Pengelolaan Limbah</h2>
            <p class="text-gray-500 max-w-2xl text-lg">
                Pelajari konsep ekonomi sirkular, teknik pemilahan material industri, dan tren pasar daur ulang global.
            </p>
        </div>

        {{-- Scrollable Container --}}
        <div class="flex gap-6 overflow-x-auto no-scrollbar snap-x pb-8 -mx-4 px-4 sm:mx-0 sm:px-0">
            @forelse($articles as $art)
            <a href="{{ $art->content }}" target="_blank" class="min-w-[320px] max-w-[320px] shrink-0 snap-start bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden group cursor-pointer">
                
                {{-- Image --}}
                <div class="w-full h-48 bg-[#e2e8f0] relative overflow-hidden">
                    <img src="{{ $art->thumbnail_url ? asset('storage/' . $art->thumbnail_url) : 'https://placehold.co/320x180?text=Artikel' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                </div>
                
                {{-- Content --}}
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-brand/10 text-brand px-2 py-1 rounded text-[9px] font-bold uppercase tracking-widest">
                            Artikel & Tips
                        </span>
                        <span class="text-[11px] text-gray-400 font-medium">{{ $art->published_at ? $art->published_at->diffForHumans() : '' }}</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-3 group-hover:text-brand transition-colors leading-snug line-clamp-2">
                        {{ $art->title }}
                    </h3>
                    
                    <p class="text-gray-500 text-sm mb-6 leading-relaxed line-clamp-3">
                        {{ $art->excerpt }}
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <span class="text-brand text-xs font-bold flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                            Baca Selengkapnya <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </span>
                    </div>
                </div>
            </a>
            @empty
                <div class="w-full py-12 text-center text-gray-500 font-semibold">
                    Belum ada artikel & tips yang tersedia.
                </div>
            @endforelse
        </div>
        
    </div>
</section>
