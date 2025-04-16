@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn'
        },
        buttonsStyling: false,
        didOpen: () => {
            const swal = Swal.getPopup();
            swal.style.color = '#3D0A05';

            const confirmBtn = swal.querySelector('.btn');
            confirmBtn.style.backgroundColor = '#3D0A05';
            confirmBtn.style.borderColor = '#3D0A05';
            confirmBtn.style.color = 'white';
        }
    });
</script>
@endif

@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn'
        },
        buttonsStyling: false,
        didOpen: () => {
            const swal = Swal.getPopup();
            swal.style.color = '#3D0A05';

            const confirmBtn = swal.querySelector('.btn');
            confirmBtn.style.backgroundColor = '#3D0A05';
            confirmBtn.style.borderColor = '#3D0A05';
            confirmBtn.style.color = 'white';
        }
    });
</script>
@endif

@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonColor: '#8B4513' // biar nyocok sama bg-brown lo
        });
    </script>
@endif
