<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="cu-page">
    <div class="cu-container">
        <div class="cu-breadcrumb">
            <a href="{{ url('/customerHomePage') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Contact Us</span>
        </div>

        <section class="cu-hero">
            <div class="cu-hero-content">
                <span class="cu-eyebrow">We Are Here to Help</span>
                <h1>Let's Get in Touch</h1>
                <p>Have a question about our products, orders or repair services? Our team is ready to assist you.</p>
            </div>
            <div class="cu-hero-icon"><i class="fas fa-headset"></i></div>
        </section>

        <div class="cu-quick-grid">
            <a href="tel:+60123456789" class="cu-quick-card">
                <div class="cu-quick-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <h3>Call Us</h3>
                    <p>Speak directly with our team</p>
                    <strong>012-345 6789</strong>
                </div>
                <i class="fas fa-arrow-right cu-quick-arrow"></i>
            </a>
            <a href="mailto:info@winsoft.com.my" class="cu-quick-card">
                <div class="cu-quick-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <h3>Email Us</h3>
                    <p>Send us your enquiries</p>
                    <strong>info@winsoft.com.my</strong>
                </div>
                <i class="fas fa-arrow-right cu-quick-arrow"></i>
            </a>
            <a href="{{ url('/customer/storeLocation') }}" class="cu-quick-card">
                <div class="cu-quick-icon"><i class="fas fa-location-dot"></i></div>
                <div>
                    <h3>Visit Our Stores</h3>
                    <p>Find your nearest branch</p>
                    <strong>View Store Locations</strong>
                </div>
                <i class="fas fa-arrow-right cu-quick-arrow"></i>
            </a>
        </div>

        <div class="cu-layout">
            <section class="cu-form-card">
                <div class="cu-card-header">
                    <span class="cu-eyebrow">Customer Enquiry</span>
                    <h2>Send Us a Message</h2>
                    <p>Complete the form below and our team will review your enquiry.</p>
                </div>

                @if($errors->any())
                    <div class="cu-error-box">
                        <strong><i class="fas fa-circle-exclamation"></i> Please check your information.</strong>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="post" action="{{ url('/customer/contactUs') }}" id="contactMessageForm">
                    @csrf
                    <div class="cu-form-section">
                        <h3>Contact Information</h3>
                        <p>Your name and email are taken from your customer profile.</p>
                    </div>

                    <div class="cu-form-grid">
                        <div class="cu-form-group">
                            <label for="cuName">Your Name</label>
                            <input type="text" id="cuName" value="{{ $customer->name }}" readonly>
                        </div>
                        <div class="cu-form-group">
                            <label for="cuEmail">Email Address</label>
                            <input type="email" id="cuEmail" value="{{ $customer->email }}" readonly>
                        </div>
                        <div class="cu-form-group cu-full-width">
                            <label for="cuPhone">Phone Number</label>
                            <input type="tel" name="phone" id="cuPhone" value="{{ old('phone', $customer->phone_number) }}" maxlength="20" placeholder="Enter your contact number">
                            <small>Optional. Provide a number if you would like us to contact you by phone.</small>
                        </div>
                    </div>

                    <div class="cu-divider"></div>

                    <div class="cu-form-section">
                        <h3>Your Enquiry</h3>
                        <p>Let us know how we can help you.</p>
                    </div>

                    <div class="cu-form-grid">
                        <div class="cu-form-group cu-full-width">
                            <label for="cuSubject">Subject <span>*</span></label>
                            <select name="subject" id="cuSubject" required>
                                <option value="">Select a subject</option>
                                @foreach(['General Inquiry', 'Product Question', 'Order Inquiry', 'Service Booking', 'Technical Support', 'Feedback', 'Others'] as $subject)
                                    <option value="{{ $subject }}" {{ old('subject') == $subject ? 'selected' : '' }}>{{ $subject }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="cu-form-group cu-full-width">
                            <label for="cuMessage">Message <span>*</span></label>
                            <textarea name="message" id="cuMessage" rows="6" minlength="10" maxlength="2000" required placeholder="Please describe your question or concern...">{{ old('message') }}</textarea>
                            <div class="cu-message-meta">
                                <small>Please do not include passwords or payment information.</small>
                                <small id="cuCharacterCount">0 / 2000</small>
                            </div>
                        </div>
                    </div>

                    <div class="cu-form-note">
                        <i class="fas fa-shield-halved"></i>
                        <p>Your contact information will be used to respond to your enquiry.</p>
                    </div>

                    <button type="submit" class="cu-submit-btn" id="cuSubmitButton">
                        <span><i class="fas fa-paper-plane"></i> Send Message</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </section>

            <aside class="cu-sidebar">
                <div class="cu-info-card">
                    <span class="cu-eyebrow">Contact Details</span>
                    <h2>Get in Touch</h2>

                    <div class="cu-info-item">
                        <div class="cu-info-icon"><i class="fas fa-location-dot"></i></div>
                        <div>
                            <h3>Headquarters</h3>
                            <p>17, Jalan Cempaka 1, Taman Bunga Cempaka Biru, 86400 Parit Raja, Batu Pahat, Johor</p>
                            <a href="https://maps.app.goo.gl/UW84SctYLr9TPNLX7" target="_blank" rel="noopener noreferrer">Get Directions <i class="fas fa-arrow-up-right-from-square"></i></a>
                        </div>
                    </div>

                    <div class="cu-info-item">
                        <div class="cu-info-icon"><i class="fas fa-phone"></i></div>
                        <div>
                            <h3>Phone Numbers</h3>
                            <a href="tel:+60123456789">012-345 6789</a>
                            <a href="tel:+60787654321">07-8765 4321</a>
                        </div>
                    </div>

                    <div class="cu-info-item">
                        <div class="cu-info-icon"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h3>Email Addresses</h3>
                            <a href="mailto:info@winsoft.com.my">info@winsoft.com.my</a>
                            <a href="mailto:support@winsoft.com.my">support@winsoft.com.my</a>
                        </div>
                    </div>

                    <div class="cu-info-item">
                        <div class="cu-info-icon"><i class="fas fa-clock"></i></div>
                        <div>
                            <h3>HQ Business Hours</h3>
                            <p>Monday - Saturday</p>
                            <strong>9:15 AM - 6:45 PM</strong>
                            <p class="cu-closed-text">Sunday: Closed</p>
                        </div>
                    </div>
                </div>

                <div class="cu-support-card">
                    <div class="cu-support-icon"><i class="fas fa-screwdriver-wrench"></i></div>
                    <h3>Need a Repair Service?</h3>
                    <p>Book a service appointment for your computer or electronic device.</p>
                    <a href="{{ url('/customer/service') }}">Book a Service <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="cu-support-card">
                    <div class="cu-support-icon"><i class="fas fa-box"></i></div>
                    <h3>Looking for Your Order?</h3>
                    <p>Check your purchase history and current order status.</p>
                    <a href="{{ url('/customer/order') }}">My Purchase <i class="fas fa-arrow-right"></i></a>
                </div>
            </aside>
        </div>
    </div>
</div>

@if(session('contact_success'))
    <div class="cu-success-overlay" role="dialog" aria-modal="true" aria-labelledby="cuSuccessTitle">
        <div class="cu-success-modal">
            <div class="cu-success-icon"><i class="fas fa-check"></i></div>
            <span class="cu-eyebrow">Message Received</span>
            <h2 id="cuSuccessTitle">Thank You for Contacting Us!</h2>
            <p>Your message has been submitted successfully. Our team will review your enquiry.</p>
            <div class="cu-reference">
                <span>Message Reference</span>
                <strong>#{{ session('message_id') }}</strong>
            </div>
            <div class="cu-success-actions">
                <a href="{{ url('/customerHomePage') }}" class="cu-home-btn">Back to Home</a>
                <a href="{{ url('/customer/contactUs') }}" class="cu-done-btn">Done</a>
            </div>
        </div>
    </div>
@endif

<script>
    const contactMessage = document.getElementById('cuMessage');
    const characterCount = document.getElementById('cuCharacterCount');
    const contactForm = document.getElementById('contactMessageForm');
    const submitButton = document.getElementById('cuSubmitButton');

    function updateCharacterCount() {
        characterCount.textContent = contactMessage.value.length + ' / 2000';
    }

    contactMessage.addEventListener('input', updateCharacterCount);
    updateCharacterCount();

    contactForm.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.innerHTML = '<span>Sending Message...</span><i class="fas fa-spinner fa-spin"></i>';
    });

    window.addEventListener('pageshow', function() {
        submitButton.disabled = false;
        submitButton.innerHTML = '<span><i class="fas fa-paper-plane"></i> Send Message</span><i class="fas fa-arrow-right"></i>';
    });
</script>
</body>
</html>