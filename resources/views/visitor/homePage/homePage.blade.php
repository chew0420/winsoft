<!DOCTYPE html>
<html>
<head>
    <title>Winsoft Solution</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f8f9fa;
        }

        /* top nav bar */
        .navbar {
            background: white;
            padding: 12px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar img {
            height: 35px;
        }
        .navbar a {
            text-decoration: none;
            margin-left: 20px;
        }

        /* page nav bar */
        .second-nav {
            background: #e42b2b;
            padding: 12px 0;
            display: flex;
            justify-content: center;
            gap: 5%;
        }
        .second-nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            padding: 5px 15px;
        }
        .second-nav a:hover {
            background: white;
            color: #e42b2b;
            border-radius: 5px;
        }
        .second-nav a.active {
            background: white;
            color: #e42b2b;
            border-radius: 5px;
            padding: 5px 15px;
            font-weight: bold;
            transform: scale(1.3);
        }

        /* banner */
        .banner {
            width: 100%;
            overflow: hidden;
        }
        .banner img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* category and top product section */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .product-card h3 {
            margin: 0 0 10px;
        }
        .price {
            color: #28a745;
            font-size: 20px;
            font-weight: bold;
        }

        /* footer */
        .footer {
            background: #343a40;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- top nav bar -->
    <div class="navbar">
        <a href="/"><img src="img/winsoftlogo.png" alt="Winsoft Logo""></a>
        <div>
            <a href="/">Home</a>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        </div>
    </div>

    <!-- page nav bar -->
    <div class="second-nav">
        <a href="/">Home</a>
        <a href="/shop" >Shopping</a>
        <a href="/service">Service</a>
        <a href="/contact">Contact Us</a>
        <a href="/locations">Store Location</a>
    </div>
    
    <!-- banner -->
    <div class="banner">
        <img src="img/banner.jpg" alt="Winsoft Banner">
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
    </div>
    
    <div class="footer">
        <p>&copy; 2026 Winsoft Solution Sdn Bhd. All rights reserved.</p>
        <p>📍 17, Jalan Cempaka 1, Taman Bunga Cempaka Biru, 86400 Parit Raja, Johor</p>
        <p>📞 012-3456789 | ✉️ tiam@winsoft.com.my</p>
    </div>
</body>
</html>