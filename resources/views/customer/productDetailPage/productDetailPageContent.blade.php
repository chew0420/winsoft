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

    <div class="pd-toast pd-toast-success">

        <span class="pd-toast-icon">
            ✓
        </span>

        <div>
            {{ session()->get('success') }}
        </div>

    </div>

    <script>

        setTimeout(function() {

            const message =
                document.querySelector('.pd-toast');

            if(message) {

                message.style.opacity = '0';

                setTimeout(function() {
                    message.remove();
                }, 300);

            }

        }, 3000);

    </script>

@elseif(session()->has('error'))

    <div class="pd-toast pd-toast-error">

        <span class="pd-toast-icon">
            !
        </span>

        <div>
            {{ session()->get('error') }}
        </div>

    </div>

@endif



<div class="pd-page">

    <div class="pd-container">


        {{-- =====================================================
             BREADCRUMB
        ===================================================== --}}

        <nav class="pd-breadcrumb">

            <a href="{{ url('/customerHomePage') }}">
                Home
            </a>

            <span>
                /
            </span>

            <a href="{{ url('/customer/shop') }}">
                Shop
            </a>

            <span>
                /
            </span>

            <strong>
                {{ $product->name }}
            </strong>

        </nav>



        {{-- =====================================================
             PRODUCT MAIN
        ===================================================== --}}

        <section class="pd-product-layout">


            {{-- IMAGE SIDE --}}

            <div class="pd-product-visual">

                <div class="pd-image-box">

                    @if($product->image)

                        <img
                            src="{{ asset($product->image) }}"
                            alt="{{ $product->name }}"
                            class="pd-product-image"
                        >

                    @else

                        <div class="pd-image-placeholder">

                            <span>
                                No Image
                            </span>

                        </div>

                    @endif

                </div>

            </div>



            {{-- INFORMATION SIDE --}}

            <div class="pd-product-details">


                <span class="pd-product-label">
                    WINsoft Solutions
                </span>


                <h1>
                    {{ $product->name }}
                </h1>


                <div class="pd-price">

                    <span class="pd-currency">
                        RM
                    </span>

                    {{ number_format($product->price, 2) }}

                </div>



                {{-- STOCK --}}

                <div class="pd-stock-row">

                    <span class="pd-stock-title">
                        Availability
                    </span>


                    @if($product->stock_quantity > 0)

                        <span class="pd-stock-badge pd-in-stock">

                            <span class="pd-status-dot"></span>

                            In Stock

                        </span>


                        <span class="pd-stock-number">

                            {{ $product->stock_quantity }}
                            available

                        </span>

                    @else

                        <span class="pd-stock-badge pd-out-stock">

                            Out of Stock

                        </span>

                    @endif

                </div>



                {{-- DESCRIPTION --}}

                <div class="pd-description-block">

                    <h3>
                        Product Description
                    </h3>

                    <p>
                        {!! nl2br(e($product->description)) !!}
                    </p>

                </div>



                {{-- =====================================================
                     CART FORM
                ===================================================== --}}

                @if($product->stock_quantity > 0)

                    <form
                        method="POST"
                        action="{{ url('/customer/cart/add') }}"
                        id="pdAddToCartForm"
                    >

                        @csrf


                        <input
                            type="hidden"
                            name="product_id"
                            value="{{ $product->product_id }}"
                        >



                        {{-- QUANTITY --}}

                        <div class="pd-purchase-row">

                            <div class="pd-quantity-wrapper">

                                <label>
                                    Quantity
                                </label>


                                <div class="pd-quantity-selector">

                                    <button
                                        type="button"
                                        onclick="pdDecrementQuantity()"
                                        class="pd-qty-button"
                                    >
                                        −
                                    </button>


                                    <input
                                        type="text"
                                        name="quantity"
                                        id="pdQuantity"
                                        value="1"
                                        readonly
                                    >


                                    <button
                                        type="button"
                                        onclick="pdIncrementQuantity()"
                                        class="pd-qty-button"
                                    >
                                        +
                                    </button>

                                </div>

                            </div>



                            <div class="pd-max-stock">

                                Maximum:
                                {{ $product->stock_quantity }}

                            </div>

                        </div>



                        {{-- ACTION BUTTONS --}}

                        <div class="pd-actions">

                            <button
                                type="submit"
                                name="action"
                                value="cart"
                                class="pd-cart-button"
                            >

                                <span>
                                    Add to Cart
                                </span>

                                <span>
                                    →
                                </span>

                            </button>


                            <button
                                type="submit"
                                name="action"
                                value="buy"
                                class="pd-buy-button"
                            >

                                Buy Now

                            </button>

                        </div>

                    </form>


                @else

                    <button
                        class="pd-sold-out-button"
                        disabled
                    >

                        Currently Out of Stock

                    </button>

                @endif



                {{-- INFO POINTS --}}

                <div class="pd-service-points">

                    <div class="pd-service-item">

                        <strong>
                            Secure Purchase
                        </strong>

                        <span>
                            Safe and reliable checkout
                        </span>

                    </div>


                    <div class="pd-service-item">

                        <strong>
                            Customer Support
                        </strong>

                        <span>
                            Assistance whenever you need it
                        </span>

                    </div>

                </div>


            </div>

        </section>



        {{-- =====================================================
             RELATED PRODUCTS
        ===================================================== --}}

        @if(count($relatedProducts) > 0)

            <section class="pd-related-section">


                <div class="pd-related-header">

                    <div>

                        <span class="pd-related-label">
                            You Might Also Like
                        </span>

                        <h2>
                            Related Products
                        </h2>

                    </div>


                    <a
                        href="{{ url('/customer/shop') }}"
                        class="pd-view-all"
                    >
                        View All Products →
                    </a>

                </div>



                <div class="pd-related-grid">

                    @foreach($relatedProducts as $related)

                        <a
                            href="{{ url('/customer/product/'.$related->product_id) }}"
                            class="pd-related-link"
                        >

                            <article class="pd-related-card">


                                <div class="pd-related-image">

                                    @if($related->image)

                                        <img
                                            src="{{ asset($related->image) }}"
                                            alt="{{ $related->name }}"
                                        >

                                    @else

                                        <div class="pd-related-placeholder">

                                            No Image

                                        </div>

                                    @endif

                                </div>



                                <div class="pd-related-info">

                                    <h3>
                                        {{ Str::limit($related->name, 45) }}
                                    </h3>


                                    <div class="pd-related-bottom">

                                        <div class="pd-related-price">

                                            <span>
                                                RM
                                            </span>

                                            {{ number_format($related->price, 2) }}

                                        </div>


                                        <div class="pd-related-arrow">
                                            →
                                        </div>

                                    </div>

                                </div>

                            </article>

                        </a>

                    @endforeach

                </div>

            </section>

        @endif


    </div>

</div>



<script>

    const pdMaxStock =
        {{ $product->stock_quantity }};


    function pdIncrementQuantity() {

        const input =
            document.getElementById(
                'pdQuantity'
            );

        let value =
            parseInt(
                input.value
            );


        if(value < pdMaxStock) {

            input.value =
                value + 1;

        }

    }


    function pdDecrementQuantity() {

        const input =
            document.getElementById(
                'pdQuantity'
            );

        let value =
            parseInt(
                input.value
            );


        if(value > 1) {

            input.value =
                value - 1;

        }

    }

</script>
</body>
</html>