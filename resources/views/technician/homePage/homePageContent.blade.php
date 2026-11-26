<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/technician.css" rel="stylesheet"/>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="d-flex">
        <main class="main-content p-4 tj-page">

            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="tj-banner">
                <div>
                    <span>TECHNICIAN WORKSPACE</span>
                    <h2>Welcome, {{ $technician->name }}</h2>
                    <p>Manage your assigned jobs and repair appointments.</p>
                </div>
                <div class="tj-banner-icon"><i class="bi bi-tools"></i></div>
            </div>

            <div class="tj-stats-grid">
                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-dark"><i class="bi bi-clipboard-list"></i></div>
                    <div>
                        <span>Active Jobs</span>
                        <h3>{{ $counts['all'] }}</h3>
                    </div>
                </div>

                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-blue"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <span>Confirmed</span>
                        <h3>{{ $counts['confirmed'] }}</h3>
                    </div>
                </div>

                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-orange"><i class="bi bi-wrench"></i></div>
                    <div>
                        <span>In Progress</span>
                        <h3>{{ $counts['in-progress'] }}</h3>
                    </div>
                </div>

                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-green"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <span>Completed</span>
                        <h3>{{ $counts['completed'] }}</h3>
                    </div>
                </div>
            </div>

            <section class="tj-workspace">
                <div class="tj-workspace-header">
                    <div>
                        <h4>My Assigned Jobs</h4>
                        <p>View and manage your upcoming repair appointments.</p>
                    </div>

                    <div class="tj-search">
                        <i class="bi bi-search"></i>
                        <input type="text" id="jobSearch" placeholder="Search jobs...">
                    </div>
                </div>

                <div class="tj-tabs">
                    <button type="button" class="tj-tab active" data-filter="all">All Jobs</button>
                    <button type="button" class="tj-tab" data-filter="pending">Pending ({{ $counts['pending'] }})</button>
                    <button type="button" class="tj-tab" data-filter="confirmed">Confirmed</button>
                    <button type="button" class="tj-tab" data-filter="in-progress">In Progress</button>
                </div>

                <div class="tj-job-grid">
                    @forelse($assignedJobs as $job)
                        @php
                            $statusColors = [
                                'pending' => 'warning',
                                'confirmed' => 'info',
                                'in-progress' => 'primary'
                            ];

                            $deviceIcons = [
                                'Desktop Computer' => 'bi-pc-display',
                                'Laptop' => 'bi-laptop',
                                'Smartphone' => 'bi-phone',
                                'Tablet' => 'bi-tablet',
                                'Printer' => 'bi-printer',
                                'Monitor' => 'bi-display',
                                'Server' => 'bi-server',
                                'Network Device' => 'bi-router'
                            ];

                            $deviceIcon = $deviceIcons[$job->device_type] ?? 'bi-tools';
                        @endphp

                        <article class="tj-job-card" data-status="{{ $job->status }}">
                            <div class="tj-job-header">
                                <span>JOB #{{ $job->request_id }}</span>
                                <span class="badge text-bg-{{ $statusColors[$job->status] ?? 'secondary' }}">
                                    {{ ucwords(str_replace('-', ' ', $job->status)) }}
                                </span>
                            </div>

                            <div class="tj-job-body">
                                <div class="tj-device">
                                    <div class="tj-device-icon"><i class="bi {{ $deviceIcon }}"></i></div>
                                    <div>
                                        <h5>{{ $job->device_type ?? 'Unknown Device' }}</h5>
                                        <p>{{ $job->device_brand }} {{ $job->device_model }}</p>
                                    </div>
                                </div>

                                <div class="tj-job-service">{{ $job->service_type }}</div>

                                <div class="tj-job-info">
                                    <div>
                                        <i class="bi bi-person"></i>
                                        <span>{{ $job->user->name ?? 'Unknown Customer' }}</span>
                                    </div>

                                    <div>
                                        <i class="bi bi-telephone"></i>
                                        <span>{{ $job->user->phone_number ?? 'Not provided' }}</span>
                                    </div>

                                    <div>
                                        <i class="bi bi-calendar3"></i>
                                        <span>{{ $job->preferred_date ? date('d M Y', strtotime($job->preferred_date)) : 'Not specified' }}</span>
                                    </div>

                                    <div>
                                        <i class="bi bi-clock"></i>
                                        <span>{{ $job->preferred_time ? date('h:i A', strtotime($job->preferred_time)) : 'Not specified' }}</span>
                                    </div>

                                    <div class="tj-location">
                                        <i class="bi bi-geo-alt"></i>
                                        @if($job->service_option == 'walk-in')
                                            <span>Walk-in · {{ $job->service_location ?? 'Not specified' }}</span>
                                        @else
                                            <span>On-Site · {{ $job->address ?? 'Not specified' }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="tj-problem">
                                    <span>Reported Issue</span>
                                    <p>{{ $job->problem_description ?? 'No description provided' }}</p>
                                </div>
                            </div>

                            <div class="tj-job-footer">
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $job->request_id }}">View Details</button>

                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal{{ $job->request_id }}">
                                    @if($job->status == 'pending')
                                        Confirm Job
                                    @elseif($job->status == 'confirmed')
                                        Start Repair
                                    @else
                                        Update Job
                                    @endif
                                </button>
                            </div>
                        </article>
                    @empty
                        <div class="tj-empty">
                            <i class="bi bi-clipboard-check"></i>
                            <h5>No assigned jobs</h5>
                            <p>New service requests will appear here when assigned to you.</p>
                        </div>
                    @endforelse
                </div>

                <div id="noMatchingJobs" class="tj-empty" style="display: none;">
                    <i class="bi bi-search"></i>
                    <h5>No matching jobs</h5>
                    <p>Try a different search or status filter.</p>
                </div>
            </section>

            {{-- Job Modals --}}
            @foreach($assignedJobs as $job)

                {{-- Update Job Modal --}}
                <div class="modal fade" id="updateModal{{ $job->request_id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="post" action="{{ url('/technician/updateStatus/'.$job->request_id) }}">
                                @csrf

                                <div class="modal-header">
                                    <h5 class="modal-title">Update Job #{{ $job->request_id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Job Status</label>
                                        <select name="status" class="form-select tj-status-select" required>
                                            @if($job->status == 'pending')
                                                <option value="confirmed">Confirm Job</option>
                                            @elseif($job->status == 'confirmed')
                                                <option value="in-progress">Start Repair</option>
                                                <option value="confirmed">Keep Confirmed</option>
                                            @elseif($job->status == 'in-progress')
                                                <option value="in-progress">Update Progress</option>
                                                <option value="completed">Complete Repair</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Quotation (RM)</label>
                                        <input type="number" name="quotation" class="form-control" min="0" max="99999999.99" step="0.01" value="{{ $job->quotation }}" placeholder="Estimated repair cost">
                                        <small class="text-muted">Optional estimated repair cost.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Repair Progress / Technician Notes</label>
                                        <textarea name="technician_notes" class="form-control" rows="4" maxlength="2000" required placeholder="Describe the diagnosis, repair progress or result..."></textarea>
                                        <small class="text-muted">These notes may be visible to the customer.</small>
                                    </div>

                                    <div class="mb-3 tj-final-price-field" style="display: none;">
                                        <label class="form-label">Final Price (RM)</label>
                                        <input type="number" name="final_price" class="form-control" min="0" max="99999999.99" step="0.01" placeholder="Enter final repair cost" disabled>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- View Job Modal --}}
                <div class="modal fade" id="viewModal{{ $job->request_id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Job Details #{{ $job->request_id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="tj-detail-grid">
                                    <div>
                                        <span>Customer Name</span>
                                        <strong>{{ $job->user->name ?? 'Unknown' }}</strong>
                                    </div>
                                    <div>
                                        <span>Phone Number</span>
                                        <strong>{{ $job->user->phone_number ?? 'Not provided' }}</strong>
                                    </div>
                                    <div>
                                        <span>Device Type</span>
                                        <strong>{{ $job->device_type ?? 'Not specified' }}</strong>
                                    </div>
                                    <div>
                                        <span>Device Brand</span>
                                        <strong>{{ $job->device_brand ?? 'Not specified' }}</strong>
                                    </div>
                                    <div>
                                        <span>Device Model</span>
                                        <strong>{{ $job->device_model ?? 'Not specified' }}</strong>
                                    </div>
                                    <div>
                                        <span>Service Type</span>
                                        <strong>{{ $job->service_type }}</strong>
                                    </div>
                                    <div>
                                        <span>Appointment Date</span>
                                        <strong>{{ $job->preferred_date ? date('d M Y', strtotime($job->preferred_date)) : '-' }}</strong>
                                    </div>
                                    <div>
                                        <span>Appointment Time</span>
                                        <strong>{{ $job->preferred_time ? date('h:i A', strtotime($job->preferred_time)) : '-' }}</strong>
                                    </div>
                                    <div>
                                        <span>Quotation</span>
                                        <strong>{{ !is_null($job->quotation) ? 'RM '.number_format($job->quotation, 2) : 'Pending' }}</strong>
                                    </div>
                                    <div>
                                        <span>Final Price</span>
                                        <strong>{{ !is_null($job->final_price) ? 'RM '.number_format($job->final_price, 2) : 'Pending' }}</strong>
                                    </div>
                                </div>

                                <div class="tj-detail-section">
                                    <h6>Service Location</h6>
                                    @if($job->service_option == 'walk-in')
                                        <p>Walk-in · {{ $job->service_location ?? 'Not specified' }}</p>
                                    @else
                                        <p>On-Site · {{ $job->address ?? 'Not specified' }}</p>
                                    @endif
                                </div>

                                <div class="tj-detail-section">
                                    <h6>Problem Description</h6>
                                    <p>{{ $job->problem_description ?? 'Not provided' }}</p>
                                </div>

                                <div class="tj-detail-section">
                                    <h6>Repair History</h6>
                                    <p class="tj-note-history">{{ $job->technician_notes ?? 'No repair updates yet.' }}</p>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </main>
    </div>

    <script>
        const tabs = document.querySelectorAll('.tj-tab');
        const jobCards = document.querySelectorAll('.tj-job-card');
        const searchInput = document.getElementById('jobSearch');
        let currentFilter = 'all';

        function filterJobs() {
            const keyword = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            jobCards.forEach(card => {
                const matchStatus = currentFilter === 'all' || card.dataset.status === currentFilter;
                const matchSearch = card.textContent.toLowerCase().includes(keyword);
                const visible = matchStatus && matchSearch;

                card.style.display = visible ? '' : 'none';
                if(visible) visibleCount++;
            });

            document.getElementById('noMatchingJobs').style.display = jobCards.length > 0 && visibleCount === 0 ? 'block' : 'none';
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(item => item.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                filterJobs();
            });
        });

        searchInput.addEventListener('input', filterJobs);

        document.querySelectorAll('.tj-status-select').forEach(select => {
            function updatePriceField() {
                const modal = select.closest('.modal');
                const priceField = modal.querySelector('.tj-final-price-field');
                const priceInput = priceField.querySelector('input');
                const isCompleted = select.value === 'completed';

                priceField.style.display = isCompleted ? 'block' : 'none';
                priceInput.required = isCompleted;
                priceInput.disabled = !isCompleted;
            }

            select.addEventListener('change', updatePriceField);
            updatePriceField();
        });
    </script>
</body>
</html>