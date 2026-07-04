@php
    $faqs = [
        [
            'question' => 'Bagaimana sistem pembayaran aman (Escrow) bekerja?',
            'answer' => 'Dana yang dibayarkan pembeli akan ditahan oleh sistem Recyclink secara aman. Dana hanya akan diteruskan kepada penjual setelah pembeli melakukan konfirmasi penerimaan barang dan melakukan pengecekan kualitas sesuai dengan deskripsi yang tercantum saat transaksi.',
            'active' => true,
        ],
        [
            'question' => 'Apakah Recyclink menyediakan jasa pengangkutan limbah?',
            'answer' => 'Ya, kami menyediakan layanan logistik terintegrasi untuk memudahkan pengangkutan limbah dari lokasi penjual ke pembeli dengan biaya yang transparan dan dapat dilacak secara real-time.',
            'active' => false,
        ],
        [
            'question' => 'Apa yang harus dilakukan jika material tidak sesuai pesanan?',
            'answer' => 'Anda dapat mengajukan komplain melalui pusat resolusi kami dalam waktu maksimal 2x24 jam setelah barang diterima. Dana akan ditahan sementara tim kami membantu memediasi dan memberikan solusi terbaik.',
            'active' => false,
        ],
        [
            'question' => 'Bagaimana cara menjadi mitra penjual terverifikasi?',
            'answer' => 'Anda perlu melengkapi profil perusahaan, mengunggah dokumen legalitas bisnis, dan melewati proses verifikasi oleh tim internal Recyclink. Status terverifikasi akan meningkatkan kepercayaan pembeli secara signifikan.',
            'active' => false,
        ],
    ];
@endphp

<section class="py-16 bg-gray-50 border-t border-gray-100 min-h-[70vh] flex flex-col justify-center">
    <div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        {{-- Section Header --}}
        <div class="mb-10">
            <span class="inline-block bg-brand/10 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest mb-4">
                FAQ
            </span>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4 tracking-tight">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-gray-500 max-w-xl mx-auto text-base">
                Segala hal yang perlu Anda ketahui tentang penggunaan platform marketplace dan layanan logistik kami.
            </p>
        </div>

        {{-- Accordion --}}
        {{-- ponytail: use native HTML details/summary elements to remove JavaScript toggle code --}}
        <div class="space-y-4 text-left">
            @foreach($faqs as $index => $faq)
            <details class="group bg-white border border-gray-200 open:border-brand/30 open:shadow-sm rounded-xl overflow-hidden transition-all duration-300" {{ $faq['active'] ? 'open' : '' }}>
                <summary class="w-full px-6 py-5 flex items-center justify-between focus:outline-none list-none cursor-pointer">
                    <span class="font-bold text-gray-900 text-left">{{ $faq['question'] }}</span>
                    <i data-lucide="chevron-down" class="w-5 h-5 shrink-0 ml-4 text-gray-400 group-open:text-brand group-open:rotate-180 transition-transform duration-300"></i>
                </summary>
                <div class="px-6 pb-6">
                    <p class="text-gray-500 text-sm leading-relaxed">
                        {{ $faq['answer'] }}
                    </p>
                </div>
            </details>
            @endforeach
        </div>
        
        {{-- Contact Support --}}
        <div class="mt-12">
            <p class="text-sm text-gray-500 mb-4">Masih memiliki pertanyaan lain?</p>
            <a href="#" class="inline-flex items-center justify-center bg-brand text-white px-6 py-3 rounded-lg font-semibold hover:bg-brand-hover transition-colors">
                Hubungi Support 24/7
            </a>
        </div>
        
    </div>
</section>
