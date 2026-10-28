<!DOCTYPE html>
<html>
    <head>
        <title>Winsoft Solutions</title>
        <link href="/css/customer.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="shop-page">
            {{-- ==============================
                SHOP HERO
            =============================== --}}
            <section class="shop-hero">

                <div class="shop-main-container">

                    <div class="shop-hero-content">

                        <span class="shop-eyebrow">
                            WINsoft Solutions
                        </span>

                        <h1>
                            Explore Our Products
                        </h1>

                        <p>
                            Discover reliable technology products and solutions
                            selected for your everyday needs.
                        </p>

                    </div>

                </div>

            </section>


            {{-- ==============================
                CATEGORY FILTER
            =============================== --}}
            <section class="shop-filter-section">

                <div class="shop-main-container">

                    <div class="shop-filter-header">

                        <div>

                            <span class="shop-section-label">
                                Browse By
                            </span>

                            <h2>
                                Categories
                            </h2>

                        </div>

                    </div>


                    <div class="shop-category-list">

                        <a
                            href="{{ url('/customer/shop') }}"
                            class="shop-category-link
                            {{ !$selected_category ? 'active' : '' }}"
                        >
                            All Products
                        </a>


                        @foreach($categories as $category)

                            <a
                                href="/customer/shop?category={{ urlencode($category->name) }}"
                                class="shop-category-link
                                {{ $selected_category == $category->name ? 'active' : '' }}"
                            >
                                {{ $category->name }}
                            </a>

                        @endforeach

                    </div>

                </div>

            </section>


            {{-- ==============================
                PRODUCTS
            =============================== --}}
            <main class="shop-products-section">

                <div class="shop-main-container">

                    <div class="shop-products-header">

                        <div>

                            <span class="shop-section-label">
                                Showing
                            </span>

                            <h2>

                                @if($selected_category)

                                    {{ $selected_category }}

                                @else

                                    All Products

                                @endif

                            </h2>

                        </div>


                        <div class="shop-product-count">

                            <strong>
                                {{ count($products) }}
                            </strong>

                            {{ count($products) == 1 ? 'Product' : 'Products' }}

                        </div>

                    </div>


                    @if(count($products) > 0)

                        <div class="shop-products-grid">

                            @foreach($products as $product)

                                <a
                                    href="{{ url('/customer/product/'.$product->product_id) }}"
                                    class="shop-product-link"
                                >

                                    <article class="shop-product-card">

                                        {{-- IMAGE --}}
                                        <div class="shop-product-image">

                                            @if($product->image)

                                                <img
                                                    src="{{ asset($product->image) }}"
                                                    alt="{{ $product->name }}"
                                                >

                                            @else

                                                <div class="shop-no-image">
                                                    <span>
                                                        No Image
                                                    </span>
                                                </div>

                                            @endif


                                            <div class="shop-view-product">

                                                View Product

                                                <span>
                                                    →
                                                </span>

                                            </div>

                                        </div>


                                        {{-- INFORMATION --}}
                                        <div class="shop-product-info">

                                            <h3>
                                                {{ $product->name }}
                                            </h3>


                                            @if($product->description)

                                                <p class="shop-product-description">

                                                    {{
                                                        strlen($product->description) > 75
                                                        ? substr($product->description, 0, 75).'...'
                                                        : $product->description
                                                    }}

                                                </p>

                                            @else

                                                <p class="shop-product-description">
                                                    Discover more product information
                                                    and specifications.
                                                </p>

                                            @endif


                                            <div class="shop-product-bottom">

                                                <div class="shop-product-price">

                                                    <span>
                                                        RM
                                                    </span>

                                                    {{ number_format($product->price, 2) }}

                                                </div>


                                                <div class="shop-product-arrow">
                                                    →
                                                </div>

                                            </div>

                                        </div>

                                    </article>

                                </a>

                            @endforeach

                        </div>


                    @else

                        <div class="shop-empty-state">

                            <div class="shop-empty-icon">
                                ◻
                            </div>

                            <h3>
                                No products found
                            </h3>

                            <p>
                                There are currently no products available
                                under this category.
                            </p>

                            <a
                                href="{{ url('/customer/shop') }}"
                                class="shop-empty-button"
                            >
                                View All Products
                            </a>

                        </div>

                    @endif

                </div>

            </main>

        </div>
    </body>
</html>