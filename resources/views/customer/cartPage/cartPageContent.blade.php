<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solutions</title>
    <link href="/css/customer.css" rel="stylesheet"/>
</head>
<body>
    {{-- =====================================================
     FLASH MESSAGE
===================================================== --}}

@if(session()->has('success'))

    <div class="cart-toast cart-toast-success">

        <span class="cart-toast-icon">
            ✓
        </span>

        <span>
            {{ session()->get('success') }}
        </span>

    </div>

@elseif(session()->has('error'))

    <div class="cart-toast cart-toast-error">

        <span class="cart-toast-icon">
            !
        </span>

        <span>
            {{ session()->get('error') }}
        </span>

    </div>

@endif


<div class="cart-page">

    <div class="cart-main-container">


        {{-- =====================================================
             HEADER
        ===================================================== --}}

        <div class="cart-page-header">

            <div>

                <span class="cart-eyebrow">
                    Your Shopping Bag
                </span>

                <h1>
                    Shopping Cart
                </h1>

                <p>
                    Review your products before proceeding to checkout.
                </p>

            </div>


            <a
                href="{{ url('/customer/shop') }}"
                class="cart-continue-shopping"
            >
                ← Continue Shopping
            </a>

        </div>



        @if(count($cartItems) > 0)

            <div class="cart-layout">


                {{-- =====================================================
                     LEFT - CART ITEMS
                ===================================================== --}}

                <section class="cart-items-section">


                    {{-- SELECT ALL --}}

                    <div class="cart-select-bar">

                        <label class="cart-checkbox-label">

                            <input
                                type="checkbox"
                                id="selectAllCheckbox"
                            >

                            <span>
                                Select All
                            </span>

                        </label>


                        <span class="cart-item-total-label">

                            {{ count($cartItems) }}
                            {{ count($cartItems) == 1 ? 'Product' : 'Products' }}

                        </span>

                    </div>



                    {{-- PRODUCTS --}}

                    <div class="cart-items-list">

                        @foreach($cartItems as $item)

                            <article
                                class="cart-item-card"
                                id="row-{{ $item->cart_id }}"
                            >


                                {{-- CHECKBOX --}}

                                <div class="cart-item-check">

                                    <input
                                        type="checkbox"
                                        class="item-checkbox"
                                        data-price="{{ $item->product->price }}"
                                        data-quantity="{{ $item->quantity }}"
                                    >

                                </div>



                                {{-- PRODUCT IMAGE --}}

                                <a
                                    href="{{ url('/customer/product/'.$item->product->product_id) }}"
                                    class="cart-product-image"
                                >

                                    @if($item->product->image)

                                        <img
                                            src="{{ asset($item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                        >

                                    @else

                                        <div class="cart-image-placeholder">
                                            No Image
                                        </div>

                                    @endif

                                </a>



                                {{-- PRODUCT DETAILS --}}

                                <div class="cart-product-details">

                                    <a
                                        href="{{ url('/customer/product/'.$item->product->product_id) }}"
                                        class="cart-product-name"
                                    >
                                        {{ $item->product->name }}
                                    </a>


                                    <div class="cart-product-unit-price">

                                        RM
                                        {{ number_format($item->product->price, 2) }}

                                        <span>
                                            each
                                        </span>

                                    </div>



                                    {{-- QUANTITY --}}

                                    <div class="cart-quantity-row">

                                        <span>
                                            Quantity
                                        </span>


                                        <div class="cart-quantity-control">

                                            <button
                                                type="button"
                                                onclick="updateQuantity(
                                                    {{ $item->cart_id }},
                                                    'decrease'
                                                )"
                                            >
                                                −
                                            </button>


                                            <input
                                                type="text"
                                                id="qty-{{ $item->cart_id }}"
                                                value="{{ $item->quantity }}"
                                                readonly
                                            >


                                            <button
                                                type="button"
                                                onclick="updateQuantity(
                                                    {{ $item->cart_id }},
                                                    'increase'
                                                )"
                                            >
                                                +
                                            </button>

                                        </div>

                                    </div>

                                </div>



                                {{-- RIGHT SIDE --}}

                                <div class="cart-item-right">


                                    <div class="cart-subtotal-label">
                                        Subtotal
                                    </div>


                                    <div
                                        class="cart-subtotal
                                        subtotal-{{ $item->cart_id }}"
                                    >

                                        RM
                                        {{
                                            number_format(
                                                $item->product->price *
                                                $item->quantity,
                                                2
                                            )
                                        }}

                                    </div>


                                    <a
                                        href="{{ url('/customer/cart/remove/'.$item->cart_id) }}"
                                        class="cart-remove-button"
                                        onclick="return confirm(
                                            'Remove this item from cart?'
                                        )"
                                    >
                                        Remove
                                    </a>

                                </div>


                            </article>

                        @endforeach

                    </div>

                </section>



                {{-- =====================================================
                     RIGHT - SUMMARY
                ===================================================== --}}

                <aside class="cart-summary-card">

                    <div class="cart-summary-header">

                        <span class="cart-summary-label">
                            Checkout
                        </span>

                        <h2>
                            Order Summary
                        </h2>

                    </div>



                    <div class="cart-summary-content">


                        <div class="cart-summary-row">

                            <span>
                                Selected Items
                                (<span id="selectedItemCount">0</span>)
                            </span>

                            <strong>
                                RM
                                <span id="selectedTotalPrice">
                                    0.00
                                </span>
                            </strong>

                        </div>



                        <div class="cart-summary-row">

                            <span>
                                Shipping
                            </span>

                            <strong>
                                RM
                                <span id="shippingAmount">
                                    0.00
                                </span>
                            </strong>

                        </div>



                        <div class="cart-summary-divider"></div>



                        <div class="cart-summary-total">

                            <span>
                                Total
                            </span>

                            <strong>

                                <span class="cart-total-currency">
                                    RM
                                </span>

                                <span id="grandTotal">
                                    0.00
                                </span>

                            </strong>

                        </div>



                        <form
                            id="checkoutForm"
                            method="POST"
                            action="{{ url('/customer/checkout') }}"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="selected_ids"
                                id="selectedIdsInput"
                            >

                        </form>



                        <button
                            type="button"
                            id="checkoutBtn"
                            class="cart-checkout-button disabled"
                        >

                            Proceed to Checkout

                            <span>
                                →
                            </span>

                        </button>



                        <div class="cart-summary-note">

                            Shipping fee of RM10.00 applies
                            when at least one product is selected.

                        </div>

                    </div>

                </aside>

            </div>



        @else

            {{-- =====================================================
                 EMPTY CART
            ===================================================== --}}

            <div class="cart-empty-state">

                <div class="cart-empty-icon">
                    🛒
                </div>

                <span class="cart-empty-label">
                    Your Cart
                </span>

                <h2>
                    Your cart is empty
                </h2>

                <p>
                    It looks like you haven't added
                    any products to your cart yet.
                </p>


                <a
                    href="{{ url('/customer/shop') }}"
                    class="cart-shop-button"
                >
                    Explore Products →
                </a>

            </div>

        @endif


    </div>

</div>



<script>

    const selectAllCheckbox =
        document.getElementById(
            'selectAllCheckbox'
        );

    const itemCheckboxes =
        document.querySelectorAll(
            '.item-checkbox'
        );

    const selectedItemCountSpan =
        document.getElementById(
            'selectedItemCount'
        );

    const selectedTotalPriceSpan =
        document.getElementById(
            'selectedTotalPrice'
        );

    const shippingAmountSpan =
        document.getElementById(
            'shippingAmount'
        );

    const grandTotalSpan =
        document.getElementById(
            'grandTotal'
        );

    const checkoutBtn =
        document.getElementById(
            'checkoutBtn'
        );


    const SHIPPING_COST = 10.00;



    /* =====================================================
       UPDATE TOTAL
    ===================================================== */

    function updateTotal() {

        const selectedItems =
            document.querySelectorAll(
                '.item-checkbox:checked'
            );


        let totalItems = 0;
        let totalPrice = 0;


        selectedItems.forEach(
            checkbox => {

                const price =
                    parseFloat(
                        checkbox.getAttribute(
                            'data-price'
                        )
                    );

                const quantity =
                    parseInt(
                        checkbox.getAttribute(
                            'data-quantity'
                        )
                    );


                totalItems += quantity;

                totalPrice +=
                    price * quantity;

            }
        );


        if(selectedItemCountSpan) {

            selectedItemCountSpan.innerText =
                totalItems;

        }


        if(selectedTotalPriceSpan) {

            selectedTotalPriceSpan.innerText =
                totalPrice.toFixed(2);

        }


        const shipping =
            totalItems > 0
                ? SHIPPING_COST
                : 0;


        if(shippingAmountSpan) {

            shippingAmountSpan.innerText =
                shipping.toFixed(2);

        }


        const grandTotal =
            totalPrice + shipping;


        if(grandTotalSpan) {

            grandTotalSpan.innerText =
                grandTotal.toFixed(2);

        }


        if(checkoutBtn) {

            if(totalItems > 0) {

                checkoutBtn.classList.remove(
                    'disabled'
                );

            } else {

                checkoutBtn.classList.add(
                    'disabled'
                );

            }

        }

    }



    /* =====================================================
       SELECT ALL
    ===================================================== */

    if(selectAllCheckbox) {

        selectAllCheckbox.addEventListener(
            'change',
            function() {

                itemCheckboxes.forEach(
                    checkbox => {

                        checkbox.checked =
                            selectAllCheckbox.checked;

                    }
                );

                updateTotal();

            }
        );

    }



    /* =====================================================
       INDIVIDUAL CHECKBOX
    ===================================================== */

    itemCheckboxes.forEach(
        checkbox => {

            checkbox.addEventListener(
                'change',
                function() {

                    const allChecked =
                        [...itemCheckboxes]
                        .every(
                            item =>
                                item.checked
                        );


                    if(selectAllCheckbox) {

                        selectAllCheckbox.checked =
                            allChecked;

                    }


                    updateTotal();

                }
            );

        }
    );


    updateTotal();



    /* =====================================================
       UPDATE QUANTITY
    ===================================================== */

    function updateQuantity(
        cartId,
        action
    ) {

        const quantityInput =
            document.getElementById(
                'qty-' + cartId
            );


        let currentQty =
            parseInt(
                quantityInput.value
            );


        let newQty =
            currentQty;


        if(action === 'increase') {

            newQty =
                currentQty + 1;

        }


        if(action === 'decrease') {

            newQty =
                currentQty - 1;

        }


        if(newQty < 1) {

            return;

        }


        fetch(
            '{{ url("/customer/cart/update") }}',
            {

                method: 'POST',

                headers: {

                    'Content-Type':
                        'application/json',

                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}'

                },

                body: JSON.stringify({

                    cart_id:
                        cartId,

                    quantity:
                        newQty

                })

            }
        )

        .then(
            response =>
                response.json()
        )

        .then(
            data => {

                if(data.success) {

                    location.reload();

                }

            }
        );

    }



    /* =====================================================
       CHECKOUT
    ===================================================== */

    if(checkoutBtn) {

        checkoutBtn.addEventListener(
            'click',
            function() {

                if(
                    checkoutBtn.classList
                        .contains('disabled')
                ) {

                    return;

                }


                const selectedItems = [];


                document
                    .querySelectorAll(
                        '.item-checkbox:checked'
                    )
                    .forEach(
                        checkbox => {

                            const row =
                                checkbox.closest(
                                    '.cart-item-card'
                                );

                            const cartId =
                                row.id.replace(
                                    'row-',
                                    ''
                                );


                            selectedItems.push(
                                cartId
                            );

                        }
                    );


                if(selectedItems.length > 0) {

                    document
                        .getElementById(
                            'selectedIdsInput'
                        )
                        .value =
                            selectedItems.join(',');


                    document
                        .getElementById(
                            'checkoutForm'
                        )
                        .submit();

                }

            }
        );

    }



    /* =====================================================
       AUTO HIDE TOAST
    ===================================================== */

    setTimeout(
        function() {

            const toast =
                document.querySelector(
                    '.cart-toast'
                );


            if(toast) {

                toast.style.opacity =
                    '0';


                setTimeout(
                    function() {

                        toast.remove();

                    },
                    300
                );

            }

        },
        3000
    );

</script>
</body>
</html>