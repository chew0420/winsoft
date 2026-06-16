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
    <style>
    .order-tabs {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 5px;
    }
    
    .order-tab {
        padding: 8px 16px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        color: #666;
        text-decoration: none;
        display: inline-block;
        border-radius: 5px 5px 0 0;
        transition: all 0.3s;
    }
    
    .order-tab:hover {
        background: #f0f0f0;
        color: #333;
    }
    
    .order-tab.active {
        color: #e42b2b;
        font-weight: bold;
        border-bottom: 2px solid #e42b2b;
    }
    
    .badge-count {
        background: #e42b2b;
        color: white;
        border-radius: 20px;
        padding: 1px 8px;
        font-size: 11px;
        margin-left: 5px;
        display: inline-block;
    }
    
    .order-tab.active .badge-count {
        background: #e42b2b;
    }
    
    .order-tab:not(.active) .badge-count {
        background: #6c757d;
    }

    .order-item-name{
        font-size: 18px;
        font-weight: bold;
    }
</style>
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
                <h2><i class="bi bi-cart"></i> Order Management</h2>
            </div>

            <!-- Filter Tabs -->
            <div class="order-tabs mb-4">
                <a href="{{ url('/superadmin/orderList?status=all') }}" class="order-tab {{ $current_status == 'all' ? 'active' : '' }}">
                    All Orders
                    <span class="badge-count">{{ $counts['all'] }}</span>
                </a>
                <a href="{{ url('/superadmin/orderList?status=to_pay') }}" class="order-tab {{ $current_status == 'to_pay' ? 'active' : '' }}">
                    To Pay
                    @if($counts['to_pay'] > 0)
                        <span class="badge-count">{{ $counts['to_pay'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/superadmin/orderList?status=to_ship') }}" class="order-tab {{ $current_status == 'to_ship' ? 'active' : '' }}">
                    To Ship
                    @if($counts['to_ship'] > 0)
                        <span class="badge-count">{{ $counts['to_ship'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/superadmin/orderList?status=to_receive') }}" class="order-tab {{ $current_status == 'to_receive' ? 'active' : '' }}">
                    To Receive
                    @if($counts['to_receive'] > 0)
                        <span class="badge-count">{{ $counts['to_receive'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/superadmin/orderList?status=completed') }}" class="order-tab {{ $current_status == 'completed' ? 'active' : '' }}">
                    Completed
                    @if($counts['completed'] > 0)
                        <span class="badge-count">{{ $counts['completed'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/superadmin/orderList?status=cancelled') }}" class="order-tab {{ $current_status == 'cancelled' ? 'active' : '' }}">
                    Cancelled
                    @if($counts['cancelled'] > 0)
                        <span class="badge-count">{{ $counts['cancelled'] }}</span>
                    @endif
                </a>
            </div>

            <!-- Orders Table -->
            <div class="card">
                <div class="card-body p-0">
                    @if(count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Order Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->order_id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>
                                            @if($order->order_items && count($order->order_items) > 0)
                                                {{ count($order->order_items) }} item(s)
                                            @else
                                                0 items
                                            @endif
                                        </td>
                                        <td class="fw-bold text-danger">RM {{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            @if($order->payment_status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($order->payment_status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($order->payment_status == 'failed')
                                                <span class="badge bg-danger">Failed</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = '';
                                                if($order->status == 'pending') $statusClass = 'bg-warning';
                                                elseif($order->status == 'processing') $statusClass = 'bg-info';
                                                elseif($order->status == 'shipped') $statusClass = 'bg-primary';
                                                elseif($order->status == 'delivered') $statusClass = 'bg-success';
                                                elseif($order->status == 'completed') $statusClass = 'bg-success';
                                                elseif($order->status == 'cancelled') $statusClass = 'bg-danger';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $order->order_id }}">
                                                <i class="bi bi-pencil"></i> Update
                                            </button>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $order->order_id }}">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Update Modal for each order -->
                                    <div class="modal fade" id="updateModal{{ $order->order_id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Order #{{ $order->order_id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="post" action="{{ url('/superadmin/orderList/updateOrderStatus/'.$order->order_id) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Order Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3" id="trackingNumberField{{ $order->order_id }}" style="display: {{ $order->status == 'shipped' ? 'block' : 'none' }};">
                                                            <label class="form-label">Enter Tracking Number</label>
                                                            <input type="text" name="tracking_number" class="form-control" value="{{ $order->tracking_number }}" placeholder="Enter Tracking Number">
                                                        </div>
                                                        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                                                        <p><strong>Total Amount:</strong> RM {{ number_format($order->total_price, 2) }}</p>
                                                        <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- View Modal for each order -->
                                    <div class="modal fade" id="viewModal{{ $order->order_id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Order Details #{{ $order->order_id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Order Information -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                                                            <p><strong>Order Date:</strong> {{ date('d/m/Y H:i', strtotime($order->created_at)) }}</p>
                                                            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
                                                            <p><strong>Total Amount:</strong> RM {{ number_format($order->total_price, 2) }}</p>
                                                            <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'Not specified' }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Items Ordered - Card Format -->
                                                    <h6 class="mt-3"><strong>Items Ordered:</strong></h6>
                                                    <div class="order-items-container">
                                                        @if($order->order_items && count($order->order_items) > 0)
                                                            @foreach($order->order_items as $item)
                                                            <div class="order-item-card">
                                                                <div class="order-item-info">
                                                                    <div class="order-item-name">{{ $item['product_name'] }}</div>
                                                                    <div class="order-item-meta">
                                                                        <span><i class="bi bi-cart"></i>Quantity: {{ $item['quantity'] }} | </span>
                                                                        <span><i class="bi bi-tag"></i>Unit Price: RM{{ number_format($item['unit_price'], 2)}} | </span>
                                                                        <span><strong>Subtotal RM{{ number_format($item['unit_price'] * $item['quantity'], 2) }}</strong></span><br>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @else
                                                            <p class="text-muted">No items found</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                                            <p class="mt-2">No orders found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">No orders found</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('select[name="status"]').forEach(select => {
            select.addEventListener('change', function() {
                var modal = this.closest('.modal');
                var trackingNumberField = modal.querySelector('[id^="trackingNumberField"]');
                if(trackingNumberField) {
                    if(this.value === 'shipped') {
                        trackingNumberField.style.display = 'block';
                    } else {
                        trackingNumberField.style.display = 'none';
                    }
                }
            });
        });
    </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>