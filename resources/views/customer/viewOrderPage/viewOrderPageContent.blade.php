<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
</head>
<body>
<div class="account-page">
    <div class="account-container">

        <div class="account-page-header">
            <span class="account-eyebrow">Account</span>
            <h1>My Purchase</h1>
            <p>Track your orders, payment status and delivery progress.</p>
        </div>

        <div class="account-layout">

            {{-- Sidebar --}}
            <aside class="account-sidebar">
                <div class="account-user-card">
                    <div class="account-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="account-user-info">
                        <strong>{{ $customer->name }}</strong>
                        <span>{{ $customer->email }}</span>
                    </div>
                </div>

                <nav class="account-menu">
                    <a href="{{ url('/customer/profile') }}">
                        <span class="account-menu-icon"><i class="fas fa-user"></i></span>
                        <div>
                            <strong>My Account</strong>
                            <span>Personal information</span>
                        </div>
                    </a>

                    <a href="{{ url('/customer/order') }}" class="active">
                        <span class="account-menu-icon"><i class="fas fa-shopping-bag"></i></span>
                        <div>
                            <strong>My Purchase</strong>
                            <span>Orders and purchases</span>
                        </div>
                    </a>

                    <a href="{{ url('/customer/serviceRequests') }}">
                        <span class="account-menu-icon"><i class="fas fa-screwdriver-wrench"></i></span>
                        <div>
                            <strong>Service Requests</strong>
                            <span>Repair and support</span>
                        </div>
                    </a>
                </nav>
            </aside>

            {{-- Main --}}
            <main class="account-content">
                <section class="purchase-main-card">

                    <div class="purchase-header">
                        <div>
                            <span class="purchase-label">Order Management</span>
                            <h2>My Orders</h2>
                            <p>Check the latest status of your purchases.</p>
                        </div>
                    </div>

                    {{-- Tabs --}}
                    <div class="purchase-tabs">
                        <a href="{{ url('/customer/order?status=all') }}" class="purchase-tab {{ $current_status == 'all' ? 'active' : '' }}">
                            All Orders
                        </a>

                        <a href="{{ url('/customer/order?status=to_pay') }}" class="purchase-tab {{ $current_status == 'to_pay' ? 'active' : '' }}">
                            To Pay
                            @if($counts['to_pay'] > 0)
                                <span class="purchase-count">{{ $counts['to_pay'] }}</span>
                            @endif
                        </a>

                        <a href="{{ url('/customer/order?status=to_ship') }}" class="purchase-tab {{ $current_status == 'to_ship' ? 'active' : '' }}">
                            To Ship
                            @if($counts['to_ship'] > 0)
                                <span class="purchase-count">{{ $counts['to_ship'] }}</span>
                            @endif
                        </a>

                        <a href="{{ url('/customer/order?status=to_receive') }}" class="purchase-tab {{ $current_status == 'to_receive' ? 'active' : '' }}">
                            To Receive
                            @if($counts['to_receive'] > 0)
                                <span class="purchase-count">{{ $counts['to_receive'] }}</span>
                            @endif
                        </a>

                        <a href="{{ url('/customer/order?status=completed') }}" class="purchase-tab {{ $current_status == 'completed' ? 'active' : '' }}">
                            Completed
                        </a>

                        <a href="{{ url('/customer/order?status=cancelled') }}" class="purchase-tab {{ $current_status == 'cancelled' ? 'active' : '' }}">
                            Cancelled
                        </a>
                    </div>

                    {{-- Orders --}}
                    <div class="purchase-orders">
                        @if(count($orders) > 0)

                            @foreach($orders as $order)

                                @php
                                    $statusClass = '';
                                    $statusText = '';

                                    if($order->payment_status == 'unpaid') {
                                        $statusClass = 'purchase-status-pay';
                                        $statusText = 'To Pay';
                                    } elseif(in_array($order->status, ['pending', 'processing'])) {
                                        $statusClass = 'purchase-status-ship';
                                        $statusText = 'To Ship';
                                    } elseif(in_array($order->status, ['shipped', 'delivered'])) {
                                        $statusClass = 'purchase-status-receive';
                                        $statusText = 'To Receive';
                                    } elseif($order->status == 'completed') {
                                        $statusClass = 'purchase-status-completed';
                                        $statusText = 'Completed';
                                    } elseif($order->status == 'cancelled') {
                                        $statusClass = 'purchase-status-cancelled';
                                        $statusText = 'Cancelled';
                                    }

                                    $orderItems = json_decode($order->order_items, true);
                                @endphp

                                <article class="purchase-order-card">

                                    <div class="purchase-order-header">
                                        <div>
                                            <strong>Order #{{ $order->order_id }}</strong>
                                            <span>{{ date('d M Y, H:i', strtotime($order->created_at)) }}</span>
                                        </div>

                                        <span class="purchase-status {{ $statusClass }}">{{ $statusText }}</span>
                                    </div>

                                    <div class="purchase-product-list">
                                        @if($orderItems && count($orderItems) > 0)

                                            @foreach($orderItems as $item)
                                                @php
                                                    $product = App\Models\tbl_product::find($item['product_id']);
                                                @endphp

                                                <div class="purchase-product-item">

                                                    <a href="{{ url('/customer/product/'.$item['product_id']) }}" class="purchase-product-image">
                                                        @if($product && $product->image)
                                                            <img src="{{ asset($product->image) }}" alt="{{ $item['product_name'] }}">
                                                        @else
                                                            <div class="purchase-product-placeholder">No Image</div>
                                                        @endif
                                                    </a>

                                                    <div class="purchase-product-info">
                                                        <a href="{{ url('/customer/product/'.$item['product_id']) }}" class="purchase-product-name">
                                                            {{ $item['product_name'] }}
                                                        </a>
                                                        <span>Quantity: x{{ $item['quantity'] }}</span>
                                                    </div>

                                                    <div class="purchase-product-price">
                                                        <span>Unit Price</span>
                                                        <strong>RM {{ number_format($item['unit_price'], 2) }}</strong>
                                                    </div>

                                                </div>
                                            @endforeach

                                        @endif
                                    </div>

                                    <div class="purchase-order-footer">

                                        <div class="purchase-total">
                                            <span>Order Total</span>
                                            <strong>RM {{ number_format($order->total_price, 2) }}</strong>
                                        </div>

                                        @if(in_array($order->status, ['shipped', 'delivered']))
                                            <div class="purchase-actions">
                                                <p>Confirm receipt after you have checked the received items.</p>
                                                <button type="button" class="purchase-received-btn" onclick="markAsReceived({{ $order->order_id }})">
                                                    <i class="fas fa-check"></i> Received
                                                </button>
                                            </div>
                                        @endif

                                    </div>

                                </article>

                            @endforeach

                            <div class="purchase-pagination">
                                {{ $orders->appends(['status' => $current_status])->links() }}
                            </div>

                        @else

                            <div class="purchase-empty">
                                <div class="purchase-empty-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <span>No Orders</span>
                                <h3>No orders found</h3>
                                <p>You don't have any orders under this category yet.</p>
                                <a href="{{ url('/customer/shop') }}">Explore Products →</a>
                            </div>

                        @endif
                    </div>

                </section>
            </main>

        </div>
    </div>
</div>

<script>
    function markAsReceived(orderId) {
        if(confirm('Confirm that you have received this order?')) {
            fetch('{{ url("/customer/order/updateOrderStatus") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    order_id: orderId,
                    action: 'received'
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Something went wrong. Please try again.');
                console.error('Error:', error);
            });
        }
    }
</script>
</body>
</html>