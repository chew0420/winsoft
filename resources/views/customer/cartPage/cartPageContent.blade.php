<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
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
                <a href="/customer/checkout" id="checkoutBtn" class="checkout-btn disabled">Proceed to Checkout</a>
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
            
            // update display
            selectedItemCountSpan.innerText = totalItems;
            selectedTotalPriceSpan.innerText = totalPrice.toFixed(2);
            
            // if no item selected then shipping fee = 0
            let shipping = totalItems > 0 ? SHIPPING_COST : 0;
            shippingAmountSpan.innerText = shipping.toFixed(2);
            
            let grandTotal = totalPrice + shipping;
            grandTotalSpan.innerText = grandTotal.toFixed(2);
            
            // enable or disable checkout button
            if(totalItems > 0) {
                checkoutBtn.classList.remove('disabled');
            } else {
                checkoutBtn.classList.add('disabled');
            }
        }
        
        // select all checkbox
        if(selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateTotal();
            });
        }
        
        // individual checkbox
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
        
        // make total= 0 when user enter cart
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

        if(checkoutBtn){
            checkoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get selected items
                const selectedItems = [];
                document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const cartId = row.id.split('-')[1];
                    selectedItems.push(cartId);
                });
                
                if(selectedItems.length > 0) {
                    // Redirect with selected IDs in URL
                    window.location.href = '{{ url("/customer/checkout") }}?selected_ids=' + selectedItems.join(',');
                } else {
                    alert('Please select items to checkout');
                }
            });
        }
    </script>
</body>
</html>