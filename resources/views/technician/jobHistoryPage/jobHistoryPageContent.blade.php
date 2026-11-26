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

            {{-- Page Header --}}
            <div class="tj-banner">
                <div>
                    <span>TECHNICIAN WORKSPACE</span>
                    <h2>My Job History</h2>
                    <p>Review your completed repairs and service records.</p>
                </div>
                <div class="tj-banner-icon"><i class="bi bi-clock-history"></i></div>
            </div>

            {{-- Statistics --}}
            <div class="th-stats-grid">
                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-blue"><i class="bi bi-clipboard-check"></i></div>
                    <div>
                        <span>Completed Jobs</span>
                        <h3>{{ $stats['total_completed'] }}</h3>
                    </div>
                </div>

                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-green"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <span>Completed This Month</span>
                        <h3>{{ $stats['monthly_completed'] }}</h3>
                    </div>
                </div>

                <div class="tj-stat-card">
                    <div class="tj-stat-icon tj-icon-dark"><i class="bi bi-wallet2"></i></div>
                    <div>
                        <span>Total Service Value</span>
                        <h3>RM {{ number_format($stats['total_service_value'], 2) }}</h3>
                    </div>
                </div>
            </div>

            {{-- Job History --}}
            <section class="tj-workspace">
                <div class="tj-workspace-header">
                    <div>
                        <h4>Completed Jobs</h4>
                        <p>Search and review your previous repair jobs.</p>
                    </div>
                    <a href="{{ url('/technicianHomePage') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Active Jobs
                    </a>
                </div>

                {{-- Search & Filters --}}
                <div class="th-filter-bar">
                    <div class="th-filter-search">
                        <label for="historySearch">Search Jobs</label>
                        <div class="tj-search">
                            <i class="bi bi-search"></i>
                            <input type="text" id="historySearch" placeholder="Job ID, customer, device...">
                        </div>
                    </div>

                    <div class="th-filter-group">
                        <label for="fromDate">From Date</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>

                    <div class="th-filter-group">
                        <label for="toDate">To Date</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>

                    <div class="th-filter-group">
                        <label for="serviceFilter">Service Option</label>
                        <select id="serviceFilter" class="form-select">
                            <option value="all">All Services</option>
                            <option value="walk-in">Walk-in</option>
                            <option value="door-to-door">On-Site</option>
                        </select>
                    </div>

                    <button type="button" id="resetFilters" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>

                <div class="th-result-bar">
                    <span>Showing <strong id="visibleJobs">{{ $jobHistories->count() }}</strong> of {{ $jobHistories->count() }} completed jobs</span>
                </div>

                {{-- History Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 th-history-table">
                        <thead>
                            <tr>
                                <th>Job ID</th>
                                <th>Customer</th>
                                <th>Device & Service</th>
                                <th>Service Location</th>
                                <th>Completed At</th>
                                <th>Final Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($jobHistories as $job)
                                <tr class="th-job-row"
                                    data-date="{{ $job->completed_date ? \Carbon\Carbon::parse($job->completed_date)->format('Y-m-d') : '' }}"
                                    data-service="{{ $job->service_option }}">

                                    <td>
                                        <strong class="th-job-id">#{{ $job->request_id }}</strong>
                                        <span class="th-completed-label"><i class="bi bi-check-circle-fill"></i> Completed</span>
                                    </td>

                                    <td>
                                        <strong>{{ $job->user->name ?? 'Unknown Customer' }}</strong>
                                        <small>{{ $job->user->phone_number ?? 'Not provided' }}</small>
                                    </td>

                                    <td>
                                        <strong>{{ $job->device_type ?? 'Unknown Device' }}</strong>
                                        <small>{{ $job->device_brand }} {{ $job->device_model }}</small>
                                        <small>{{ $job->service_type }}</small>
                                    </td>

                                    <td>
                                        @if($job->service_option == 'walk-in')
                                            <span class="badge text-bg-secondary">Walk-in</span>
                                            <small>{{ $job->service_location ?? 'Not specified' }}</small>
                                        @else
                                            <span class="badge text-bg-info">On-Site</span>
                                            <small>{{ \Illuminate\Support\Str::limit($job->address ?? 'Not specified', 35) }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        @if($job->completed_date)
                                            <strong>{{ \Carbon\Carbon::parse($job->completed_date)->format('d M Y') }}</strong>
                                            <small>{{ \Carbon\Carbon::parse($job->completed_date)->format('h:i A') }}</small>
                                        @else
                                            <span class="text-muted">Not recorded</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!is_null($job->final_price))
                                            <strong class="th-final-price">RM {{ number_format($job->final_price, 2) }}</strong>
                                        @else
                                            <span class="text-muted">Not recorded</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $job->request_id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="tj-empty">
                                            <i class="bi bi-clock-history"></i>
                                            <h5>No completed jobs yet</h5>
                                            <p>Your completed repair jobs will appear here.</p>
                                            <a href="{{ url('/technicianHomePage') }}" class="btn btn-primary btn-sm">View Active Jobs</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="noHistoryResults" style="display: none;">
                                <td colspan="7">
                                    <div class="tj-empty">
                                        <i class="bi bi-search"></i>
                                        <h5>No matching jobs</h5>
                                        <p>Try changing your search or date filters.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- Job Details Modals --}}
            @foreach($jobHistories as $job)
                <div class="modal fade" id="viewModal{{ $job->request_id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <h5 class="modal-title">Job Details #{{ $job->request_id }}</h5>
                                    <small class="text-muted">Completed Service Record</small>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">

                                <div class="th-completion-banner">
                                    <div class="th-completion-icon"><i class="bi bi-check-lg"></i></div>
                                    <div>
                                        <strong>Repair Completed</strong>
                                        <p>{{ $job->completed_date ? \Carbon\Carbon::parse($job->completed_date)->format('d M Y, h:i A') : 'Completion date not recorded' }}</p>
                                    </div>
                                </div>

                                {{-- Customer Details --}}
                                <div class="th-modal-section">
                                    <h6><i class="bi bi-person"></i> Customer Information</h6>
                                    <div class="tj-detail-grid">
                                        <div>
                                            <span>Customer Name</span>
                                            <strong>{{ $job->user->name ?? 'Unknown Customer' }}</strong>
                                        </div>
                                        <div>
                                            <span>Phone Number</span>
                                            <strong>{{ $job->user->phone_number ?? 'Not provided' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                {{-- Device Details --}}
                                <div class="th-modal-section">
                                    <h6><i class="bi bi-laptop"></i> Device Information</h6>
                                    <div class="tj-detail-grid">
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
                                    </div>
                                </div>

                                {{-- Appointment Details --}}
                                <div class="th-modal-section">
                                    <h6><i class="bi bi-calendar-event"></i> Appointment Information</h6>
                                    <div class="tj-detail-grid">
                                        <div>
                                            <span>Preferred Date</span>
                                            <strong>{{ $job->preferred_date ? date('d M Y', strtotime($job->preferred_date)) : 'Not specified' }}</strong>
                                        </div>
                                        <div>
                                            <span>Preferred Time</span>
                                            <strong>{{ $job->preferred_time ? date('h:i A', strtotime($job->preferred_time)) : 'Not specified' }}</strong>
                                        </div>
                                        <div class="th-full-width">
                                            <span>Service Location</span>
                                            @if($job->service_option == 'walk-in')
                                                <strong>Walk-in · {{ $job->service_location ?? 'Not specified' }}</strong>
                                            @else
                                                <strong>On-Site · {{ $job->address ?? 'Not provided' }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Reported Issue --}}
                                <div class="tj-detail-section">
                                    <h6><i class="bi bi-exclamation-circle"></i> Reported Issue</h6>
                                    <p>{{ $job->problem_description ?? 'No description provided.' }}</p>
                                </div>

                                {{-- Repair History --}}
                                <div class="tj-detail-section">
                                    <h6><i class="bi bi-journal-text"></i> Repair History</h6>
                                    <div class="th-repair-notes">{{ $job->technician_notes ?? 'No repair notes recorded.' }}</div>
                                </div>

                                {{-- Pricing --}}
                                <div class="th-modal-section">
                                    <h6><i class="bi bi-receipt"></i> Service Pricing</h6>
                                    <div class="th-pricing-grid">
                                        <div>
                                            <span>Estimated Quotation</span>
                                            <strong>{{ !is_null($job->quotation) ? 'RM '.number_format($job->quotation, 2) : 'Not provided' }}</strong>
                                        </div>
                                        <div>
                                            <span>Final Service Price</span>
                                            <strong class="th-final-price">{{ !is_null($job->final_price) ? 'RM '.number_format($job->final_price, 2) : 'Not recorded' }}</strong>
                                        </div>
                                    </div>
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
        const historySearch = document.getElementById('historySearch');
        const fromDate = document.getElementById('fromDate');
        const toDate = document.getElementById('toDate');
        const serviceFilter = document.getElementById('serviceFilter');
        const historyRows = document.querySelectorAll('.th-job-row');

        function filterHistory() {
            const keyword = historySearch.value.toLowerCase().trim();
            const start = fromDate.value;
            const end = toDate.value;
            const service = serviceFilter.value;
            let visibleCount = 0;

            historyRows.forEach(row => {
                const completedDate = row.dataset.date;
                const serviceOption = row.dataset.service;

                const matchSearch = row.textContent.toLowerCase().includes(keyword);
                const matchFrom = !start || (completedDate && completedDate >= start);
                const matchTo = !end || (completedDate && completedDate <= end);
                const matchService = service === 'all' || serviceOption === service;
                const visible = matchSearch && matchFrom && matchTo && matchService;

                row.style.display = visible ? '' : 'none';

                if(visible) visibleCount++;
            });

            document.getElementById('visibleJobs').textContent = visibleCount;
            document.getElementById('noHistoryResults').style.display = historyRows.length > 0 && visibleCount === 0 ? '' : 'none';
        }

        historySearch.addEventListener('input', filterHistory);
        serviceFilter.addEventListener('change', filterHistory);

        fromDate.addEventListener('change', function() {
            toDate.min = this.value;

            if(toDate.value && toDate.value < this.value) {
                toDate.value = this.value;
            }

            filterHistory();
        });

        toDate.addEventListener('change', function() {
            fromDate.max = this.value;

            if(fromDate.value && fromDate.value > this.value) {
                fromDate.value = this.value;
            }

            filterHistory();
        });

        document.getElementById('resetFilters').addEventListener('click', function() {
            historySearch.value = '';
            fromDate.value = '';
            toDate.value = '';
            serviceFilter.value = 'all';

            fromDate.removeAttribute('max');
            toDate.removeAttribute('min');

            filterHistory();
        });
    </script>
</body>
</html>