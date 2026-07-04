@extends('layouts.master')
@section('title', 'Marketplace Limbah – Recyclink')
@section('content')
<div class="bg-gray-50 min-h-screen">
    {{-- Page Header --}}
    <div class="border-b border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight mb-2">Marketplace Limbah</h1>
            <p class="text-gray-500 text-sm md:text-base max-w-xl">
                Temukan limbah industri berkualitas dari seller terverifikasi untuk kebutuhan produksi berkelanjutan Anda.
            </p>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- SIDEBAR FILTER --}}
            <aside class="w-full lg:w-64 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900">Filter</h2>
                        <button id="btn-reset" class="text-sm font-semibold text-brand hover:text-brand-hover transition-colors">Reset</button>
                    </div>

                    {{-- Kategori Accordion --}}
                    <details class="group mb-5 border-b border-gray-100 pb-5" open>
                        <summary class="flex items-center justify-between font-bold text-gray-900 cursor-pointer list-none text-sm select-none">
                            Kategori
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="mt-4 space-y-3 max-h-48 overflow-y-auto pr-1">
                            @foreach($categories as $category)
                                <label class="flex items-center gap-3 cursor-pointer group/label">
                                    <input type="checkbox" value="{{ strtolower($category->category_name) }}" class="category-filter accent-brand w-4 h-4 rounded cursor-pointer border-gray-300 text-brand focus:ring-brand">
                                    <span class="text-sm text-gray-600 group-hover/label:text-gray-900 transition-colors">{{ $category->category_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </details>

                    {{-- Lokasi Accordion --}}
                    <details class="group mb-5 border-b border-gray-100 pb-5" open>
                        <summary class="flex items-center justify-between font-bold text-gray-900 cursor-pointer list-none text-sm select-none">
                            Lokasi
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="mt-4">
                            <div class="relative">
                                <input type="text" id="search-lokasi" placeholder="Cari kota..."
                                    class="w-full text-sm border border-gray-200 rounded-lg pl-9 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition placeholder-gray-400">
                                <i data-lucide="map-pin" class="w-4 h-4 text-gray-400 absolute left-3 top-3"></i>
                            </div>
                        </div>
                    </details>

                    {{-- Harga Accordion --}}
                    <details class="group mb-5 border-b border-gray-100 pb-5" open>
                        <summary class="flex items-center justify-between font-bold text-gray-900 cursor-pointer list-none text-sm select-none">
                            Harga
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="mt-4 flex items-center gap-2">
                            <div class="relative w-full">
                                <span class="absolute left-2.5 top-2.5 text-xs text-gray-400 font-medium">Rp</span>
                                <input type="number" id="harga-min" placeholder="Min"
                                    class="w-full text-sm border border-gray-200 rounded-lg pl-7 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition placeholder-gray-400 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                            <span class="text-gray-300 font-medium">–</span>
                            <div class="relative w-full">
                                <span class="absolute left-2.5 top-2.5 text-xs text-gray-400 font-medium">Rp</span>
                                <input type="number" id="harga-max" placeholder="Max"
                                    class="w-full text-sm border border-gray-200 rounded-lg pl-7 pr-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition placeholder-gray-400 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            </div>
                        </div>
                    </details>

                    {{-- Minimal Volume Accordion --}}
                    <details class="group mb-5 border-b border-gray-100 pb-5">
                        <summary class="flex items-center justify-between font-bold text-gray-900 cursor-pointer list-none text-sm select-none">
                            Minimal Volume
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="mt-4">
                            <input type="number" id="volume-min" placeholder="Contoh: 100"
                                class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition placeholder-gray-400 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </details>

                    {{-- Status Accordion --}}
                    <details class="group mb-5" open>
                        <summary class="flex items-center justify-between font-bold text-gray-900 cursor-pointer list-none text-sm select-none">
                            Status
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <div class="mt-4">
                            <label class="flex items-center gap-3 cursor-pointer group/label">
                                <input type="checkbox" id="filter-status" checked class="accent-brand w-4 h-4 rounded cursor-pointer border-gray-300 text-brand focus:ring-brand">
                                <span class="text-sm text-gray-600 group-hover/label:text-gray-900 transition-colors">Hanya Tersedia</span>
                            </label>
                        </div>
                    </details>

                    <button id="btn-apply"
                        class="w-full mt-2 bg-brand hover:bg-brand-hover text-white font-bold text-sm py-3 rounded-xl transition-all shadow-sm">
                        Terapkan
                    </button>
                </div>
            </aside>
            {{-- MAIN CONTENT --}}
            <div class="flex-1 min-w-0">
                {{-- TABS (Produk & Toko) --}}
                <div class="border-b border-gray-200 mb-6">
                    <nav class="-mb-px flex gap-8" aria-label="Tabs">
                        <button id="tab-produk" class="tab-btn active-tab border-brand text-brand border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2">
                            <i data-lucide="package" class="w-4 h-4"></i>
                            Produk
                        </button>
                        <button id="tab-toko" class="tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-1 text-sm font-medium flex items-center gap-2 transition-colors">
                            <i data-lucide="store" class="w-4 h-4"></i>
                            Toko
                        </button>
                    </nav>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <p id="result-count" class="text-sm text-gray-500">
                        Menampilkan <span class="font-semibold text-gray-800" id="count-number">{{ $listings->count() }}</span> <span id="count-label">produk limbah</span>
                    </p>
                    <div class="flex items-center gap-2 shrink-0">
                        <span class="text-sm text-gray-500">Urutkan:</span>
                        <select id="sort-select"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand transition cursor-pointer">
                            <option value="terbaru">Terbaru</option>
                            <option value="harga-asc">Harga Terendah</option>
                            <option value="harga-desc">Harga Tertinggi</option>
                            <option value="stok-desc">Volume Terbanyak</option>
                            <option value="jarak-asc">Jarak Terdekat (Simulasi)</option>
                        </select>
                    </div>
                </div>
                
                {{-- Produk Grid --}}
                <div id="card-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8"></div>
                
                {{-- Toko Grid --}}
                <div id="toko-grid" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8"></div>
                
                <div id="pagination" class="flex items-center justify-center gap-1.5 mt-8"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let state = { tab: 'produk', categories: [], searchLokasi:'', volumeMin:null, hargaMin:null, hargaMax:null, sort:'terbaru', page:1, perPage:9 };

    function debounce(fn, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    async function fetchData() {
        showSkeletons(state.tab);
        const params = new URLSearchParams();
        params.append('tab', state.tab);
        params.append('page', state.page);
        params.append('sort', state.sort);
        if (state.searchLokasi) params.append('lokasi', state.searchLokasi);
        if (state.volumeMin) params.append('volume_min', state.volumeMin);
        if (state.hargaMin) params.append('harga_min', state.hargaMin);
        if (state.hargaMax) params.append('harga_max', state.hargaMax);
        state.categories.forEach(cat => params.append('categories[]', cat));

        try {
            const res = await fetch(`/marketplace?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const result = await res.json();
            
            const isProd = state.tab === 'produk';
            document.getElementById('card-grid').classList.toggle('hidden', !isProd);
            document.getElementById('toko-grid').classList.toggle('hidden', isProd);

            if (isProd) {
                renderCards(result.data, result.total);
            } else {
                renderSellers(result.data, result.total);
            }
            renderPagination(result.total, result.last_page);
        } catch (err) {
            console.error("Error fetching data:", err);
        }
    }

    function showSkeletons(type) {
        const grid = document.getElementById(type === 'produk' ? 'card-grid' : 'toko-grid');
        let html = '';
        for(let i = 0; i < state.perPage; i++) {
            html += type === 'produk' ? `
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm animate-pulse flex flex-col">
                <div class="h-52 bg-gray-200 shrink-0"></div>
                <div class="p-4 flex-1 flex flex-col">
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                    <div class="h-6 bg-gray-200 rounded w-1/2 mb-4"></div>
                    <div class="mt-auto pt-3 border-t border-gray-100 flex justify-between">
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                    </div>
                </div>
            </div>` : `
            <div class="bg-white border border-gray-200 rounded-2xl p-5 animate-pulse flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gray-200 shrink-0"></div>
                <div class="flex-1">
                    <div class="h-5 bg-gray-200 rounded w-3/4 mb-2"></div>
                    <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                </div>
            </div>`;
        }
        grid.innerHTML = html;
        document.getElementById('pagination').innerHTML = '';
    }

    function renderCards(data, total) {
        const grid = document.getElementById('card-grid');
        document.getElementById('count-number').textContent = total;
        document.getElementById('count-label').textContent = 'produk limbah';
        
        if (data.length === 0) {
            grid.innerHTML = `<div class="col-span-3 text-center py-24 border border-dashed border-gray-200 rounded-2xl bg-white">
                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/></svg>
                <p class="text-sm text-gray-400">Tidak ada produk ditemukan.</p></div>`;
            return;
        }
        grid.innerHTML = data.map(l => `
            <a href="/marketplace/${l.id}" class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col">
                <div class="relative h-52 bg-gray-100 shrink-0 overflow-hidden">
                    <img src="${l.image}" alt="${l.title}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.style.display='none'">
                    <span class="absolute top-3 left-3 bg-brand text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-sm">${l.categoryLabel}</span>
                </div>
                <div class="p-4 flex flex-col grow">
                    <h5 class="text-base font-bold text-gray-900 line-clamp-2 leading-snug mb-1 group-hover:text-brand transition-colors">${l.title}</h5>
                    <div class="flex items-center gap-1 text-xs text-gray-400 mb-4">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>${l.city}</span>
                    </div>
                    <div class="grow"></div>
                    <div class="flex items-end justify-between gap-3">
                        <div>
                            <p class="text-xl font-bold text-brand leading-tight">
                                Rp ${l.price.toLocaleString('id-ID')} <span class="text-xs font-normal text-gray-400">/ ${l.unit}</span>
                            </p>
                            <div class="flex items-center gap-1 text-xs text-gray-400 mt-0.5">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                Stok: ${l.stock.toLocaleString('id-ID')} ${l.unit}
                            </div>
                        </div>
                        <span class="shrink-0 text-xs font-semibold border border-gray-200 text-gray-600 group-hover:bg-brand group-hover:text-white group-hover:border-brand px-4 py-1.5 rounded-lg transition-all">Detail</span>
                    </div>
                </div>
            </a>`).join('');
    }

    function renderSellers(data, total) {
        const grid = document.getElementById('toko-grid');
        document.getElementById('count-number').textContent = total;
        document.getElementById('count-label').textContent = 'toko';

        if (data.length === 0) {
            grid.innerHTML = `<div class="col-span-3 text-center py-24 border border-dashed border-gray-200 rounded-2xl bg-white">
                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <p class="text-sm text-gray-400">Tidak ada toko ditemukan.</p></div>`;
            return;
        }
        grid.innerHTML = data.map(s => `
            <div class="group bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col items-center text-center">
                <div class="w-20 h-20 rounded-full overflow-hidden mb-4 border-2 border-gray-100">
                    <img src="${s.avatar}" alt="${s.name}" class="w-full h-full object-cover">
                </div>
                <h5 class="text-base font-bold text-gray-900 mb-1">${s.name}</h5>
                <div class="flex items-center gap-1 text-xs text-gray-500 mb-2">
                    <i data-lucide="map-pin" class="w-3 h-3"></i> ${s.city}
                </div>
                <span class="inline-block bg-teal-50 text-teal-600 text-xs font-semibold px-2.5 py-1 rounded-md mb-4">${s.type}</span>
                <a href="/toko/${s.id}" class="block w-full text-sm font-semibold border border-brand text-brand hover:bg-brand hover:text-white py-2 rounded-xl transition-colors text-center">Lihat Toko</a>
            </div>
        `).join('');
        lucide.createIcons();
    }

    function renderPagination(total, totalPages) {
        const pg = document.getElementById('pagination');
        if (totalPages <= 1) { pg.innerHTML = ''; return; }
        const btn = (active, content, onclick, disabled=false) =>
            `<button onclick="${onclick}" ${disabled?'disabled':''} class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-medium transition-all ${active ? 'bg-brand text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:border-brand hover:text-brand'} disabled:opacity-40 disabled:cursor-not-allowed">${content}</button>`;
        let html = btn(false, '&#8249;', `goPage(${state.page-1})`, state.page===1);
        for (let i = 1; i <= totalPages; i++) {
            if (i===1 || i===totalPages || (i>=state.page-1 && i<=state.page+1))
                html += btn(i===state.page, i, `goPage(${i})`);
            else if (i===state.page-2 || i===state.page+2)
                html += `<span class="w-9 h-9 flex items-center justify-center text-gray-400 text-sm">…</span>`;
        }
        html += btn(false, '&#8250;', `goPage(${state.page+1})`, state.page===totalPages);
        pg.innerHTML = html;
    }

    window.goPage = function(p) {
        state.page = p;
        fetchData();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    function refresh() {
        state.page = 1;
        fetchData();
    }

    function initMarketplace() {
        const el = id => document.getElementById(id);
        if (!el('card-grid')) return;

        const toggleTabs = (tab) => {
            state.tab = tab;
            const isProd = tab === 'produk';
            el('tab-produk').className = isProd ? "tab-btn active-tab border-brand text-brand border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2" : "tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-1 text-sm font-medium flex items-center gap-2 transition-colors";
            el('tab-toko').className = !isProd ? "tab-btn active-tab border-brand text-brand border-b-2 py-4 px-1 text-sm font-bold flex items-center gap-2" : "tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 py-4 px-1 text-sm font-medium flex items-center gap-2 transition-colors";
            refresh();
        };

        el('tab-produk')?.addEventListener('click', () => toggleTabs('produk'));
        el('tab-toko')?.addEventListener('click', () => toggleTabs('toko'));

        document.querySelectorAll('.category-filter').forEach(cb => {
            cb.addEventListener('change', e => {
                const val = e.target.value;
                if(e.target.checked) state.categories.push(val);
                else state.categories = state.categories.filter(c => c !== val);
                refresh();
            });
        });

        // Use debounced functions for search/inputs to prevent database hammer
        const debouncedRefresh = debounce(refresh, 350);

        el('search-lokasi')?.addEventListener('input', e => { state.searchLokasi = e.target.value; debouncedRefresh(); });
        el('volume-min')?.addEventListener('input', e => { state.volumeMin = e.target.value ? parseFloat(e.target.value) : null; debouncedRefresh(); });
        el('harga-min')?.addEventListener('input', e => { state.hargaMin = e.target.value ? parseInt(e.target.value) : null; debouncedRefresh(); });
        el('harga-max')?.addEventListener('input', e => { state.hargaMax = e.target.value ? parseInt(e.target.value) : null; debouncedRefresh(); });
        el('sort-select')?.addEventListener('change', e => { state.sort = e.target.value; refresh(); });
        el('btn-apply')?.addEventListener('click', refresh);

        el('btn-reset')?.addEventListener('click', () => {
            state = { tab: 'produk', categories: [], searchLokasi:'', volumeMin:null, hargaMin:null, hargaMax:null, sort:'terbaru', page:1, perPage:9 };
            document.querySelectorAll('.category-filter').forEach(cb => cb.checked = false);
            ['search-lokasi', 'volume-min', 'harga-min', 'harga-max'].forEach(id => { if(el(id)) el(id).value = ''; });
            if(el('sort-select')) el('sort-select').value = 'terbaru';
            refresh();
        });

        refresh();
    }

    document.addEventListener('turbo:load', initMarketplace);
    if (document.readyState !== 'loading') {
        initMarketplace();
    } else {
        document.addEventListener('DOMContentLoaded', initMarketplace);
    }
</script>
@endpush
