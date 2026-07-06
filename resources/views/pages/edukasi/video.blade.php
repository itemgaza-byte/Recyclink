<section class="py-16 bg-gray-50 border-t border-gray-100 min-h-[70vh] flex flex-col justify-center">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section Header --}}
        <div class="mb-10">
            <span class="inline-block bg-brand/10 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">
                VIDEO TUTORIAL
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">Panduan Visual Operasional</h2>
            <p class="text-gray-500 max-w-2xl text-lg">
                Pelajari proses teknis daur ulang industrial secara mendalam melalui rangkaian video tutorial eksklusif kami.
            </p>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($videos as $video)
            <a href="{{ $video->content }}" target="_blank" class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col overflow-hidden group cursor-pointer hover:-translate-y-1">
                
                {{-- Video Thumbnail --}}
                <div class="w-full h-48 bg-[#0a0a0a] relative flex items-center justify-center overflow-hidden">
                    <img src="{{ $video->thumbnail_url ? asset('storage/' . $video->thumbnail_url) : 'https://placehold.co/320x180?text=Video' }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500" alt="">
                    
                    {{-- Play Button --}}
                    <div class="w-12 h-12 bg-brand rounded-full flex items-center justify-center group-hover:scale-110 group-hover:bg-brand transition-all duration-300 shadow-lg relative z-10">
                        <i data-lucide="play" class="w-5 h-5 text-white ml-1"></i>
                    </div>
                </div>
                
                {{-- Content --}}
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand transition-colors leading-snug">
                        {{ $video->title }}
                    </h3>
                </div>
                
            </a>
            @empty
                <div class="col-span-3 py-12 text-center text-gray-500 font-semibold">
                    Belum ada video edukasi yang tersedia.
                </div>
            @endforelse
        </div>
        
    </div>
</section>
