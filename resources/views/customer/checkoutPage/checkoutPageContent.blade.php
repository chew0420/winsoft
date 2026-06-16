<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
</head>
<body>
    <div class="checkout-container">
        <div class="delivery-address-card">
            <div class="delivery-header">
                <h3><i class="fas fa-map-marker-alt"></i> Delivery Address</h3>
            </div>
            <div class="delivery-content">
                <span class="delivery-name">{{ $customer->name }}</span>
                <span class="delivery-separator">|</span>
                <span class="delivery-phone">{{ $customer->phone_number }}</span>
                <span class="delivery-separator">|</span>
                <span class="delivery-address">{{ $customer->address }}</span>
                <a href="#" class="change-link">(Change)</a>
            </div>
            <input type="hidden" id="shipping_address" value="{{ $customer->address }}">
        </div>
        <div class="checkout-two-columns">
            <!-- Left Column - Products Ordered -->
            <div class="checkout-left">
                <div class="checkout-card">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-box"></i> Products Ordered</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Item Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td class="product-name">
                                    @if($item->product->image)
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="product-thumb">
                                    @else
                                        <div class="product-thumb-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                    <span>{{ $item->product->name }}</span>
                                </td>
                                <td class="unit-price">RM {{ number_format($item->product->price, 2) }}</td>
                                <td class="quantity">{{ $item->quantity }}</td>
                                <td class="item-subtotal">RM {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="checkout-right">
                <div class="checkout-card">
                    <h3><i class="fas fa-receipt"></i> Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Merchandise Subtotal</span>
                        <span>RM {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping Fee</span>
                        <span>RM {{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Payment</span>
                        <span>RM {{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="form-group" style="margin-top: 20px;">
                        <label>Payment Method</label>
                        <select id="payment_method" class="form-select">
                            <option value="">Select Payment Method</option>
                            <option value="credit_card">Credit / Debit Card</option>
                            <option value="online_banking">Online Banking</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                        </select>
                    </div>
                    
                    <button class="place-order-btn" id="placeOrderBtn">
                        <i class="fas fa-check-circle"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
        
    </div>

    <script>
        // Get selected items from sessionStorage
        const selectedIds = '{{ $selectedIds }}';
        // Instead of getting from textarea, get from the delivery address card
        const shippingAddress = document.getElementById('shipping_address').value;

        if(!selectedIds) {
            window.location.href = '{{ url("/customer/cart") }}';
        }
        
        document.getElementById('placeOrderBtn').addEventListener('click', function() {
            const paymentMethod = document.getElementById('payment_method').value;
            
            if(!paymentMethod) {
                alert('Please select a payment method');
                return;
            }
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url("/customer/placeOrder") }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            const selectedInput = document.createElement('input');
            selectedInput.type = 'hidden';
            selectedInput.name = 'selected_ids';
            selectedInput.value = selectedIds;
            form.appendChild(selectedInput);
            
            const paymentInput = document.createElement('input');
            paymentInput.type = 'hidden';
            paymentInput.name = 'payment_method';
            paymentInput.value = paymentMethod;
            form.appendChild(paymentInput);

            const addressInput = document.createElement('input');
            addressInput.type = 'hidden';
            addressInput.name = 'shipping_address';
            addressInput.value = shippingAddress;
            form.appendChild(addressInput);
            
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>
</html>