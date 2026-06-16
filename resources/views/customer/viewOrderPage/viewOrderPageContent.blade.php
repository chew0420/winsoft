<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
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
                <a href="{{ url('/customer/order?status=all') }}" class="order-tab {{ $current_status == 'all' ? 'active' : '' }}">
                    All Orders
                </a>
                <a href="{{ url('/customer/order?status=to_pay') }}" class="order-tab {{ $current_status == 'to_pay' ? 'active' : '' }}">
                    To Pay
                    @if($counts['to_pay'] > 0)
                        <span class="badge-count">{{ $counts['to_pay'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/customer/order?status=to_ship') }}" class="order-tab {{ $current_status == 'to_ship' ? 'active' : '' }}">
                    To Ship
                    @if($counts['to_ship'] > 0)
                        <span class="badge-count">{{ $counts['to_ship'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/customer/order?status=to_receive') }}" class="order-tab {{ $current_status == 'to_receive' ? 'active' : '' }}">
                    To Receive
                    @if($counts['to_receive'] > 0)
                        <span class="badge-count">{{ $counts['to_receive'] }}</span>
                    @endif
                </a>
                <a href="{{ url('/customer/order?status=completed') }}" class="order-tab {{ $current_status == 'completed' ? 'active' : '' }}">
                    Completed
                </a>
                <a href="{{ url('/customer/order?status=cancelled') }}" class="order-tab {{ $current_status == 'cancelled' ? 'active' : '' }}">
                    Cancelled
                </a>
            </div>

            <!-- Orders List -->
            @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Order #{{ $order->order_id }}</span>
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
                    
                    <!-- Decode order_items JSON and display each product -->
                    @php
                        $orderItems = json_decode($order->order_items, true);
                    @endphp
                    
                    @if($orderItems && count($orderItems) > 0)
                        @foreach($orderItems as $item)
                        <div class="order-body">
                            <div class="order-product">
                                @php
                                    $product = App\Models\tbl_product::find($item['product_id']);
                                @endphp
                                @if($product && $product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $item['product_name'] }}">
                                @else
                                    <div style="width:60px; height:60px; background:#f0f0f0; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="order-product-info">
                                    <p>{{ $item['product_name'] }}</p>
                                    <div class="order-product-quantity">x{{ $item['quantity'] }}</div>
                                </div>
                                <div class="order-product-right">
                                    <div class="order-product-price">RM {{ number_format($item['unit_price'], 2) }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    
                    <div class="order-footer">
                        <div class="order-total">
                            Order Total: <span>RM {{ number_format($order->total_price, 2) }}</span>
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