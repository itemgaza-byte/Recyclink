<!-- SweetAlert2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>

<div id="flash-messages" class="hidden">
    @if(session('success')) <span class="flash-success">{{ session('success') }}</span> @endif
    @if(session('error')) <span class="flash-error">{{ session('error') }}</span> @endif
    @if(session('info')) <span class="flash-info">{{ session('info') }}</span> @endif
    @if($errors->any()) <span class="flash-validation">Terdapat kesalahan pada input Anda</span> @endif
</div>

<script>
    document.addEventListener("turbo:load", initSweetAlerts);
    if (!window.Turbo) initSweetAlerts();

    function initSweetAlerts() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        const flashContainer = document.getElementById('flash-messages');
        if (!flashContainer) return;

        const success = flashContainer.querySelector('.flash-success');
        if (success) { Toast.fire({ icon: 'success', title: success.innerText }); success.remove(); }

        const error = flashContainer.querySelector('.flash-error');
        if (error) { Toast.fire({ icon: 'error', title: error.innerText }); error.remove(); }

        const info = flashContainer.querySelector('.flash-info');
        if (info) { Toast.fire({ icon: 'info', title: info.innerText }); info.remove(); }

        const validation = flashContainer.querySelector('.flash-validation');
        if (validation) { Toast.fire({ icon: 'error', title: validation.innerText }); validation.remove(); }
    }

    // Global Confirm Handler untuk elemen dengan data-confirm
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.hasAttribute('data-confirm')) {
            e.preventDefault();
            const form = e.target;
            const message = form.getAttribute('data-confirm');
            
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#14b8a6', // Warna brand Recyclink
                cancelButtonColor: '#ef4444', // Merah
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.removeAttribute('data-confirm'); // Hapus atribut agar tidak infinite loop
                    form.submit();
                }
            });
        }
    });
</script>
