<form method="post" action="{{ url('/superadmin/websiteSettings/contact') }}">
    @csrf

    <section class="ws-card">
        <div class="ws-card-header">
            <div class="ws-section-icon"><i class="bi bi-person-lines-fill"></i></div>
            <div>
                <h2>Company Contact Information</h2>
                <p>Manage the general contact information displayed on your website.</p>
            </div>
        </div>

        <div class="ws-card-body ws-form-grid">
            <div class="ws-form-group ws-full-width">
                <label for="contactAddress">Company Address</label>
                <textarea name="contact_address" id="contactAddress" class="form-control" rows="3" maxlength="1000" placeholder="Enter the company address...">{{ old('contact_address', $websiteSettings->contact_address) }}</textarea>
                <small>This is your general company address, not individual branch addresses.</small>
            </div>

            <div class="ws-form-group">
                <label for="contactPhone">Phone Number</label>
                <input type="tel" name="contact_phone" id="contactPhone" class="form-control" value="{{ old('contact_phone', $websiteSettings->contact_phone) }}" maxlength="30" placeholder="012-3456789">
            </div>

            <div class="ws-form-group">
                <label for="contactEmail">Email Address</label>
                <input type="email" name="contact_email" id="contactEmail" class="form-control" value="{{ old('contact_email', $websiteSettings->contact_email) }}" maxlength="255" placeholder="info@example.com">
            </div>
        </div>
    </section>

    <section class="ws-card">
        <div class="ws-card-header">
            <div class="ws-section-icon"><i class="bi bi-share"></i></div>
            <div>
                <h2>Social Media Links</h2>
                <p>Connect your official social media accounts to your website.</p>
            </div>
        </div>

        <div class="ws-card-body">
            <div class="ws-social-setting">
                <div class="ws-social-icon ws-facebook-icon"><i class="bi bi-facebook"></i></div>
                <div class="ws-form-group">
                    <label for="facebookUrl">Facebook</label>
                    <input type="url" name="facebook_url" id="facebookUrl" class="form-control" value="{{ old('facebook_url', $websiteSettings->facebook_url) }}" maxlength="500" placeholder="https://www.facebook.com/yourpage">
                    <small>Enter the full URL of your official Facebook page.</small>
                </div>
            </div>

            <div class="ws-social-setting">
                <div class="ws-social-icon ws-instagram-icon"><i class="bi bi-instagram"></i></div>
                <div class="ws-form-group">
                    <label for="instagramUrl">Instagram</label>
                    <input type="url" name="instagram_url" id="instagramUrl" class="form-control" value="{{ old('instagram_url', $websiteSettings->instagram_url) }}" maxlength="500" placeholder="https://www.instagram.com/yourpage">
                    <small>Enter the full URL of your official Instagram account.</small>
                </div>
            </div>

            <div class="ws-social-setting">
                <div class="ws-social-icon ws-whatsapp-icon"><i class="bi bi-whatsapp"></i></div>
                <div class="ws-form-group">
                    <label for="whatsappNumber">WhatsApp</label>
                    <input type="tel" name="whatsapp_number" id="whatsappNumber" class="form-control" value="{{ old('whatsapp_number', $websiteSettings->whatsapp_number) }}" maxlength="15" inputmode="numeric" pattern="[1-9][0-9]{7,14}" placeholder="60123456789">
                    <small>Enter the international phone number without +, spaces or hyphens.</small>
                </div>
            </div>

            <div class="ws-tip">
                <i class="bi bi-info-circle"></i>
                <span>Leave a social media field empty if you do not want its icon to appear on the website.</span>
            </div>
        </div>
    </section>

    <section class="ws-card">
        <div class="ws-card-header">
            <div class="ws-section-icon"><i class="bi bi-diagram-3"></i></div>
            <div>
                <h2>Connected Pages</h2>
                <p>These settings provide a shared source of company contact information.</p>
            </div>
        </div>

        <div class="ws-card-body">
            <div class="ws-connected-page">
                <i class="bi bi-layout-text-window-reverse"></i>
                <div>
                    <strong>Website Footer</strong>
                    <span>Shared by Customer and Visitor pages.</span>
                </div>
            </div>

            <div class="ws-connected-page">
                <i class="bi bi-envelope"></i>
                <div>
                    <strong>Customer Contact Us</strong>
                    <span>General contact information and social media links.</span>
                </div>
            </div>

            <div class="ws-connected-page">
                <i class="bi bi-globe2"></i>
                <div>
                    <strong>Visitor Contact Us</strong>
                    <span>To be connected during the Visitor interface upgrade.</span>
                </div>
            </div>
        </div>

        <div class="ws-card-footer">
            <a href="{{ url('/superadmin/websiteSettings?tab=contact') }}" class="ws-reset-btn"><i class="bi bi-arrow-counterclockwise"></i> Discard Changes</a>
            <button type="submit" class="ws-save-btn"><i class="bi bi-check2"></i> Save Contact Settings</button>
        </div>
    </section>
</form>