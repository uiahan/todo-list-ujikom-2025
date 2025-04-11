@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'btn btn-success'
        },
        buttonsStyling: false
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
            confirmButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });
</script>
@endif
