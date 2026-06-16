<!DOCTYPE html>
<html>
    <head>
        <title>Winsoft Solution</title>
        <link href="css/visitor.css" rel="stylesheet"/>
    </head>
    <body>
        <!-- banner -->
        <div class="banner">
            <img src="/img/banner.jpg" alt="Winsoft Banner">
        </div>
        
        <div class="container">
            <h2>🔥 Top Products</h2>
            <div class="products">
                @foreach($products as $product)
                    <div class="product-card">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width:100%; height:150px; object-fit:cover; border-radius:5px;">
                        @else
                            <div style="width:100%; height:150px; background:#ddd; display:flex; align-items:center; justify-content:center;">No Image</div>
                        @endif
                        <h3>{{ $product->name }}</h3>
                        <p class="price">RM {{ number_format($product->price, 2) }}</p>
                        <p>{{ substr($product->description, 0, 60) }}...</p>
                        <a href="login.php" class="btn">Login to Buy</a>
                    </div>
                @endforeach
            </div>
            <h2>Shop By Categories</h2>
            <div class="products">
                @foreach($categories as $category)
                    <div class="product-card">
                        <a href="/shop?category={{ urlencode($category->name) }}">{{ $category->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </body>
</html>