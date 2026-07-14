{{-- Global Page Loader for fast UX --}}
<div id="universal-page-loader" class="fixed inset-0 bg-white/70 backdrop-blur-sm z-[999999] hidden flex-col items-center justify-center opacity-0" style="transition: opacity 0.1s ease;">
    <div class="relative w-16 h-16 flex items-center justify-center">
        <div class="absolute inset-0 border-4 border-gray-100 rounded-full"></div>
        <div class="absolute inset-0 border-4 border-brand rounded-full border-t-transparent animate-spin"></div>
        <svg class="w-6 h-6 text-brand absolute" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    </div>
    <p class="mt-4 text-sm font-bold text-gray-500 animate-pulse">Memuat data...</p>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('universal-page-loader');
        
        function showLoader() {
            if (!loader) return;
            loader.classList.remove('hidden');
            setTimeout(() => loader.classList.add('flex', 'opacity-100'), 10);
            // Safety: always hide after 8 seconds to prevent permanent spinner
            setTimeout(hideLoader, 8000);
        }

        function hideLoader() {
            if (!loader) return;
            loader.classList.remove('flex', 'opacity-100');
            loader.classList.add('hidden', 'opacity-0');
        }

        // Turbo lifecycle events
        document.addEventListener("turbo:visit", showLoader);
        document.addEventListener("turbo:submit-start", showLoader);
        document.addEventListener("turbo:load", hideLoader);
        document.addEventListener("turbo:frame-load", hideLoader);
        
        // Handle browser back/forward cache and normal page loads
        window.addEventListener('pageshow', hideLoader);
        
        // Hide on initial load in case leftover from previous page
        hideLoader();
    });
</script>
