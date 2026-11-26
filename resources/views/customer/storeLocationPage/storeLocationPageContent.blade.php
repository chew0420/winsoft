<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Store Locations | Winsoft Solutions</title>
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


@php
    $stores = [
        [
            'name' => 'Winsoft Solution (HQ)',
            'label' => 'Headquarters',
            'area' => 'Parit Raja, Johor',
            'image' => 'img/editor_20260617_115308.jpeg',
            'address' => '17, Jalan Cempaka 1, Taman Bunga Cempaka Biru, 86400 Parit Raja, Batu Pahat, Johor',
            'phone' => '07-1234 5678',
            'phone_link' => '+60712345678',
            'opening' => '09:15',
            'closing' => '18:45',
            'hours' => '9:15 AM - 6:45 PM',
            'map' => 'https://maps.app.goo.gl/UW84SctYLr9TPNLX7'
        ],
        [
            'name' => 'Winsoft Solution (BP)',
            'label' => 'Batu Pahat Branch',
            'area' => 'Batu Pahat, Johor',
            'image' => 'img/editor_20260617_115259.jpeg',
            'address' => '15, Jalan Kuning, Taman Bukit Pasir, 83000 Batu Pahat, Johor',
            'phone' => '018-666 9795',
            'phone_link' => '+60186669795',
            'opening' => '09:15',
            'closing' => '17:45',
            'hours' => '9:15 AM - 5:45 PM',
            'map' => 'https://maps.app.goo.gl/njEqwBP5PbfDy24p6'
        ]
    ];
@endphp

<div class="sl-page">
    <div class="sl-container">
        <div class="sl-breadcrumb">
            <a href="{{ url('/customerHomePage') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <span>Store Locations</span>
        </div>

        <section class="sl-hero">
            <div class="sl-hero-content">
                <span class="sl-eyebrow">Visit Our Stores</span>
                <h1>Find a Winsoft Store Near You</h1>
                <p>Visit our stores for computer products, professional repairs and technical support. Our team is ready to assist you.</p>
                <div class="sl-hero-meta">
                    <i class="fas fa-location-dot"></i>
                    <span>{{ count($stores) }} Store Locations in Johor</span>
                </div>
            </div>
            <div class="sl-hero-icon"><i class="fas fa-map-location-dot"></i></div>
        </section>

        <div class="sl-section-header">
            <div>
                <span class="sl-eyebrow">Our Locations</span>
                <h2>Visit Your Nearest Store</h2>
                <p>Choose a convenient location and let our team assist you.</p>
            </div>
            <span class="sl-location-count">{{ count($stores) }} Locations</span>
        </div>

        <div class="sl-stores-grid">
            @foreach($stores as $store)
                <article class="sl-store-card">
                    <div class="sl-image-wrapper">
                        <img src="{{ asset($store['image']) }}" alt="{{ $store['name'] }}" class="sl-store-image">
                        <div class="sl-image-fallback"><i class="fas fa-store"></i></div>
                        <span class="sl-store-label">{{ $store['label'] }}</span>
                        <span class="sl-store-status" data-opening="{{ $store['opening'] }}" data-closing="{{ $store['closing'] }}">
                            <span class="sl-status-dot"></span>
                            <span class="sl-status-text">Checking hours...</span>
                        </span>
                    </div>

                    <div class="sl-store-body">
                        <div class="sl-store-heading">
                            <h3>{{ $store['name'] }}</h3>
                            <span><i class="fas fa-location-dot"></i> {{ $store['area'] }}</span>
                        </div>

                        <div class="sl-store-details">
                            <div class="sl-detail-item">
                                <div class="sl-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                                <div class="sl-detail-content">
                                    <span>Store Address</span>
                                    <p>{{ $store['address'] }}</p>
                                </div>
                            </div>

                            <div class="sl-detail-item">
                                <div class="sl-detail-icon"><i class="fas fa-phone"></i></div>
                                <div class="sl-detail-content">
                                    <span>Contact Number</span>
                                    <a href="tel:{{ $store['phone_link'] }}">{{ $store['phone'] }}</a>
                                </div>
                            </div>

                            <div class="sl-detail-item">
                                <div class="sl-detail-icon"><i class="fas fa-clock"></i></div>
                                <div class="sl-detail-content">
                                    <span>Business Hours</span>
                                    <div class="sl-business-hours">
                                        <div class="sl-hours-row">
                                            <span>Monday - Saturday</span>
                                            <strong>{{ $store['hours'] }}</strong>
                                        </div>
                                        <div class="sl-hours-row">
                                            <span>Sunday</span>
                                            <strong class="sl-closed-text">Closed</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sl-store-actions">
                            <a href="{{ $store['map'] }}" target="_blank" rel="noopener noreferrer" class="sl-direction-btn"><i class="fas fa-location-arrow"></i> Get Directions <i class="fas fa-arrow-up-right-from-square sl-external-icon"></i></a>
                            <a href="tel:{{ $store['phone_link'] }}" class="sl-call-btn"><i class="fas fa-phone"></i> Call Store</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <section class="sl-support-banner">
            <div class="sl-support-icon"><i class="fas fa-screwdriver-wrench"></i></div>
            <div class="sl-support-content">
                <span class="sl-eyebrow">Repair & Technical Support</span>
                <h3>Need Professional Repair Services?</h3>
                <p>Book a repair appointment online and choose your preferred service location before visiting our store.</p>
            </div>
            <a href="{{ url('/customer/service') }}" class="sl-book-btn">Book a Service <i class="fas fa-arrow-right"></i></a>
        </section>

        <div class="sl-bottom-note">
            <i class="fas fa-circle-info"></i>
            <p>Store operating hours may vary during public holidays. We recommend contacting the store before your visit.</p>
        </div>
    </div>
</div>

<script>
    function updateStoreStatus() {
        const parts = new Intl.DateTimeFormat('en-GB', {
            timeZone: 'Asia/Kuala_Lumpur',
            weekday: 'short',
            hour: '2-digit',
            minute: '2-digit',
            hourCycle: 'h23'
        }).formatToParts(new Date());

        const current = {};
        parts.forEach(part => current[part.type] = part.value);

        const currentMinutes = Number(current.hour) * 60 + Number(current.minute);

        function toMinutes(time) {
            const [hours, minutes] = time.split(':').map(Number);
            return hours * 60 + minutes;
        }

        document.querySelectorAll('.sl-store-status').forEach(store => {
            const opening = toMinutes(store.dataset.opening);
            const closing = toMinutes(store.dataset.closing);
            const isOpen = current.weekday !== 'Sun' && currentMinutes >= opening && currentMinutes < closing;

            store.classList.toggle('sl-status-open', isOpen);
            store.classList.toggle('sl-status-closed', !isOpen);
            store.querySelector('.sl-status-text').textContent = isOpen ? 'Open Now' : 'Closed';
        });
    }

    document.querySelectorAll('.sl-store-image').forEach(image => {
        function showFallback() {
            image.style.display = 'none';
        }

        image.addEventListener('error', showFallback);
        if(image.complete && image.naturalWidth === 0) showFallback();
    });

    updateStoreStatus();
    setInterval(updateStoreStatus, 60000);
</script>