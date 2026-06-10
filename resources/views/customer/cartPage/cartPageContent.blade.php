<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <style>
        .cart-wrapper {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .cart-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
        }
        .cart-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: bold;
            color: #333;
            border-bottom: 1px solid #eee;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .product-info img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product-info h4 {
            font-size: 16px;
            color: #333;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .qty-btn {
            width: 30px;
            height: 30px;
            background: #888787;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .qty-btn:hover {
            background: #686868;
        }
        .qty-input {
            width: 50px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .remove-link {
            color: #dc3545;
            text-decoration: none;
        }
        .remove-link:hover {
            text-decoration: underline;
        }
        .cart-summary {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 350px;
            margin-left: auto;
        }
        .summary-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-weight: bold;
            font-size: 18px;
        }
        .checkout-btn {
            display: block;
            width: 100%;
            background: #28a745;
            color: white;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 15px;
            font-weight: bold;
        }
        .checkout-btn:hover {
            background: #218838;
        }
        .continue-shopping {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .empty-cart {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 15px;
        }
        .empty-cart i {
            font-size: 80px;
            color: #ccc;
            margin-bottom: 20px;
        }
        .empty-cart h3 {
            margin-bottom: 10px;
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
            .cart-table {
                overflow-x: auto;
            }
            .cart-summary {
                width: 100%;
            }
            .product-info img {
                width: 50px;
                height: 50px;
            }
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
    @endif

    <div class="cart-wrapper">
        <h1 class="cart-title">🛒 Shopping Cart</h1>

        @if(count($cartItems) > 0)
            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAllCheckbox"></th>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr id="row-{{ $item->cart_id }}">
                            <td>
                                <input type="checkbox" class="item-checkbox" data-price="{{ $item->product->price }}" data-quantity="{{ $item->quantity }}">
                            </td>
                            <td>
                                <div class="product-info">
                                    @if($item->product->image)
                                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                                    @else
                                        <div style="width:80px; height:80px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                    <h4>{{ $item->product->name }}</h4>
                                </div>
                            </td>
                            <td>RM {{ number_format($item->product->price, 2) }}</td>
                            <td>
                                <div class="quantity-control">
                                    <button class="qty-btn" onclick="updateQuantity({{ $item->cart_id }}, 'decrease')">-</button>
                                    <input type="text" id="qty-{{ $item->cart_id }}" class="qty-input" value="{{ $item->quantity }}" readonly>
                                    <button class="qty-btn" onclick="updateQuantity({{ $item->cart_id }}, 'increase')">+</button>
                                </div>
                            </td>
                            <td class="subtotal-{{ $item->cart_id }}">RM {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            <td>
                                <a href="{{ url('/customer/cart/remove/'.$item->cart_id) }}" class="remove-link" onclick="return confirm('Remove this item?')">
                                    <i class="fas fa-trash"></i> Remove
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="cart-summary">
                <div class="summary-title">Order Summary</div>
                <div class="summary-row">
                    <span>Selected Items (<span id="selectedItemCount">0</span>)</span>
                    <span>RM <span id="selectedTotalPrice">0.00</span></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>RM <span id="shippingAmount">0.00</span></span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>RM <span id="grandTotal">0.00</span></span>
                </div>
                <a href="#" id="checkoutBtn" class="checkout-btn disabled">Proceed to Checkout</a>
            </div>
        @else
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your cart is empty</h3>
                <p>Looks like you haven't added any items yet.</p>
                <a href="{{ url('/customer/shop') }}" class="checkout-btn" style="display: inline-block; width: auto; padding: 10px 30px;">Shop Now</a>
            </div>
        @endif
    </div>
    <script>
        // Get DOM elements
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectedItemCountSpan = document.getElementById('selectedItemCount');
        const selectedTotalPriceSpan = document.getElementById('selectedTotalPrice');
        const shippingAmountSpan = document.getElementById('shippingAmount');
        const grandTotalSpan = document.getElementById('grandTotal');
        const checkoutBtn = document.getElementById('checkoutBtn');
        
        const SHIPPING_COST = 10.00;
        
        // Function to update total based on selected items
        function updateTotal() {
            let selectedItems = document.querySelectorAll('.item-checkbox:checked');
            let totalItems = 0;
            let totalPrice = 0;
            
            selectedItems.forEach(checkbox => {
                let price = parseFloat(checkbox.getAttribute('data-price'));
                let quantity = parseInt(checkbox.getAttribute('data-quantity'));
                totalItems += quantity;
                totalPrice += price * quantity;
            });
            
            // Update display
            selectedItemCountSpan.innerText = totalItems;
            selectedTotalPriceSpan.innerText = totalPrice.toFixed(2);
            
            // Calculate shipping (free if no items selected)
            let shipping = totalItems > 0 ? SHIPPING_COST : 0;
            shippingAmountSpan.innerText = shipping.toFixed(2);
            
            let grandTotal = totalPrice + shipping;
            grandTotalSpan.innerText = grandTotal.toFixed(2);
            
            // Enable/disable checkout button
            if(totalItems > 0) {
                checkoutBtn.classList.remove('disabled');
            } else {
                checkoutBtn.classList.add('disabled');
            }
        }
        
        // Select All checkbox event
        if(selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateTotal();
            });
        }
        
        // Individual checkbox events
        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Check if all checkboxes are checked to update Select All
                const allChecked = [...itemCheckboxes].every(cb => cb.checked);
                if(selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
                updateTotal();
            });
        });
        
        // Initial update (total starts at 0)
        updateTotal();

        function updateQuantity(cartId, action) {
            let quantityInput = document.getElementById('qty-' + cartId);
            let currentQty = parseInt(quantityInput.value);
            let newQty = currentQty;
            
            if(action === 'increase') {
                newQty = currentQty + 1;
            } else if(action === 'decrease') {
                newQty = currentQty - 1;
            }
            
            if(newQty < 1) {
                return;
            }
            
            fetch('{{ url("/customer/cart/update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_id: cartId,
                    quantity: newQty
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    quantityInput.value = newQty;
                    document.querySelector('.subtotal-' + cartId).innerText = 'RM ' + data.subtotal;
                    location.reload();
                }
            });
        }
    </script>
</body>
</html>