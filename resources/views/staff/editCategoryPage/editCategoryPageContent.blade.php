<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/staff.css" rel="stylesheet"/>
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
                <h2><i class="bi bi-pencil-square"></i> Edit Category</h2>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ url('/staff/categoryList') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to List</a>
            </div>

            <div class="card">
                <div class="card-header bg-white">
                    <i class="bi bi-info-circle"></i> Edit Category Information
                </div>
                <div class="card-body">
                    @if($productCount > 0)
                        <div class="alert alert-warning mb-3">This category contains <strong>{{ $productCount }}</strong> product(s).</div>
                    @endif
                    <form method="post" action="{{ url('/staff/categoryList/update/'.$category->category_id) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
            @if($productCount > 0)
                <div class="card mt-4">
                    <div class="card-header bg-white">
                        <i class="bi bi-box-seam"></i> Products in this category
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $index => $product)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td><strong>{{ $product->name }}</strong></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmRemove({{ $product->product_id }})">
                                                <i class="bi bi-eraser"></i> Remove from Category
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <form id="removeForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function confirmRemove(productId) {
            if(confirm('Remove this product from this category? The product will become uncategorized.')) {
                var form = document.getElementById('removeForm');
                form.action = '/staff/categoryList/removeProduct/' + productId;
                form.submit();
            }
        }
    </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>