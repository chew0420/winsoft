<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/superadmin.css" rel="stylesheet"/>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="d-flex">
        <div class="main-content p-4" style="width: 100%; min-width: 0;">

            @foreach(['success', 'error'] as $messageType)
                @if(session()->has($messageType))
                    <div class="alert alert-{{ $messageType == 'success' ? 'success' : 'danger' }} alert-dismissible fade show">
                        {{ session()->get($messageType) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            @endforeach

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-tools"></i> Service Request Management</h2>
                <p class="mb-0">Manage repair bookings, technician assignments and service progress.</p>
            </div>

            @php
                $statusLabels = [
                    'all' => 'All Requests',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'in-progress' => 'In Progress',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled'
                ];

                $statusColors = [
                    'all' => 'dark',
                    'pending' => 'warning',
                    'confirmed' => 'info',
                    'in-progress' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger'
                ];
            @endphp

            {{-- Statistics --}}
            <div class="row g-3 mb-4">
                @foreach($statusLabels as $key => $label)
                    <div class="col-6 col-md-4 col-xl-2">
                        <a href="{{ url('/superadmin/serviceRequestList?status='.$key) }}" class="text-decoration-none">
                            <div class="card h-100 {{ $current_status == $key ? 'border-primary' : '' }}">
                                <div class="card-body">
                                    <small class="text-muted">{{ $label }}</small>
                                    <h3 class="mt-2 mb-0 text-{{ $statusColors[$key] }}">{{ $counts[$key] }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Requests Table --}}
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-3 p-3">
                    <h5 class="mb-0">{{ $statusLabels[$current_status] }}</h5>
                    <input type="text" class="form-control" id="requestSearch" placeholder="Search service requests..." style="max-width: 260px;">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Device & Service</th>
                                <th>Appointment</th>
                                <th>Location</th>
                                <th>Technician</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($requests as $service)
                                <tr class="service-request-row">
                                    <td class="fw-bold">#{{ $service->request_id }}</td>

                                    <td>
                                        <strong>{{ $service->user->name ?? 'Unknown' }}</strong><br>
                                        <small class="text-muted">{{ $service->user->phone_number ?? '-' }}</small>
                                    </td>

                                    <td>
                                        <strong>{{ $service->device_type ?? 'Unknown Device' }}</strong><br>
                                        <small>{{ $service->device_brand }} {{ $service->device_model }}</small><br>
                                        <small class="text-muted">{{ $service->service_type }}</small>
                                    </td>

                                    <td>
                                        {{ $service->preferred_date ? date('d M Y', strtotime($service->preferred_date)) : '-' }}<br>
                                        <small class="text-muted">{{ $service->preferred_time ? date('h:i A', strtotime($service->preferred_time)) : '-' }}</small>
                                    </td>

                                    <td>
                                        @if($service->service_option == 'walk-in')
                                            <span class="badge bg-secondary">Walk-in</span><br>
                                            <small>{{ $service->service_location ?? 'Not specified' }}</small>
                                        @else
                                            <span class="badge bg-info">On-Site</span><br>
                                            <small>{{ \Illuminate\Support\Str::limit($service->address ?? '', 35) }}</small>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $service->technician->name ?? 'Not Assigned' }}
                                    </td>

                                    <td>
                                        <span class="badge text-bg-{{ $statusColors[$service->status] ?? 'secondary' }}">
                                            {{ $statusLabels[$service->status] ?? $service->status }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#requestView{{ $service->request_id }}">
                                                <i class="bi bi-eye"></i> View
                                            </button>

                                            @if(in_array($service->status, ['pending', 'confirmed']))
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignModal{{ $service->request_id }}">
                                                    {{ $service->technician_id ? 'Reassign' : 'Assign' }}
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <p class="mt-2 mb-0">No service requests found.</p>
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="noMatchingRequests" style="display: none;">
                                <td colspan="8" class="text-center py-4 text-muted">No matching service requests.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modals --}}
            @foreach($requests as $service)

                {{-- View Details --}}
                <div class="modal fade" id="requestView{{ $service->request_id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Service Request #{{ $service->request_id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <strong>Customer</strong>
                                        <p>{{ $service->user->name ?? 'Unknown' }}</p>
                                        <strong>Email</strong>
                                        <p>{{ $service->user->email ?? '-' }}</p>
                                        <strong>Phone</strong>
                                        <p>{{ $service->user->phone_number ?? '-' }}</p>
                                        <strong>Device</strong>
                                        <p>{{ $service->device_type }} {{ $service->device_brand }} {{ $service->device_model }}</p>
                                        <strong>Service Type</strong>
                                        <p>{{ $service->service_type }}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <strong>Appointment</strong>
                                        <p>{{ $service->preferred_date ?? '-' }} · {{ $service->preferred_time ?? '-' }}</p>
                                        <strong>Technician</strong>
                                        <p>{{ $service->technician->name ?? 'Not Assigned' }}</p>
                                        <strong>Status</strong>
                                        <p>{{ $statusLabels[$service->status] ?? $service->status }}</p>
                                        <strong>Quotation</strong>
                                        <p>{{ !is_null($service->quotation) ? 'RM '.number_format($service->quotation, 2) : 'Pending' }}</p>
                                        <strong>Final Price</strong>
                                        <p>{{ !is_null($service->final_price) ? 'RM '.number_format($service->final_price, 2) : 'Pending' }}</p>
                                    </div>
                                </div>

                                <hr>

                                <strong>Service Location</strong>
                                <p>{{ $service->service_option == 'walk-in' ? ($service->service_location ?? 'Not specified') : ($service->address ?? 'Not provided') }}</p>

                                <strong>Problem Description</strong>
                                <p>{{ $service->problem_description ?? 'Not provided' }}</p>

                                <strong>Repair History</strong>
                                <div class="bg-light rounded p-3 mt-2" style="white-space: pre-wrap;">{{ $service->technician_notes ?? 'No updates yet.' }}</div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Assign Technician --}}
                @if(in_array($service->status, ['pending', 'confirmed']))
                    <div class="modal fade" id="assignModal{{ $service->request_id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="post" action="{{ url('/superadmin/serviceRequestList/assign/'.$service->request_id) }}">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">Assign Technician #{{ $service->request_id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Select Technician</label>
                                            <select name="technician_id" class="form-select" required>
                                                <option value="">Select Technician</option>
                                                @foreach($technicians as $technician)
                                                    <option value="{{ $technician->user_id }}" {{ $service->technician_id == $technician->user_id ? 'selected' : '' }}>{{ $technician->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Quotation (RM)</label>
                                            <input type="number" name="quotation" class="form-control" min="0" max="99999999.99" step="0.01" value="{{ $service->quotation }}" placeholder="Optional estimated cost">
                                        </div>

                                        <div class="alert alert-info mb-0">
                                            Assigning a technician will confirm this service request.
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Confirm Assignment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    </div>

    <script>
        document.getElementById('requestSearch').addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.service-request-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const visible = row.textContent.toLowerCase().includes(keyword);
                row.style.display = visible ? '' : 'none';

                if(visible) visibleCount++;
            });

            document.getElementById('noMatchingRequests').style.display = rows.length > 0 && visibleCount === 0 ? '' : 'none';
        });
    </script>
</body>
</html>