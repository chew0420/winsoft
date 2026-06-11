<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <style>
        .profile-wrapper {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
        }
        
        /* Sidebar styles */
        .profile-sidebar {
            width: 280px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            height: fit-content;
        }
        
        .sidebar-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            text-align: center;
            color: white;
        }
        
        .sidebar-avatar {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .sidebar-avatar i {
            font-size: 40px;
            color: #667eea;
        }
        
        .sidebar-header h3 {
            margin: 0;
            font-size: 18px;
        }
        
        .sidebar-header p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.8;
        }
        
        .sidebar-menu {
            padding: 10px 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a i {
            width: 25px;
            margin-right: 10px;
            color: #666;
        }
        
        .sidebar-menu a:hover {
            background: #f8f9fa;
            color: #e42b2b;
        }
        
        .sidebar-menu a.active {
            background: #e42b2b20;
            color: #e42b2b;
            border-right: 3px solid #e42b2b;
        }
        
        .sidebar-menu a.active i {
            color: #e42b2b;
        }
        
        /* Main content styles */
        .profile-content {
            flex: 1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 25px;
        }
        
        .content-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .content-header h2 {
            font-size: 24px;
            color: #333;
        }
        
        /* Order tabs */
        .order-tabs {
            display: flex;
            gap: 5px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .order-tab {
            padding: 10px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            color: #666;
            position: relative;
            text-decoration: none;
            display: inline-block;
        }
        
        .order-tab.active {
            color: #e42b2b;
            font-weight: bold;
        }
        
        .order-tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e42b2b;
        }
        
        .order-tab:hover {
            color: #e42b2b;
        }
        
        .badge-count {
            background: #e42b2b;
            color: white;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 11px;
            margin-left: 8px;
            display: inline-block;
        }
        
        /* Order cards */
        .order-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .order-header {
            background: #f8f9fa;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .order-id {
            font-weight: bold;
            color: #333;
        }
        
        .order-date {
            color: #666;
            font-size: 13px;
        }
        
        .order-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-to-pay { background: #ffc107; color: #333; }
        .status-to-ship { background: #17a2b8; color: white; }
        .status-to-receive { background: #007bff; color: white; }
        .status-completed { background: #28a745; color: white; }
        .status-cancelled { background: #dc3545; color: white; }
        
        .order-body {
            padding: 15px;
        }
        
        .order-product {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .order-product img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .order-product-info h4 {
            margin: 0 0 5px;
            font-size: 14px;
        }
        
        .order-product-price {
            color: #e42b2b;
            font-weight: bold;
        }
        
        .order-footer {
            background: #f8f9fa;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e0e0e0;
        }
        
        .order-total {
            font-weight: bold;
        }
        
        .received-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .received-btn:hover {
            background: #218838;
        }
        
        .empty-orders {
            text-align: center;
            padding: 50px;
            color: #666;
        }
        
        .empty-orders i {
            font-size: 60px;
            color: #ccc;
            margin-bottom: 15px;
        }
        
        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }
        
        .flash-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @media (max-width: 768px) {
            .profile-wrapper {
                flex-direction: column;
            }
            .profile-sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="profile-wrapper">
        <div class="profile-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>{{ $customer->name }}</h3>
                <p>{{ $customer->email }}</p>
            </div>
            <div class="sidebar-menu">
                <a href="{{ url('/customer/profile') }}">
                    <i class="fas fa-user"></i> My Account
                </a>
                <a href="{{ url('/customer/order') }}" class="active">
                    <i class="fas fa-shopping-bag"></i> My Purchase
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="profile-content">
            <div class="content-header">
                <h2>My Purchase</h2>
            </div>

            <!-- Order Status Tabs -->
            <div class="order-tabs">
                <a href="{{ url('/customer/orders?status=all') }}" class="order-tab {{ $current_status == 'all' ? 'active' : '' }}">
                    All Orders
                </a>
                <a href="{{ url('/customer/orders?status=to_pay') }}" class="order-tab {{ $current_status == 'to_pay' ? 'active' : '' }}">
                    To Pay
                    @if($counts['to_pay'] > 0)
                        <span class="badge-count">{{ $counts['to_pay'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/customer/orders?status=to_ship') }}" class="order-tab {{ $current_status == 'to_ship' ? 'active' : '' }}">
                    To Ship
                    @if($counts['to_ship'] > 0)
                        <span class="badge-count">{{ $counts['to_ship'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/customer/orders?status=to_receive') }}" class="order-tab {{ $current_status == 'to_receive' ? 'active' : '' }}">
                    To Receive
                    @if($counts['to_receive'] > 0)
                        <span class="badge-count">{{ $counts['to_receive'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/customer/orders?status=completed') }}" class="order-tab {{ $current_status == 'completed' ? 'active' : '' }}">
                    Completed
                </a>
                <a href="{{ url('/customer/orders?status=cancelled') }}" class="order-tab {{ $current_status == 'cancelled' ? 'active' : '' }}">
                    Cancelled
                </a>
            </div>

            <!-- Orders List -->
            @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Order #{{ str_pad($order->order_id, 6, '0', STR_PAD_LEFT) }}</span>
                            <span class="order-date"> | {{ date('d M Y, H:i', strtotime($order->created_at)) }}</span>
                        </div>
                        <div>
                            @php
                                $statusClass = '';
                                $statusText = '';
                                if($order->payment_status == 'unpaid') {
                                    $statusClass = 'status-to-pay';
                                    $statusText = 'To Pay';
                                } elseif(in_array($order->status, ['pending', 'processing'])) {
                                    $statusClass = 'status-to-ship';
                                    $statusText = 'To Ship';
                                } elseif(in_array($order->status, ['shipped', 'delivered'])) {
                                    $statusClass = 'status-to-receive';
                                    $statusText = 'To Receive';
                                } elseif($order->status == 'completed') {
                                    $statusClass = 'status-completed';
                                    $statusText = 'Completed';
                                } elseif($order->status == 'cancelled') {
                                    $statusClass = 'status-cancelled';
                                    $statusText = 'Cancelled';
                                }
                            @endphp
                            <span class="order-status {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                    </div>
                    <div class="order-body">
                        <div class="order-product">
                            @php
                                $product = App\Models\tbl_product::find($order->product_id);
                            @endphp
                            @if($product && $product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div style="width:60px; height:60px; background:#f0f0f0; border-radius:8px;"></div>
                            @endif
                            <div class="order-product-info">
                                <h4>{{ $order->product_name }}</h4>
                                <div>Quantity: {{ $order->quantity }}</div>
                                <div class="order-product-price">RM {{ number_format($order->unit_price, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="order-total">
                            Total: RM {{ number_format($order->total_price, 2) }}
                        </div>
                        @if(in_array($order->status, ['shipped', 'delivered']))
                            <button class="received-btn" onclick="markAsReceived({{ $order->order_id }})">
                                <i class="fas fa-check"></i> Received
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="pagination-wrapper" style="margin-top: 20px; text-align: center;">
                    {{ $orders->appends(['status' => $current_status])->links() }}
                </div>
            @else
                <div class="empty-orders">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>No orders found</h3>
                    <p>You haven't placed any orders yet.</p>
                    <a href="{{ url('/customer/shop') }}" class="btn" style="background: #e42b2b; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block;">Shop Now</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>