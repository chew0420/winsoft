@php
    $isCustomerPage = request()->is('customerHomePage', 'customer', 'customer/*');

    $footerLinks = [
        ['Home', $isCustomerPage ? '/customerHomePage' : '/'],
        ['Shopping', $isCustomerPage ? '/customer/shop' : '/shop'],
        ['Service', $isCustomerPage ? '/customer/service' : '/login'],
        ['Contact Us', $isCustomerPage ? '/customer/contactUs' : '/contactUs'],
        ['Store Location', $isCustomerPage ? '/customer/storeLocation' : '/storeLocation']
    ];

    $hasContact = $websiteSettings->contact_address || $websiteSettings->contact_phone || $websiteSettings->contact_email;
    $hasSocial = $websiteSettings->facebook_url || $websiteSettings->instagram_url || $websiteSettings->whatsapp_url;
@endphp

<footer class="site-footer">
    @if($websiteSettings->show_footer_brand || $websiteSettings->show_footer_links || ($websiteSettings->show_footer_contact && $hasContact))
        <div class="footer-container">

            @if($websiteSettings->show_footer_brand)
                <div class="footer-section footer-brand">
                    <img src="{{ $websiteSettings->logo_url }}" alt="{{ $websiteSettings->website_name }}">
                    <h3>{{ $websiteSettings->website_name }}</h3>
                    @if($websiteSettings->footer_description)
                        <p>{{ $websiteSettings->footer_description }}</p>
                    @endif
                </div>
            @endif

            @if($websiteSettings->show_footer_links)
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        @foreach($footerLinks as $link)
                            <li>
                                <a href="{{ url($link[1]) }}">
                                    <i class="fas fa-angle-right"></i> {{ $link[0] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($websiteSettings->show_footer_contact && $hasContact)
                <div class="footer-section">
                    <h4>Contact Us</h4>
                    <div class="footer-contact">

                        @if($websiteSettings->contact_address)
                            <div class="footer-contact-item">
                                <i class="fas fa-location-dot"></i>
                                <a href="{{ $websiteSettings->contact_map_url }}" target="_blank" rel="noopener noreferrer">{{ $websiteSettings->contact_address }}</a>
                            </div>
                        @endif

                        @if($websiteSettings->contact_phone)
                            <div class="footer-contact-item">
                                <i class="fas fa-phone"></i>
                                <a href="{{ $websiteSettings->phone_link }}">{{ $websiteSettings->contact_phone }}</a>
                            </div>
                        @endif

                        @if($websiteSettings->contact_email)
                            <div class="footer-contact-item">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $websiteSettings->contact_email }}">{{ $websiteSettings->contact_email }}</a>
                            </div>
                        @endif

                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p>&copy; {{ date('Y') }} {{ $websiteSettings->copyright_text }}</p>

            @if($websiteSettings->show_footer_social && $hasSocial)
                <div class="footer-social">
                    @if($websiteSettings->facebook_url)
                        <a href="{{ $websiteSettings->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif

                    @if($websiteSettings->instagram_url)
                        <a href="{{ $websiteSettings->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif

                    @if($websiteSettings->whatsapp_url)
                        <a href="{{ $websiteSettings->whatsapp_url }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</footer>