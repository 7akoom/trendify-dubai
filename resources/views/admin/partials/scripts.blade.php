@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'تمت العملية',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'حدث خطأ',
            text: "{{ session('error') }}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif

<script>
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        Swal.fire({
            title: 'هل أنت متأكد من الحذف؟',
            text: "هذا الإجراء لا يمكن التراجع عنه!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff0080',
            confirmButtonText: 'نعم، احذفه',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-form-' + id).submit();
            }
        });
    });
</script>

<script>
    const colorPicker = document.getElementById('hex_code_picker');
    const hexInput = document.getElementById('hex_code');
    const colorPreview = document.getElementById('color_preview');

    colorPicker.addEventListener('input', function () {
        hexInput.value = this.value;
        colorPreview.style.backgroundColor = this.value;
    });

    hexInput.addEventListener('input', function () {
        colorPicker.value = this.value;
        colorPreview.style.backgroundColor = this.value;
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-image').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const imageId = this.dataset.id;
                const container = this.closest('.position-relative');
                const radio = container.querySelector('input[type="radio"]');
                const isFeatured = radio && radio.checked;

                if (isFeatured) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'لا يمكن الحذف',
                        text: 'لا يمكنك حذف الصورة المميزة. الرجاء تحديد صورة مميزة أخرى قبل الحذف.',
                        confirmButtonText: 'حسنًا'
                    });
                    return;
                }

                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذفها!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/images/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        }).then(res => {
                            if (res.ok) {
                                container.remove();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'تم الحذف!',
                                    text: 'تم حذف الصورة بنجاح.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'خطأ',
                                    text: 'حدث خطأ أثناء الحذف، حاول مجددًا.'
                                });
                            }
                        });
                    }
                });
            });
        });
    });
</script>

