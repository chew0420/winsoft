<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/visitor.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="contact-container">
        <div class="page-title">
            <h1>📞 Contact Us</h1>
            <p>We'd love to hear from you! Reach out to us anytime.</p>
        </div>

        <div class="contact-grid">
            <!-- Contact Info Section -->
            <div class="contact-info">
                <h2>Get in Touch</h2>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-details">
                        <h3>Our Address</h3>
                        <p>17, Jalan Cempaka 1, Taman Bunga Cempaka Biru,<br>
                        86400 Parit Raja, Batu Pahat, Johor</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-details">
                        <h3>Phone Number</h3>
                        <p><a href="tel:0123456789">012-345 6789</a></p>
                        <p><a href="tel:0787654321">07-8765 4321</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-details">
                        <h3>Email Address</h3>
                        <p><a href="mailto:info@winsoft.com.my">info@winsoft.com.my</a></p>
                        <p><a href="mailto:support@winsoft.com.my">support@winsoft.com.my</a></p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-details">
                        <h3>Business Hours</h3>
                        <p>Monday - Saturday: 9:15 AM - 6:45 PM</p>
                        <p>Sunday: Closed</p>
                    </div>
                </div>

                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

            <!-- Contact Form Section -->
            <div class="contact-form">
                <h2>Send Us a Message</h2>

                <form method="post" action="{{ url('/contactUs') }}">
                    @csrf

                    <div class="form-group">
                        <label>Your Name *</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone"" required>
                    </div>

                    <div class="form-group">
                        <label>Subject *</label>
                        <select name="subject" required>
                            <option value="">Select Subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="Product Question">Product Question</option>
                            <option value="Service Booking">Service Booking</option>
                            <option value="Technical Support">Technical Support</option>
                            <option value="Feedback">Feedback</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Message *</label>
                        <textarea name="message" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Send Message</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>