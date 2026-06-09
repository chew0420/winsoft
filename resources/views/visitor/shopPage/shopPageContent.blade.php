<!DOCTYPE html>
<html>
    <head>
        <title>Winsoft Solution</title>
        <link href="css/visitor.css" rel="stylesheet"/>
    </head>
    <body>
        <!-- showing current category -->
        <div class="current-category">
            <h2>Category</h2>
            <h1 class="showing-catagory">
                @if($selected_category)
                    {{ $selected_category }}
                @else
                    ALL Product
                @endif
            </h1>
        </div>

        <!-- catagory filter -->
        <div class="category-nav">
            @foreach ($categories as $category)
            <a href="/shop?category={{ urlencode($category->name) }}" class="{{ $selected_category == $category->name ? 'active-category' : '' }}">{{ $category->name }}</a>
            @endforeach
        </div>
        
        <!-- product listing -->
        <div class="product-container">
            @if(count($products) > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <a href="/productDetail?{{ $product->product_id }}"" style="text-decoration: none; color: inherit;">
                    <div class="product-card">
                        @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">
                        @else
                        <div style="width:100%; height:150px; background:#eee; display:flex; align-items:center; justify-content:center;">No Image</div>
                        @endif
                        <h3>{{ $product->name }}</h3>
                        <p class="price">RM {{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="no-product">
                <p>No products found.</p>
            </div>
            @endif
        </div>
    </body>
</html>