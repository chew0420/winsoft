<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <style>
        /* contact container */
        .contact-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .page-title h1 {
            font-size: 36px;
            color: #333;
            margin-bottom: 10px;
        }
        .page-title p {
            color: #666;
            font-size: 18px;
        }

        /* contact grid */
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        /* contact info section */
        .contact-info {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .contact-info h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            border-left: 4px solid #e42b2b;
            padding-left: 15px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .info-icon {
            width: 50px;
            height: 50px;
            background: #e42b2b20;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .info-icon i {
            font-size: 22px;
            color: #e42b2b;
        }

        .info-details h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }

        .info-details p {
            color: #666;
            line-height: 1.5;
        }

        .info-details a {
            color: #666;
            text-decoration: none;
        }

        .info-details a:hover {
            color: #e42b2b;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: #e42b2b20;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e42b2b;
            font-size: 18px;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: #e42b2b;
            color: white;
        }

        /* contact form section */
        .contact-form {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .contact-form h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            border-left: 4px solid #e42b2b;
            padding-left: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #e42b2b;
        }

        .form-group textarea {
            resize: vertical;
        }

        .submit-btn {
            background: #e42b2b;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
        }

        .submit-btn:hover {
            background: #c41e1e;
        }
    </style>
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

                <form method="post" action="{{ url('/contact-us') }}">
                    @csrf

                    <div class="form-group">
                        <label>Your Name *</label>
                        <input type="text" name="name" value="{{ $customer->name }}" required disabled>
                    </div>

                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" value="{{ $customer->email }}" required disabled>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ $customer->phone_number }}" required disabled>
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