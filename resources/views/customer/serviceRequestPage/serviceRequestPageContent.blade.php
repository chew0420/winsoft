<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solutions</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
@if(session()->has('success'))
    <div class="profile-toast profile-toast-success">
        <span class="profile-toast-icon">✓</span>
        <span>{{ session()->get('success') }}</span>
    </div>
@elseif(session()->has('error'))
    <div class="profile-toast profile-toast-error">
        <span class="profile-toast-icon">!</span>
        <span>{{ session()->get('error') }}</span>
    </div>
@endif

<div class="account-page">
    <div class="account-container">

        <div class="account-page-header">
            <span class="account-eyebrow">Account</span>
            <h1>My Service Requests</h1>
            <p>Track your repair bookings, appointments and technician progress.</p>
        </div>

        <div class="account-layout">

            {{-- Sidebar --}}
            <aside class="account-sidebar">
                <div class="account-user-card">
                    <div class="account-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="account-user-info">
                        <strong>{{ $customer->name }}</strong>
                        <span>{{ $customer->email }}</span>
                    </div>
                </div>

                <nav class="account-menu">
                    <a href="{{ url('/customer/profile') }}">
                        <span class="account-menu-icon"><i class="fas fa-user"></i></span>
                        <div>
                            <strong>My Account</strong>
                            <span>Personal information</span>
                        </div>
                    </a>

                    <a href="{{ url('/customer/order') }}">
                        <span class="account-menu-icon"><i class="fas fa-shopping-bag"></i></span>
                        <div>
                            <strong>My Purchase</strong>
                            <span>Orders and purchases</span>
                        </div>
                    </a>

                    <a href="{{ url('/customer/serviceRequests') }}" class="active">
                        <span class="account-menu-icon"><i class="fas fa-screwdriver-wrench"></i></span>
                        <div>
                            <strong>Service Requests</strong>
                            <span>Repair and support</span>
                        </div>
                    </a>
                </nav>
            </aside>

            {{-- Content --}}
            <main class="account-content">
                <section class="service-request-main">

                    <div class="service-request-header">
                        <div>
                            <span class="service-request-label">Repair & Support</span>
                            <h2>Service Requests</h2>
                            <p>Monitor your current and previous repair requests.</p>
                        </div>

                        <a href="{{ url('/customer/service') }}" class="service-new-request-btn">
                            <i class="fas fa-plus"></i> New Service Request
                        </a>
                    </div>

                    {{-- Status Tabs --}}
                    <div class="service-request-tabs">
                        <a href="{{ url('/customer/serviceRequests?status=all') }}" class="service-request-tab {{ $current_status == 'all' ? 'active' : '' }}">All</a>

                        <a href="{{ url('/customer/serviceRequests?status=pending') }}" class="service-request-tab {{ $current_status == 'pending' ? 'active' : '' }}">
                            Pending
                            @if($counts['pending'] > 0)
                                <span>{{ $counts['pending'] }}</span>
                            @endif
                        </a>

                        <a href="{{ url('/customer/serviceRequests?status=confirmed') }}" class="service-request-tab {{ $current_status == 'confirmed' ? 'active' : '' }}">
                            Confirmed
                            @if($counts['confirmed'] > 0)
                                <span>{{ $counts['confirmed'] }}</span>
                            @endif
                        </a>

                        <a href="{{ url('/customer/serviceRequests?status=in-progress') }}" class="service-request-tab {{ $current_status == 'in-progress' ? 'active' : '' }}">
                            In Progress
                            @if($counts['in-progress'] > 0)
                                <span>{{ $counts['in-progress'] }}</span>
                            @endif
                        </a>

                        <a href="{{ url('/customer/serviceRequests?status=completed') }}" class="service-request-tab {{ $current_status == 'completed' ? 'active' : '' }}">Completed</a>

                        <a href="{{ url('/customer/serviceRequests?status=cancelled') }}" class="service-request-tab {{ $current_status == 'cancelled' ? 'active' : '' }}">Cancelled</a>
                    </div>

                    <div class="service-request-list">

                        @if(count($serviceRequests) > 0)

                            @foreach($serviceRequests as $service)

                                @php
                                    $statusClass = '';

                                    if($service->status == 'pending') {
                                        $statusClass = 'sr-status-pending';
                                    } elseif($service->status == 'confirmed') {
                                        $statusClass = 'sr-status-confirmed';
                                    } elseif($service->status == 'in-progress') {
                                        $statusClass = 'sr-status-progress';
                                    } elseif($service->status == 'completed') {
                                        $statusClass = 'sr-status-completed';
                                    } elseif($service->status == 'cancelled') {
                                        $statusClass = 'sr-status-cancelled';
                                    }
                                @endphp

                                <article class="service-request-card">

                                    <div class="sr-card-header">
                                        <div>
                                            <strong>Request #{{ $service->request_id }}</strong>
                                            <span>{{ date('d M Y, H:i', strtotime($service->created_at)) }}</span>
                                        </div>

                                        <span class="sr-status {{ $statusClass }}">
                                            {{ ucwords(str_replace('-', ' ', $service->status)) }}
                                        </span>
                                    </div>

                                    <div class="sr-card-body">

                                        <div class="sr-device-section">
                                            <div class="sr-device-icon">
                                                <i class="fas fa-laptop"></i>
                                            </div>

                                            <div class="sr-device-info">
                                                <span>Device</span>
                                                <h3>
                                                    {{ $service->device_type ?: 'Device' }}
                                                    @if($service->device_brand)
                                                        · {{ $service->device_brand }}
                                                    @endif
                                                </h3>

                                                @if($service->device_model)
                                                    <p>{{ $service->device_model }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="sr-service-type">
                                            <span>Service Type</span>
                                            <strong>{{ $service->service_type }}</strong>
                                        </div>

                                        <div class="sr-info-grid">

                                            <div class="sr-info-item">
                                                <span><i class="fas fa-calendar"></i> Preferred Appointment</span>
                                                <strong>
                                                    {{ date('d M Y', strtotime($service->preferred_date)) }}
                                                    ·
                                                    {{ date('h:i A', strtotime($service->preferred_time)) }}
                                                </strong>
                                            </div>

                                            <div class="sr-info-item">
                                                <span><i class="fas fa-location-dot"></i> Service Method</span>

                                                @if($service->service_option == 'walk-in')
                                                    <strong>Walk-in</strong>
                                                    <small>{{ $service->service_location ?: 'Service centre not specified' }}</small>
                                                @else
                                                    <strong>On-Site Service</strong>
                                                    <small>{{ $service->address ?: 'Address not provided' }}</small>
                                                @endif
                                            </div>

                                            <div class="sr-info-item">
                                                <span><i class="fas fa-user-gear"></i> Technician</span>

                                                @if($service->technician)
                                                    <strong>{{ $service->technician->name }}</strong>
                                                @else
                                                    <strong class="sr-muted">Not assigned yet</strong>
                                                @endif
                                            </div>

                                            <div class="sr-info-item">
                                                <span><i class="fas fa-money-bill"></i> Quotation</span>

                                                @if(!is_null($service->quotation))
                                                    <strong>RM {{ number_format($service->quotation, 2) }}</strong>
                                                @else
                                                    <strong class="sr-muted">Pending</strong>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="sr-problem-box">
                                            <span>Problem Description</span>
                                            <p>{{ $service->problem_description }}</p>
                                        </div>

                                        @if($service->technician_notes)
                                            <div class="sr-technician-notes">
                                                <div>
                                                    <i class="fas fa-message"></i>
                                                    <strong>Technician Notes</strong>
                                                </div>
                                                <p>{{ $service->technician_notes }}</p>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="sr-card-footer">

                                        <div class="sr-price-info">
                                            <div>
                                                <span>Quotation</span>
                                                <strong>
                                                    {{ !is_null($service->quotation) ? 'RM '.number_format($service->quotation, 2) : '-' }}
                                                </strong>
                                            </div>

                                            <div>
                                                <span>Final Price</span>
                                                <strong class="{{ !is_null($service->final_price) ? 'sr-final-price' : '' }}">
                                                    {{ !is_null($service->final_price) ? 'RM '.number_format($service->final_price, 2) : '-' }}
                                                </strong>
                                            </div>
                                        </div>

                                        @if($service->status == 'pending')
                                            <form method="POST" action="{{ url('/customer/serviceRequests/cancel/'.$service->request_id) }}" onsubmit="return confirm('Are you sure you want to cancel this service request?');">
                                                @csrf
                                                <button type="submit" class="sr-cancel-btn">Cancel Request</button>
                                            </form>
                                        @endif

                                    </div>

                                </article>

                            @endforeach

                            <div class="purchase-pagination">
                                {{ $serviceRequests->appends(['status' => $current_status])->links() }}
                            </div>

                        @else

                            <div class="service-request-empty">
                                <div class="service-request-empty-icon">
                                    <i class="fas fa-screwdriver-wrench"></i>
                                </div>

                                <span>No Service Requests</span>
                                <h3>Nothing here yet</h3>
                                <p>You do not have any service requests under this category.</p>
                                <a href="{{ url('/customer/service') }}">Book Repair Service →</a>
                            </div>

                        @endif

                    </div>

                </section>
            </main>

        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        const toast = document.querySelector('.profile-toast');

        if(toast) {
            toast.style.opacity = '0';

            setTimeout(function() {
                toast.remove();
            }, 300);
        }
    }, 3000);
</script>
</body>
</html>