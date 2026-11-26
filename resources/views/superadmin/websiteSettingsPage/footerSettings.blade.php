<form method="post" action="{{ url('/superadmin/websiteSettings/footer') }}">
    @csrf

    <section class="ws-card">
        <div class="ws-card-header">
            <div class="ws-section-icon"><i class="bi bi-card-text"></i></div>
            <div>
                <h2>Footer Content</h2>
                <p>Customize the company description and copyright information.</p>
            </div>
        </div>
        <div class="ws-card-body ws-form-grid">
            <div class="ws-form-group ws-full-width">
                <label for="footerDescription">Company Description</label>
                <textarea name="footer_description" id="footerDescription" class="form-control" rows="4" maxlength="1000" placeholder="Enter your company description...">{{ old('footer_description', $websiteSettings->footer_description) }}</textarea>
                <small>This description is displayed below the website logo in the footer.</small>
            </div>
            <div class="ws-form-group ws-full-width">
                <label for="copyrightText">Copyright Text <span>*</span></label>
                <input type="text" name="copyright_text" id="copyrightText" class="form-control" value="{{ old('copyright_text', $websiteSettings->copyright_text) }}" maxlength="255" required>
                <small>The copyright symbol and current year will be generated automatically.</small>
            </div>
        </div>
    </section>

    <section class="ws-card">
        <div class="ws-card-header">
            <div class="ws-section-icon"><i class="bi bi-toggles"></i></div>
            <div>
                <h2>Section Visibility</h2>
                <p>Choose which sections are displayed in your website footer.</p>
            </div>
        </div>

        <div class="ws-card-body">
            @php
                $footerSections = [
                    ['show_footer_brand', 'Company Information', 'Show the website logo, name and company description.', 'bi-building', 'previewBrand'],
                    ['show_footer_links', 'Quick Links', 'Show navigation links to important website pages.', 'bi-link-45deg', 'previewLinks'],
                    ['show_footer_contact', 'Contact Information', 'Show the company address, phone number and email.', 'bi-person-lines-fill', 'previewContact'],
                    ['show_footer_social', 'Social Media', 'Show the configured social media links.', 'bi-share', 'previewSocial']
                ];
            @endphp

            @foreach($footerSections as $section)
                <div class="ws-visibility-row">
                    <div class="ws-visibility-icon"><i class="bi {{ $section[3] }}"></i></div>
                    <div class="ws-visibility-content">
                        <label for="{{ $section[0] }}">{{ $section[1] }}</label>
                        <p>{{ $section[2] }}</p>
                    </div>
                    <div class="form-check form-switch ws-switch">
                        <input type="hidden" name="{{ $section[0] }}" value="0">
                        <input type="checkbox" name="{{ $section[0] }}" id="{{ $section[0] }}" value="1" class="form-check-input ws-visibility-toggle" data-preview="{{ $section[4] }}" @checked(old($section[0], $websiteSettings->{$section[0]}))>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="ws-card">
        <div class="ws-card-header">
            <div class="ws-section-icon"><i class="bi bi-eye"></i></div>
            <div>
                <h2>Live Footer Preview</h2>
                <p>Preview your footer before saving the changes.</p>
            </div>
        </div>

        <div class="ws-card-body">
            <div class="ws-footer-preview">
                <div class="ws-footer-preview-grid">
                    <div id="previewBrand" class="ws-footer-preview-section">
                        <img src="{{ $websiteSettings->logo_url }}" alt="{{ $websiteSettings->website_name }}">
                        <h3>{{ $websiteSettings->website_name }}</h3>
                        <p id="previewDescription">{{ old('footer_description', $websiteSettings->footer_description) }}</p>
                    </div>

                    <div id="previewLinks" class="ws-footer-preview-section">
                        <h4>Quick Links</h4>
                        @foreach(['Home', 'Shopping', 'Service', 'Contact Us', 'Store Location'] as $link)
                            <p><i class="bi bi-chevron-right"></i> {{ $link }}</p>
                        @endforeach
                    </div>

                    <div id="previewContact" class="ws-footer-preview-section">
                        <h4>Contact Us</h4>
                        @if($websiteSettings->contact_address)
                            <p><i class="bi bi-geo-alt"></i> {{ $websiteSettings->contact_address }}</p>
                        @endif
                        @if($websiteSettings->contact_phone)
                            <p><i class="bi bi-telephone"></i> {{ $websiteSettings->contact_phone }}</p>
                        @endif
                        @if($websiteSettings->contact_email)
                            <p><i class="bi bi-envelope"></i> {{ $websiteSettings->contact_email }}</p>
                        @endif
                    </div>
                </div>

                <div class="ws-footer-preview-bottom">
                    <p>&copy; {{ date('Y') }} <span id="previewCopyright">{{ old('copyright_text', $websiteSettings->copyright_text) }}</span></p>
                    <div id="previewSocial" class="ws-footer-preview-social">
                        @if($websiteSettings->facebook_url)
                            <i class="bi bi-facebook"></i>
                        @endif
                        @if($websiteSettings->instagram_url)
                            <i class="bi bi-instagram"></i>
                        @endif
                        @if($websiteSettings->whatsapp_url)
                            <i class="bi bi-whatsapp"></i>
                        @endif
                    </div>
                </div>
            </div>

            <div class="ws-tip">
                <i class="bi bi-info-circle"></i>
                <span>The footer logo and website name are automatically synchronized with Branding Settings. Contact details and social links can be updated in Contact & Social Settings.</span>
            </div>
        </div>

        <div class="ws-card-footer">
            <a href="{{ url('/superadmin/websiteSettings?tab=footer') }}" class="ws-reset-btn"><i class="bi bi-arrow-counterclockwise"></i> Discard Changes</a>
            <button type="submit" class="ws-save-btn"><i class="bi bi-check2"></i> Save Footer Settings</button>
        </div>
    </section>
</form>

<script>
    const footerDescription = document.getElementById('footerDescription');
    const copyrightText = document.getElementById('copyrightText');
    const visibilityToggles = document.querySelectorAll('.ws-visibility-toggle');

    footerDescription.addEventListener('input', function() {
        document.getElementById('previewDescription').textContent = this.value;
    });

    copyrightText.addEventListener('input', function() {
        document.getElementById('previewCopyright').textContent = this.value;
    });

    visibilityToggles.forEach(toggle => {
        function updateVisibility() {
            document.getElementById(toggle.dataset.preview).hidden = !toggle.checked;
        }

        toggle.addEventListener('change', updateVisibility);
        updateVisibility();
    });
</script>