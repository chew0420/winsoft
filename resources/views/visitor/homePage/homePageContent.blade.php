<!DOCTYPE html>
<html>
<head>
    <title>Winsoft Solution</title>
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section-wrapper {
            margin-bottom: 40px;
            padding: 20px 0;
        }
        
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        
        .product-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 18px;
        }
        
        .btn {
            display: inline-block;
            padding: 8px 20px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        
        .btn:hover {
            background: #2980b9;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
        }
        
        .category-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        
        .category-card:hover {
            transform: translateY(-3px);
        }
        
        .category-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .category-card a {
            text-decoration: none;
            color: #2c3e50;
        }
        
        .featured-badge {
            background: #f39c12;
            color: white;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 12px;
            display: inline-block;
        }
        
        .hero-banner {
            padding: 80px 0;
            text-align: center;
            color: white;
            background-color: #2c3e50;
        }
    </style>
</head>
<body>
    @php
        // Check if we should use sections or fallback content
        $useSections = false;
        $sections = null;
        
        // Try to get the Visitor Home Page sections
        $page = App\Models\tbl_website_page::where('page_name', 'Visitor Home Page')->first();
        if($page) {
            $sections = App\Models\tbl_page_section::where('page_id', $page->page_id)
                        ->where('is_active', true)
                        ->orderBy('order')
                        ->get();
            
            if($sections->count() > 0) {
                $useSections = true;
            }
        }
    @endphp

    @if($useSections)
        <!-- Render sections from page builder -->
        @foreach($sections as $section)
            {!! $section->render() !!}
        @endforeach
    @else
        <!-- Fallback original content -->
        <div class="banner">
            <img src="{{ asset('img/banner.jpg') }}" alt="Winsoft Banner">
        </div>
        
        <div class="container">
            <h2>🔥 Top Products</h2>
            <div class="products">
                @php
                    $products = App\Models\tbl_product::where('status', 'active')->limit(8)->get();
                @endphp
                @foreach($products as $product)
                    <a href="{{ url('/customer/product/'.$product->product_id) }}" style="text-decoration: none; color: inherit;">
                        <div class="product-card">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width:100%; height:150px; object-fit:cover; border-radius:5px;">
                            @else
                                <div style="width:100%; height:150px; background:#ddd; display:flex; align-items:center; justify-content:center;">No Image</div>
                            @endif
                            <h3>{{ $product->name }}</h3>
                            <p class="price">RM {{ number_format($product->price, 2) }}</p>
                            <p>{{ substr($product->description, 0, 60) }}...</p>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <h2>Shop By Categories</h2>
            <div class="categories-grid">
                @php
                    $categories = App\Models\tbl_category::where('status', 'active')->get();
                @endphp
                @foreach($categories as $category)
                    <div class="category-card">
                        <a href="/shop?category={{ urlencode($category->name) }}">
                            <div class="category-icon">📁</div>
                            <h4>{{ $category->name }}</h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</body>
</html>