<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solutions</title>
    <link href="/css/customer.css" rel="stylesheet"/>
</head>
<body>
    <div class="co-page">

    <div class="co-container">


        {{-- =====================================================
             PAGE HEADER
        ===================================================== --}}

        <div class="co-page-header">

            <div>

                <span class="co-eyebrow">
                    Secure Checkout
                </span>

                <h1>
                    Complete Your Order
                </h1>

                <p>
                    Review your delivery information,
                    products and payment method before placing your order.
                </p>

            </div>


            <a
                href="{{ url('/customer/cart') }}"
                class="co-back-cart"
            >
                ← Back to Cart
            </a>

        </div>



        {{-- =====================================================
             DELIVERY ADDRESS
        ===================================================== --}}

        <section class="co-address-card">

            <div class="co-section-heading">

                <div class="co-section-number">
                    1
                </div>


                <div>

                    <span class="co-section-label">
                        Delivery
                    </span>

                    <h2>
                        Delivery Address
                    </h2>

                </div>

            </div>


            <div class="co-address-content">

                <div class="co-address-person">

                    <strong>
                        {{ $customer->name }}
                    </strong>

                    <span>
                        {{ $customer->phone_number }}
                    </span>

                </div>


                <div class="co-address-text">

                    {{ $customer->address }}

                </div>


                <a
                    href="#"
                    class="co-change-address"
                >
                    Change
                </a>

            </div>


            <input
                type="hidden"
                id="shipping_address"
                value="{{ $customer->address }}"
            >

        </section>



        {{-- =====================================================
             MAIN CHECKOUT LAYOUT
        ===================================================== --}}

        <div class="co-layout">


            {{-- =================================================
                 LEFT COLUMN
            ================================================== --}}

            <div class="co-left-column">


                {{-- =============================================
                     PRODUCTS ORDERED
                ============================================== --}}

                <section class="co-card">

                    <div class="co-section-heading">

                        <div class="co-section-number">
                            2
                        </div>


                        <div>

                            <span class="co-section-label">
                                Your Order
                            </span>

                            <h2>
                                Products Ordered
                            </h2>

                        </div>

                    </div>



                    <div class="co-product-list">


                        @foreach($cartItems as $item)

                            <div class="co-product-item">


                                {{-- PRODUCT IMAGE --}}

                                <a
                                    href="{{ url('/customer/product/'.$item->product->product_id) }}"
                                    class="co-product-image"
                                >

                                    @if($item->product->image)

                                        <img
                                            src="{{ asset($item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                        >

                                    @else

                                        <div class="co-product-placeholder">
                                            No Image
                                        </div>

                                    @endif

                                </a>



                                {{-- PRODUCT DETAILS --}}

                                <div class="co-product-info">

                                    <a
                                        href="{{ url('/customer/product/'.$item->product->product_id) }}"
                                        class="co-product-name"
                                    >
                                        {{ $item->product->name }}
                                    </a>


                                    <div class="co-product-unit">

                                        RM
                                        {{ number_format($item->product->price, 2) }}

                                        <span>
                                            each
                                        </span>

                                    </div>

                                </div>



                                {{-- QUANTITY --}}

                                <div class="co-product-quantity">

                                    <span>
                                        Qty
                                    </span>

                                    <strong>
                                        {{ $item->quantity }}
                                    </strong>

                                </div>



                                {{-- SUBTOTAL --}}

                                <div class="co-product-subtotal">

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong>

                                        RM
                                        {{
                                            number_format(
                                                $item->product->price *
                                                $item->quantity,
                                                2
                                            )
                                        }}

                                    </strong>

                                </div>

                            </div>

                        @endforeach


                    </div>

                </section>



                {{-- =============================================
                     PAYMENT METHOD
                ============================================== --}}

                <section class="co-card">

                    <div class="co-section-heading">

                        <div class="co-section-number">
                            3
                        </div>


                        <div>

                            <span class="co-section-label">
                                Payment
                            </span>

                            <h2>
                                Payment Method
                            </h2>

                        </div>

                    </div>


                    <p class="co-payment-description">
                        Choose how you would like to pay for your order.
                    </p>



                    <div class="co-payment-options">


                        {{-- FPX --}}

                        <label
                            class="co-payment-option"
                            for="payment_fpx"
                        >

                            <input
                                type="radio"
                                name="payment_method_selector"
                                id="payment_fpx"
                                value="fpx"
                            >


                            <span class="co-payment-radio"></span>


                            <div class="co-payment-details">

                                <div class="co-payment-title">

                                    <strong>
                                        FPX Online Banking
                                    </strong>

                                    <span class="co-recommended">
                                        Recommended
                                    </span>

                                </div>


                                <p>
                                    Pay securely using Malaysian
                                    online banking.
                                </p>


                                <span class="co-payment-future">

                                    Payment gateway integration
                                    will be connected here.

                                </span>

                            </div>


                            <div class="co-payment-logo co-fpx-logo">
                                FPX
                            </div>

                        </label>



                        {{-- COD --}}

                        <label
                            class="co-payment-option"
                            for="payment_cod"
                        >

                            <input
                                type="radio"
                                name="payment_method_selector"
                                id="payment_cod"
                                value="cod"
                            >


                            <span class="co-payment-radio"></span>


                            <div class="co-payment-details">

                                <div class="co-payment-title">

                                    <strong>
                                        Cash on Delivery
                                    </strong>

                                </div>


                                <p>
                                    Pay when your order arrives.
                                </p>

                            </div>


                            <div class="co-payment-logo co-cod-logo">
                                COD
                            </div>

                        </label>

                    </div>

                </section>

            </div>



            {{-- =================================================
                 RIGHT COLUMN - SUMMARY
            ================================================== --}}

            <aside class="co-summary-card">


                <div class="co-summary-header">

                    <span>
                        Order Overview
                    </span>

                    <h2>
                        Order Summary
                    </h2>

                </div>



                <div class="co-summary-body">


                    <div class="co-summary-row">

                        <span>
                            Merchandise Subtotal
                        </span>

                        <strong>
                            RM {{ number_format($subtotal, 2) }}
                        </strong>

                    </div>



                    <div class="co-summary-row">

                        <span>
                            Shipping Fee
                        </span>

                        <strong>
                            RM {{ number_format($shipping, 2) }}
                        </strong>

                    </div>



                    <div class="co-summary-divider"></div>



                    <div class="co-summary-total">

                        <span>
                            Total Payment
                        </span>


                        <strong>

                            <span class="co-total-currency">
                                RM
                            </span>

                            {{ number_format($total, 2) }}

                        </strong>

                    </div>



                    <button
                        type="button"
                        class="co-place-order"
                        id="placeOrderBtn"
                    >

                        <span>
                            Place Order
                        </span>

                        <span>
                            →
                        </span>

                    </button>



                    <p class="co-order-note">

                        By placing your order,
                        you confirm that your delivery
                        and payment information is correct.

                    </p>

                </div>

            </aside>

        </div>

    </div>

</div>



<script>

    const selectedIds =
        '{{ $selectedIds }}';


    const shippingAddress =
        document
            .getElementById(
                'shipping_address'
            )
            .value;



    /* =====================================================
       CHECK SELECTED ITEMS
    ===================================================== */

    if(!selectedIds) {

        window.location.href =
            '{{ url("/customer/cart") }}';

    }



    /* =====================================================
       PLACE ORDER
    ===================================================== */

    document
        .getElementById(
            'placeOrderBtn'
        )
        .addEventListener(
            'click',
            function() {


                const selectedPayment =
                    document.querySelector(
                        'input[name="payment_method_selector"]:checked'
                    );


                if(!selectedPayment) {

                    alert(
                        'Please select a payment method.'
                    );

                    return;

                }


                const paymentMethod =
                    selectedPayment.value;



                /* =============================================
                   CREATE FORM
                ============================================== */

                const form =
                    document.createElement(
                        'form'
                    );


                form.method =
                    'POST';


                form.action =
                    '{{ url("/customer/placeOrder") }}';



                /* CSRF */

                const csrfInput =
                    document.createElement(
                        'input'
                    );

                csrfInput.type =
                    'hidden';

                csrfInput.name =
                    '_token';

                csrfInput.value =
                    '{{ csrf_token() }}';

                form.appendChild(
                    csrfInput
                );



                /* SELECTED IDS */

                const selectedInput =
                    document.createElement(
                        'input'
                    );

                selectedInput.type =
                    'hidden';

                selectedInput.name =
                    'selected_ids';

                selectedInput.value =
                    selectedIds;

                form.appendChild(
                    selectedInput
                );



                /* PAYMENT METHOD */

                const paymentInput =
                    document.createElement(
                        'input'
                    );

                paymentInput.type =
                    'hidden';

                paymentInput.name =
                    'payment_method';

                paymentInput.value =
                    paymentMethod;

                form.appendChild(
                    paymentInput
                );



                /* SHIPPING ADDRESS */

                const addressInput =
                    document.createElement(
                        'input'
                    );

                addressInput.type =
                    'hidden';

                addressInput.name =
                    'shipping_address';

                addressInput.value =
                    shippingAddress;

                form.appendChild(
                    addressInput
                );



                document.body.appendChild(
                    form
                );


                form.submit();

            }
        );

</script>
</body>
</html>