@extends('admin.layouts.admin')

@section('title', 'Tambah Konten Edukasi - Recyclink')
@section('header_title', 'Tambah Konten Edukasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.education-contents.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-brand transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke Daftar
        </a>
        <h3 class="text-2xl font-bold text-gray-900 mt-4">Buat Konten Baru</h3>
    </div>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 lg:p-8">
        <form action="{{ route('admin.education-contents.store') }}" method="POST" enctype="multipart/form-data" id="education-form" onsubmit="prepareFormSubmit()">
            @csrf
            
            {{-- Hidden input for parsed content field --}}
            <input type="hidden" name="content" id="content_hidden_input">

            <div class="space-y-6">
                {{-- Tipe Konten --}}
                <div>
                    <label for="content_type" class="block text-sm font-bold text-gray-700 mb-2">Tipe Konten</label>
                    <select name="content_type" id="content_type" onchange="toggleFields()" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900 font-medium">
                        <option value="article" {{ old('content_type') == 'article' ? 'selected' : '' }}>Artikel & Tips</option>
                        <option value="video" {{ old('content_type') == 'video' ? 'selected' : '' }}>Video Edukasi</option>
                        <option value="guide" {{ old('content_type') == 'guide' ? 'selected' : '' }}>Panduan Pengelolaan Limbah</option>
                    </select>
                    @error('content_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Judul --}}
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Ketik judul konten..." required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900">
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Kategori Panduan (Guide Level) - Only for Guide --}}
                <div id="guide_level_container" class="hidden">
                    <label for="guide_level" class="block text-sm font-bold text-gray-700 mb-2">Kategori Panduan</label>
                    <select id="guide_level" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900 font-medium">
                        <option value="pemula">Pemula</option>
                        <option value="menengah">Menengah</option>
                        <option value="lanjutan">Lanjutan</option>
                    </select>
                </div>

                {{-- Deskripsi (Excerpt) - For Article & Guide --}}
                <div id="excerpt_container">
                    <label for="excerpt" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Ringkasan</label>
                    <textarea name="excerpt" id="excerpt" rows="3" placeholder="Ketik deskripsi singkat konten..." class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900">{{ old('excerpt') }}</textarea>
                    @error('excerpt') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Link input (Articles / Videos / Guides) --}}
                <div>
                    <label id="link_label" for="link_input" class="block text-sm font-bold text-gray-700 mb-2">Link Artikel & Tips</label>
                    <input type="url" id="link_input" placeholder="https://example.com/..." required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900">
                    <p class="text-xs text-gray-400 mt-1" id="link_hint">Masukkan URL eksternal artikel rujukan.</p>
                </div>

                {{-- Tanggal Penerbitan (Bulan & Tahun) --}}
                <div>
                    <label for="published_at" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Upload (Bulan & Tahun)</label>
                    <input type="date" name="published_at" id="published_at" value="{{ old('published_at', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900">
                    @error('published_at') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Gambar (Thumbnail) --}}
                <div>
                    <label for="thumbnail" class="block text-sm font-bold text-gray-700 mb-2">Gambar / Cover</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-all cursor-pointer">
                    @error('thumbnail') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 mb-2">Status Publikasi</label>
                    <select name="status" id="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand focus:ring focus:ring-brand/20 transition-all py-3 px-4 text-gray-900 font-medium">
                        <option value="draft">Draft (Simpan saja)</option>
                        <option value="published">Published (Langsung terbitkan)</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-8 flex items-center justify-end gap-6 mt-6 border-t border-gray-100">
                <a href="{{ route('admin.education-contents.index') }}" class="text-gray-700 font-bold hover:text-gray-900 px-2 py-2 transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-brand text-white font-bold rounded-xl hover:bg-brand-hover transition-all inline-flex items-center gap-2 shadow-sm">
                    <i data-lucide="check" class="w-4 h-4"></i> Simpan Konten
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFields() {
        const type = document.getElementById('content_type').value;
        document.getElementById('guide_level_container').classList.toggle('hidden', type !== 'guide');
        document.getElementById('excerpt_container').classList.toggle('hidden', type === 'video');
        document.getElementById('excerpt').required = (type !== 'video');

        const labels = {
            article: 'Link Artikel & Tips',
            video: 'Link Video Edukasi',
            guide: 'Link Panduan Pengelolaan Limbah'
        };
        document.getElementById('link_label').textContent = labels[type] || 'Link';
    }

    function prepareFormSubmit() {
        const type = document.getElementById('content_type').value;
        const link = document.getElementById('link_input').value;
        document.getElementById('content_hidden_input').value = (type === 'guide')
            ? `${document.getElementById('guide_level').value}|${link}`
            : link;
    }

    ['turbo:load', 'DOMContentLoaded'].forEach(ev => document.addEventListener(ev, toggleFields));
</script>
@endsection
