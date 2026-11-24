<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
</head>
<body>
<div class="service-page">
    <div class="service-main-container">

        <div class="service-page-header">
            <span class="service-eyebrow">Technical Support</span>
            <h1>Book a Repair Service</h1>
            <p>Tell us about your device and preferred appointment time. Our team will review your request and contact you to confirm the booking.</p>
        </div>

        <div class="service-layout">

            <div class="service-form-card">
                <div class="service-card-header">
                    <div class="service-step-number">1</div>
                    <div>
                        <span>Service Request</span>
                        <h2>Tell Us About Your Device</h2>
                    </div>
                </div>

                <form method="post" action="{{ url('/customer/service') }}" id="serviceBookingForm">
                    @csrf

                    <div class="service-section-title">
                        <h3>Customer Information</h3>
                        <p>Your contact information is taken from your customer profile.</p>
                    </div>

                    <div class="service-form-grid">
                        <div class="service-form-group">
                            <label>Name</label>
                            <input type="text" value="{{ $customer->name }}" disabled>
                        </div>

                        <div class="service-form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $customer->email }}" disabled>
                        </div>

                        <div class="service-form-group service-full-width">
                            <label>Phone Number</label>
                            <input type="text" value="{{ $customer->phone_number }}" disabled>
                        </div>
                    </div>

                    <div class="service-divider"></div>

                    <div class="service-section-title">
                        <h3>Device & Service</h3>
                        <p>Tell us what device you need help with and what type of service is required.</p>
                    </div>

                    <div class="service-form-grid">
                        <div class="service-form-group">
                            <label>Service Type <span>*</span></label>
                            <select name="service_type" required>
                                <option value="" disabled selected>Select service type</option>
                                <option value="Diagnosis & Repair">Diagnosis & Repair</option>
                                <option value="Hardware Repair / Upgrade">Hardware Repair / Upgrade</option>
                                <option value="Software / System Support">Software / System Support</option>
                                <option value="Data Recovery">Data Recovery</option>
                                <option value="Network / Wi-Fi Support">Network / Wi-Fi Support</option>
                                <option value="Business IT Support">Business IT Support</option>
                                <option value="Other Technical Support">Other Technical Support</option>
                            </select>
                        </div>

                        <div class="service-form-group">
                            <label>Device Type <span>*</span></label>
                            <select name="device_type" required>
                                <option value="" disabled selected>Select device type</option>
                                <option value="Desktop Computer">Desktop Computer</option>
                                <option value="Laptop">Laptop</option>
                                <option value="Smartphone">Smartphone</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Printer">Printer</option>
                                <option value="Monitor">Monitor</option>
                                <option value="Server">Server</option>
                                <option value="Network Device">Network Device</option>
                                <option value="Other Electronic Device">Other Electronic Device</option>
                            </select>
                        </div>

                        <div class="service-form-group">
                            <label>Device Brand <span>*</span></label>
                            <select name="device_brand" required>
                                <option value="" disabled selected>Select device brand</option>
                                <option value="Apple">Apple</option>
                                <option value="Acer">Acer</option>
                                <option value="ASUS">ASUS</option>
                                <option value="Dell">Dell</option>
                                <option value="HP">HP</option>
                                <option value="Lenovo">Lenovo</option>
                                <option value="MSI">MSI</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Huawei">Huawei</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <div class="service-form-group">
                            <label>Device Model</label>
                            <input type="text" name="device_model" placeholder="Example: ASUS TUF A15">
                            <small>If you know the device model, enter it here.</small>
                        </div>

                        <div class="service-form-group service-full-width">
                            <label>Problem Description <span>*</span></label>
                            <textarea name="problem_description" rows="5" maxlength="2000" required placeholder="Example: Laptop cannot turn on, screen is flickering, Wi-Fi keeps disconnecting..."></textarea>
                            <small>Please describe the symptoms as clearly as possible.</small>
                        </div>
                    </div>

                    <div class="service-divider"></div>

                    <div class="service-section-title">
                        <h3>Service Location</h3>
                        <p>Choose whether you would like to visit us or request an on-site technician.</p>
                    </div>

                    <div class="service-option-grid">
                        <label class="service-option-card" for="service_walkin">
                            <input type="radio" name="service_option" id="service_walkin" value="walk-in" required>
                            <div class="service-option-icon"><i class="fas fa-store"></i></div>
                            <div>
                                <strong>Walk-in Service</strong>
                                <span>Bring your device to our service location.</span>
                            </div>
                        </label>

                        <label class="service-option-card" for="service_door">
                            <input type="radio" name="service_option" id="service_door" value="door-to-door" required>
                            <div class="service-option-icon"><i class="fas fa-house"></i></div>
                            <div>
                                <strong>On-Site Service</strong>
                                <span>Request a technician to visit your location.</span>
                            </div>
                        </label>
                    </div>

                    <div id="walkInLocationWrapper" class="service-location-wrapper">
                        <div class="service-section-title">
                            <h3>Select Service Centre</h3>
                            <p>Choose the Winsoft location you would like to visit.</p>
                        </div>

                        <div class="service-location-options">

                            <label class="service-location-card">
                                <input type="radio" name="service_location" value="Winsoft Solution (HQ)">

                                <div class="service-location-icon">
                                    <i class="fas fa-store"></i>
                                </div>

                                <div class="service-location-info">
                                    <strong>Winsoft Solution (HQ)</strong>
                                    <span>17, Jalan Cempaka 1, Taman Bunga Cempaka Biru, 86400 Parit Raja, Batu Pahat, Johor</span>
                                    <small>Monday - Saturday · 9:15 AM - 6:45 PM</small>
                                </div>
                            </label>

                            <label class="service-location-card">
                                <input type="radio" name="service_location" value="Winsoft Solution (BP)">

                                <div class="service-location-icon">
                                    <i class="fas fa-store"></i>
                                </div>

                                <div class="service-location-info">
                                    <strong>Winsoft Solution (BP)</strong>
                                    <span>15, Jalan Kuning, Taman Bukit Pasir, 83000 Batu Pahat, Johor</span>
                                    <small>Monday - Saturday · 9:15 AM - 5:45 PM</small>
                                </div>
                            </label>

                        </div>
                    </div>

                    <div id="serviceAddressWrapper" class="service-address-wrapper">
                        <div class="service-form-group">
                            <label>Service Address <span>*</span></label>
                            <textarea name="address" id="address" rows="3" placeholder="Enter the address for technician visit">{{ $customer->address }}</textarea>
                            <small>You can edit the address if this appointment is at a different location.</small>
                        </div>
                    </div>

                    <div class="service-divider"></div>

                    <div class="service-section-title">
                        <h3>Appointment</h3>
                        <p>Select your preferred date and time. The final appointment will be confirmed by our team.</p>
                    </div>

                    <div class="service-form-grid">
                        <div class="service-form-group">
                            <label>Preferred Date <span>*</span></label>
                            <input type="date" name="preferred_date" id="preferred_date" min="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <div class="service-form-group">
                            <label>Preferred Time <span>*</span></label>
                            <input type="time" name="preferred_time" id="preferred_time" step="1800" required>
                        </div>
                    </div>

                    <div class="service-booking-note">
                        <i class="fas fa-circle-info"></i>
                        <p>Your selected date and time are a preferred appointment only. Our technician will contact you to confirm availability.</p>
                    </div>

                    <button type="submit" name="book" class="service-submit-btn">
                        <span>Submit Service Request</span>
                        <span>→</span>
                    </button>
                </form>
            </div>

            <aside class="service-info-card">
                <span class="service-info-label">How It Works</span>
                <h2>Repair Booking Process</h2>

                <div class="service-process-list">
                    <div class="service-process-item">
                        <span>1</span>
                        <div>
                            <strong>Submit Request</strong>
                            <p>Tell us about your device and the problem.</p>
                        </div>
                    </div>

                    <div class="service-process-item">
                        <span>2</span>
                        <div>
                            <strong>Request Review</strong>
                            <p>Our technical team reviews your service request.</p>
                        </div>
                    </div>

                    <div class="service-process-item">
                        <span>3</span>
                        <div>
                            <strong>Appointment Confirmation</strong>
                            <p>We contact you to confirm the date, time and service arrangement.</p>
                        </div>
                    </div>

                    <div class="service-process-item">
                        <span>4</span>
                        <div>
                            <strong>Repair & Support</strong>
                            <p>Bring your device in or meet our technician at the agreed location.</p>
                        </div>
                    </div>
                </div>

                <div class="service-info-notice">
                    <strong>Important</strong>
                    <p>Submitting this form does not automatically confirm your appointment. Please wait for confirmation from our team.</p>
                </div>
            </aside>

        </div>
    </div>
</div>

@if($showPopup)
<div id="success-dialog" class="service-success-overlay">
    <div class="service-success-modal">
        <div class="service-success-icon"><i class="fas fa-check"></i></div>
        <span>Request Submitted</span>
        <h2>Service Request Received</h2>
        <p>Your request has been submitted successfully. Our technician will contact you to confirm the appointment details.</p>

        <div class="service-request-id">
            <span>Request ID</span>
            <strong>#{{ $requestId }}</strong>
        </div>

        <button type="button" onclick="closePopupAndRedirect()">Done</button>
    </div>
</div>
@endif

<script>
    const serviceOptions = document.querySelectorAll('input[name="service_option"]');
    const addressWrapper = document.getElementById('serviceAddressWrapper');
    const addressField = document.getElementById('address');
    const locationWrapper = document.getElementById('walkInLocationWrapper');
    const locationInputs = document.querySelectorAll('input[name="service_location"]');

    function updateServiceOption() {
        const selectedOption = document.querySelector('input[name="service_option"]:checked');

        if(!selectedOption) {
            addressWrapper.style.display = 'none';
            locationWrapper.style.display = 'none';
            addressField.required = false;

            locationInputs.forEach(input => {
                input.required = false;
            });

            return;
        }

        if(selectedOption.value === 'door-to-door') {
            addressWrapper.style.display = 'block';
            locationWrapper.style.display = 'none';
            addressField.required = true;

            locationInputs.forEach(input => {
                input.required = false;
                input.checked = false;
            });
        } else {
            addressWrapper.style.display = 'none';
            locationWrapper.style.display = 'block';
            addressField.required = false;

            locationInputs.forEach(input => {
                input.required = true;
            });
        }
    }

    serviceOptions.forEach(option => {
        option.addEventListener('change', updateServiceOption);
    });

    updateServiceOption();

    function closePopupAndRedirect() {
        document.getElementById('success-dialog').style.display = 'none';
        window.location.href = '{{ url("/customerHomePage") }}';
    }

    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
</body>
</html>