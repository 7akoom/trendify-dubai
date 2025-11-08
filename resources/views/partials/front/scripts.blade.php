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

    function updateCartTotal() {
        let subtotal = 0;
        $('tbody tr').each(function() {
            let price = parseFloat($(this).find('.cart__price').text());
            if (!isNaN(price)) {
                subtotal += price;
            }
        });

        let shipping = subtotal > 0 ? {{ optional(\App\Models\Setting::first())->shipping_costs ?? 0 }} : 0;
        let total = subtotal + shipping;

        $('#cart-subtotal').text(total);
        $('#cart-total').text(total);
        $('#mobile-cart-total').text(total);
        $('#cart-page-subtotal').text(subtotal);
        $('#cart-page-total').text(total);
    }

    $(document).ready(function() {
        const csrf_token = '{{ csrf_token() }}';

        function sendUpdate(input) {
            let id = input.data('id');
            let qty = parseInt(input.val());

            if (isNaN(qty) || qty < 1) {
                qty = 1;
                input.val(qty);
            }

            let row = $('tr[data-id="' + id + '"]');
            let unitPrice = parseFloat(row.data('unit-price'));
            let totalPrice = (unitPrice * qty);

            row.find('.cart__price').text(totalPrice);

            updateCartTotal();

            $.ajax({
                url: '/cart/' + id,
                type: 'POST',
                data: {
                    qty: qty,
                    _token: csrf_token,
                    _method: 'PUT'
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم تحديث الكمية بنجاح',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#cart-count').text(response.cartCount);
                    $('#cart-total').text(response.cartTotal);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        $(document).on('input', '.qty', function () {
            sendUpdate($(this));
        });

        $(document).on('click', '.qtybtn', function () {
            let input = $(this).siblings('input.qty');
            let currentVal = parseInt(input.val());
            if ($(this).hasClass('qty-plus')) {
                input.val(currentVal + 1);
            } else if ($(this).hasClass('qty-minus') && currentVal > 1) {
                input.val(currentVal - 1);
            }
            sendUpdate(input);
        });
    });
</script>
<script>
    $(document).on('click', '.remove-item', function(e){
        e.preventDefault();
        
        let id = $(this).data('id');
        const csrf_token = '{{ csrf_token() }}';
        const row = $(`tr[data-id="${id}"]`);

        $.ajax({
            url: '/cart/' + id,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: csrf_token
            },
            success: function (response) {
                row.remove();

                Swal.fire({
                    icon: 'success',
                    title: 'تم حذف العنصر بنجاح',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#mobile-cart-count').text(response.cartCount);
                $('#cart-count').text(response.cartCount);
                $('#cart-total').text(response.cartTotal);
                updateCartTotal();
                if ($('tbody tr').length === 0) {
                $('#shipping_costs').text(0);
            }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $(document).on('click', '.add-cart', function(e){
        e.preventDefault();
        const csrf_token = '{{ csrf_token() }}';
        $.ajax({
            url: '/cart',
            type: 'POST',
            data: {
                product_id: $(this).data('id'),
                qty: 1,
                _token: csrf_token
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم إضافة المنتج إلى سلتك بنجاح',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#cart-count').text(response.cartCount);
                $('#mobile-cart-count').text(response.cartCount);
                $('#cart-total').text(response.cartTotal);
                $('#cart-page-subtotal').text(response.cartTotal);
                $('#cart-page-total').text(response.cartTotal);
                console.log(response.cartTotal);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
</script>

<script>
    document.getElementById('checkout-btn').addEventListener('click', function (e) {
        e.preventDefault();
        const isLoggedIn = @json(Auth::check());

        if (isLoggedIn) {
            window.location.href = "{{ route('checkout') }}";
        } else {
            let checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));
            checkoutModal.show();
        }
    });
</script>