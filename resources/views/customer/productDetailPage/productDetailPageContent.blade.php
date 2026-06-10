<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <style>
        /* product detail unique styles - no navbar styles here */
        .pd-wrapper {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* breadcrumb */
        .pd-breadcrumb {
            margin-bottom: 20px;
            font-size: 14px;
        }
        .pd-breadcrumb a {
            color: #666;
            text-decoration: none;
        }
        .pd-breadcrumb a:hover {
            color: #e42b2b;
        }
        .pd-breadcrumb span {
            color: #999;
        }

        /* product main section */
        .pd-main-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        /* product images */
        .pd-image-gallery {
            display: flex;
            flex-direction: column;
        }
        .pd-main-image {
            width: 100%;
            height: 400px;
            object-fit: contain;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        /* product info */
        .pd-info-section h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
        }

        .pd-price-box {
            margin-bottom: 20px;
        }
        .pd-current-price {
            font-size: 32px;
            color: #e42b2b;
            font-weight: bold;
        }

        .pd-description {
            margin-bottom: 20px;
            color: #555;
            line-height: 1.6;
        }

        .pd-meta-box {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            margin-bottom: 20px;
        }
        .pd-meta-item {
            display: flex;
            margin-bottom: 10px;
        }
        .pd-meta-label {
            width: 100px;
            color: #666;
        }
        .pd-meta-value {
            color: #333;
            font-weight: 500;
        }
        .pd-stock-in {
            color: #28a745;
            font-weight: bold;
        }
        .pd-stock-out {
            color: #dc3545;
            font-weight: bold;
        }

        /* quantity selector */
        .pd-quantity-section {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        .pd-quantity-label {
            font-weight: bold;
            color: #333;
        }
        .pd-quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .pd-qty-btn {
            width: 35px;
            height: 35px;
            background: #888787;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }
        .pd-qty-btn:hover {
            background: #686868;
        }
        .pd-qty-input {
            width: 50px;
            height: 35px;
            text-align: center;
            border: none;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }
        .pd-qty-input:focus {
            outline: none;
        }

        /* action buttons */
        .pd-action-buttons {
            display: flex;
            gap: 15px;
        }
        .pd-add-to-cart-btn {
            flex: 1;
            background: #e42b2b;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .pd-add-to-cart-btn:hover {
            background: #c41e1e;
        }
        .pd-buy-now-btn {
            flex: 1;
            background: #28a745;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .pd-buy-now-btn:hover {
            background: #218838;
        }

        /* related products */
        .pd-related-section {
            margin-top: 40px;
        }
        .pd-related-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .pd-related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        .pd-related-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .pd-related-card:hover {
            transform: translateY(-5px);
        }
        .pd-related-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .pd-related-card h4 {
            font-size: 14px;
            margin-bottom: 8px;
        }
        .pd-related-price {
            color: #e42b2b;
            font-weight: bold;
        }

        /* flash message */
        .pd-flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: pdSlideIn 0.3s ease;
        }
        .pd-flash-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .pd-flash-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        @keyframes pdSlideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* disabled button */
        .pd-add-to-cart-btn.pd-disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* responsive */
        @media (max-width: 768px) {
            .pd-main-section {
                grid-template-columns: 1fr;
            }
            .pd-related-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .pd-related-grid {
                grid-template-columns: 1fr;
            }
            .pd-action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- flash messages -->
     @if(session()->has('success'))
        <div class="pd-flash-message pd-flash-success">
            <i class="fas fa-check-circle"></i> {{ session()->get('success') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.pd-flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @elseif(session()->has('error'))
        <div class="pd-flash-message pd-flash-error">
            <i class="fas fa-exclamation-circle"></i> {{ session()->get('error') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.pd-flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @endif

    <div class="pd-wrapper">
        <!-- breadcrumb -->
        <div class="pd-breadcrumb">
            <a href="{{ url('/') }}">Home</a> / 
            <a href="{{ url('/customer/shop') }}">Shop</a> / 
            <span>{{ $product->name }}</span>
        </div>

        <!-- product main section -->
        <div class="pd-main-section">
            <!-- product images -->
            <div class="pd-image-gallery">
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="pd-main-image" id="pdMainImage">
                @else
                    <div class="pd-main-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image" style="font-size: 80px; color: #ccc;"></i>
                    </div>
                @endif
            </div>

            <!-- product info -->
            <div class="pd-info-section">
                <h1>{{ $product->name }}</h1>

                <div class="pd-price-box">
                    <span class="pd-current-price">RM {{ number_format($product->price, 2) }}</span>
                </div>

                <div class="pd-description">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="pd-meta-box">
                    <div class="pd-meta-item">
                        <div class="pd-meta-label">Availability:</div>
                        <div class="pd-meta-value">
                            @if($product->stock_quantity > 0)
                                <span class="pd-stock-in">
                                    <i class="fas fa-check-circle"></i> In Stock ({{ $product->stock_quantity }} units)
                                </span>
                            @else
                                <span class="pd-stock-out">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($product->stock_quantity > 0)
                <form method="post" action="{{ url('/customer/cart/add') }}" id="pdAddToCartForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">

                    <div class="pd-quantity-section">
                        <span class="pd-quantity-label">Quantity:</span>
                        <div class="pd-quantity-selector">
                            <button type="button" class="pd-qty-btn" onclick="pdDecrementQuantity()">-</button>
                            <input type="text" name="quantity" id="pdQuantity" class="pd-qty-input" value="1" readonly>
                            <button type="button" class="pd-qty-btn" onclick="pdIncrementQuantity()">+</button>
                        </div>
                        <span class="pd-stock-text">(Max {{ $product->stock_quantity }} available)</span>
                    </div>

                    <div class="pd-action-buttons">
                        <button type="submit" name="action" value="cart" class="pd-add-to-cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        <button type="submit" name="action" value="buy" class="pd-buy-now-btn"><i class="fas fa-bolt"></i> Buy Now</button>
                    </div>
                </form>
                @else
                <div class="pd-action-buttons">
                    <button class="pd-add-to-cart-btn pd-disabled" disabled><i class="fas fa-shopping-cart"></i> Out of Stock</button>
                </div>
                @endif
            </div>
        </div>

        <!-- related products -->
        @if(count($relatedProducts) > 0)
        <div class="pd-related-section">
            <h3 class="pd-related-title">You May Also Like</h3>
            <div class="pd-related-grid">
                @foreach($relatedProducts as $related)
                    <a href="{{ url('/product/'.$related->product_id) }}" class="pd-related-card">
                        @if($related->image)
                            <img src="{{ asset($related->image) }}" alt="{{ $related->name }}">
                        @else
                            <div style="width:100%; height:150px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-image" style="font-size: 40px; color:#ccc;"></i>
                            </div>
                        @endif
                        <h4>{{ Str::limit($related->name, 40) }}</h4>
                        <div class="pd-related-price">RM {{ number_format($related->price, 2) }}</div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    <script>
        const pdMaxStock = {{ $product->stock_quantity }};

        function pdIncrementQuantity(){
            let quantityInput = document.getElementById('pdQuantity');
            let currentValue = parseInt(quantityInput.value);
            if(currentValue < pdMaxStock) {
                quantityInput.value = currentValue + 1;
            } else {
                alert('Maximum quantity available is ' + pdMaxStock);
            }
        }

        function pdDecrementQuantity() {
            let quantityInput = document.getElementById('pdQuantity');
            let currentValue = parseInt(quantityInput.value);
            if(currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

    </script>
</body>
</html>