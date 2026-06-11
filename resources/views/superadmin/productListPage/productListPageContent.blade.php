<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/superadmin.css" rel="stylesheet"/>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    @if(session()->has('success'))
        <div class="flash-message flash-success">
            <i class="fas fa-check-circle"></i> {{ session()->get('success') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @elseif(session()->has('error'))
        <div class="flash-message flash-error">
            <i class="fas fa-exclamation-circle"></i> {{ session()->get('error') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @endif
    <div class="d-flex">
        <div class="main-content p-4" style="width: 100%;">
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-list-ul"></i> Product List</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ url('/superadmin/productList/addProduct') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Product</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $product->product_id }}</td>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    @else
                                        <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image" style="color: #ccc;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $product->name }}</strong><br>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </td>
                                <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td class="text-primary fw-bold">RM {{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->stock_quantity <= $product->min_stock_level)
                                        <span class="badge bg-warning text-dark">{{ $product->stock_quantity }} left</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', strtotime($product->created_at)) }}</td>
                                <td>
                                    <a href="{{ url('/superadmin/products/edit/'.$product->product_id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $product->product_id }})">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2">No products found</p>
                                        <a href="{{ url('/superadmin/products/create') }}" class="btn btn-primary btn-sm">Add Product</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function confirmDelete(productId) {
            if(confirm('Are you sure you want to delete this product?')) {
                var form = document.getElementById('deleteForm');
                form.action = '/superadmin/productList/delete/' + productId;
                form.submit();
            }
        }
    </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 