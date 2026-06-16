<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
</head>
<body>
    <div class="service-container">
        <h2>🔧 Book Repair Service</h2>

        <form method="post" action="{{ url('/customer/service') }}">
            @csrf
            <label>Name:</label>
            <input type="text" value="{{ $customer->name }}" disabled>

            <label>Email:</label>
            <input type="email" value="{{ $customer->email }}" disabled>

            <label>Phone:</label>
            <input type="text" value="{{ $customer->phone_number }}" disabled>

             <label>Service Type:</label>
            <select name="service_type" required>
                <option value="" disabled selected>Please Select Your Service Type</option>
                <option value="Computer Repair">Computer Repair</option>
                <option value="Laptop Repair">Laptop Repair</option>
                <option value="Server Repair">Server Repair</option>
                <option value="Network Installation">Network Installation</option>
            </select>

            <label>Service Option:</label>
            <select name="service_option" required id="service_option">
                <option value="" disabled selected>Please Select Your Service Option</option>
                <option value="walk-in">Walk-in (Visit Our Store)</option>
                <option value="door-to-door">Door-to-Door (Technician Visit You)</option>
            </select>

            <label id="address_label" style="display:none">Address:</label>
            <textarea name="address" id="address" style="display:none" rows="3" placeholder="Enter your full address"></textarea>

            <label>Your Device Brand:</label>
            <select name="device_brand" required>
                <option value="" disabled selected>Please Select Your Device Brand</option>
                <option value="Apple">Apple</option>
                <option value="Dell">Dell</option>
                <option value="HP">HP</option>
                <option value="Lenovo">Lenovo</option>
                <option value="Samsung">Samsung</option>
                <option value="Others">Others</option>
            </select>

            <label>Problem Description:</label>
            <textarea name="problem_description" rows="4" required placeholder="Describe your problem..."></textarea>

            <label>Preferred Date:</label>
            <input type="date" name="preferred_date" required id="preferred_date">

            <label>Preferred Time:</label>
            <input type="time" name="preferred_time" required>
            
            <button type="submit" name="book">Submit Request</button>
        </form>
    </div>

    <!-- success popup dialog -->
    @if($showPopup)
    <div id="success-dialog" class="success-dialog" style="display: flex;">
        <div class="success-container">
            <div class="success-container-header">
                <h3>Service Request Submitted!</h3>
            </div>
            <div class="success-container-body">
                <div class="request-id">
                    Request ID: {{ $requestId }}
                </div>
                <p>Our technician will contact you shortly to confirm the details.</p>
            </div>
            <div class="success-container-footer">
                <button onclick="closePopupAndRedirect()">OK</button>
            </div>
        </div>
    </div>
    @endif

    <script>
        const optionSelect = document.getElementById('service_option');
        const addressLabel = document.getElementById('address_label');
        const addressField = document.getElementById('address');

        // set address field visibility
        optionSelect.addEventListener('change', function() {
            if(this.value === 'door-to-door') {
                addressLabel.style.display = 'block';
                addressField.style.display = 'block';
                addressField.required = true;
            } else {
                addressLabel.style.display = 'none';
                addressField.style.display = 'none';
                addressField.required = false;
            }
        });

        // get today date and set as min for date input
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('preferred_date').setAttribute('min', today);

        // close popup and redirect to home page
        function closePopupAndRedirect() {
            document.getElementById('success-dialog').style.display = 'none';
            window.location.href = '{{ url("/") }}';
        }

        // control form resubmission when page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>