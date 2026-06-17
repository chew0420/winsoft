<!DOCTYPE html>
<html>
<head>
    <title>Winsoft Solution</title>
    <link href="/css/customer.css'" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @if(isset($sections) && $sections->count() > 0)
        <!-- Render sections from page builder -->
        @foreach($sections as $section)
            {!! $section->render() !!}
        @endforeach
    @else
        <!-- Fallback content -->
        <div class="container">
            <div class="banner">
                <img src="{{ asset('/img/banner.jpg') }}" alt="Winsoft Banner" class="img-fluid">
            </div>
            
            <h2>🔥 Top Products</h2>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px; object-fit:cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px;">No Image</div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-danger fw-bold">RM {{ number_format($product->price, 2) }}</p>
                                <a href="{{ url('/customer/product/'.$product->product_id) }}" class="btn btn-primary btn-sm">View Product</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h2>Shop By Categories</h2>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <div style="font-size: 48px;">📁</div>
                                <a href="/shop?category={{ urlencode($category->name) }}" class="text-decoration-none">
                                    <h5 class="card-title mt-2">{{ $category->name }}</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</body>
</html>