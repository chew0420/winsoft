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
    @if(session()->has('success'))
        <div class="flash-message flash-success">
            <i class="fas fa-check-circle"></i> {{ session()->get('success') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @elseif(session()->has('error'))
        <div class="flash-message flash-error">
            <i class="fas fa-exclamation-circle"></i> {{ session()->get('error') }}
        </div>
        <script>
            setTimeout(function() {
                let msg = document.querySelector('.flash-message');
                if(msg) msg.style.display = 'none';
            }, 3000);
        </script>
    @endif
    <div class="d-flex">
        <div class="main-content p-4" style="width: 100%;">
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-list-ul"></i> My Assigned Job List</h2>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Job ID</th>
                                    <th>Customer</th>
                                    <th>Service Type</th>
                                    <th>Service Option</th>
                                    <th>Preferred DateTime</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignedJobs as $job)
                                <tr>
                                    <td>{{ $job->request_id }}</td>
                                    <td>
                                        <strong>{{ $job->user->name }}</strong><br>
                                        <small class="text-muted">{{ $job->user->phone_number }}</small>
                                    </td>
                                    <td>{{ $job->service_type }}</td>
                                    <td>
                                        @if($job->service_option == 'door-to-door')
                                            <span class="badge bg-info">Door-to-Door</span>
                                        @else
                                            <span class="badge bg-secondary">Walk-in</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($job->preferred_date)) }} <br>
                                        <small>{{ $job->preferred_time ?? 'Any time' }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            if($job->status == 'pending') $statusClass = 'bg-warning';
                                            elseif($job->status == 'confirmed') $statusClass = 'bg-info';
                                            elseif($job->status == 'in-progress') $statusClass = 'bg-primary';
                                            elseif($job->status == 'completed') $statusClass = 'bg-success';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($job->status) }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{ $job->request_id }}">
                                            <i class="bi bi-pencil"></i> Update
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $job->request_id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Update Modal for each job -->
                                <div class="modal fade" id="updateModal{{ $job->request_id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Job ID {{ $job->request_id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form method="post" action="{{ url('/technician/updateStatus/'.$job->request_id) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="pending" {{ $job->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="confirmed" {{ $job->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="in-progress" {{ $job->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                            <option value="completed" {{ $job->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="cancelled" {{ $job->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Technician Notes</label>
                                                        <textarea name="technician_notes" class="form-control" rows="3" placeholder="Add notes about the repair..." required></textarea>
                                                    </div>
                                                    <div class="mb-3" id="priceField{{ $job->request_id }}" style="display: {{ $job->status == 'completed' ? 'block' : 'none' }};">
                                                        <label class="form-label">Final Price (RM)</label>
                                                        <input type="number" step="0.01" name="final_price" class="form-control" value="{{ $job->final_price }}" placeholder="Enter final price">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- View Modal for each job -->
                                <div class="modal fade" id="viewModal{{ $job->request_id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Job Details ID {{ $job->request_id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Customer:</strong> {{ $job->user->name }}</p>
                                                        <p><strong>Phone:</strong> {{ $job->user->phone_number }}</p>
                                                        <p><strong>Service Type:</strong> {{ $job->service_type }}</p>
                                                        <p><strong>Service Option:</strong> {{ ucfirst($job->service_option) }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Preferred Date:</strong> {{ date('d/m/Y', strtotime($job->preferred_date)) }}</p>
                                                        <p><strong>Preferred Time:</strong> {{ $job->preferred_time ?? 'Not specified' }}</p>
                                                        <p><strong>Device Brand:</strong> {{ $job->device_brand ?? 'Not specified' }}</p>
                                                        <p><strong>Status:</strong> {{ ucfirst($job->status) }}</p>
                                                    </div>
                                                </div>
                                                @if($job->service_option == 'door-to-door' && $job->address)
                                                <div class="mt-2">
                                                    <p><strong>Address:</strong></p>
                                                    <p>{{ $job->address }}</p>
                                                </div>
                                                @endif
                                                <div class="mt-2">
                                                    <p><strong>Problem Description:</strong></p>
                                                    <p>{{ $job->problem_description ?? 'No description provided' }}</p>
                                                </div>
                                                @if($job->technician_notes)
                                                <div class="mt-2">
                                                    <p><strong>Technician Notes:</strong></p>
                                                    <p>{!! nl2br(e($job->technician_notes)) !!}</p>
                                                </div>
                                                @endif
                                                @if($job->actual_price)
                                                <div class="mt-2">
                                                    <p><strong>Final Price:</strong> RM {{ number_format($job->actual_price, 2) }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2">No jobs assigned to you yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('select[name="status"]').forEach(select => {
            select.addEventListener('change', function() {
                var modalId = this.closest('.modal').id;
                var priceField = document.querySelector('#' + modalId + ' #priceField' + modalId.replace('updateModal', ''));
                if(priceField) {
                    if(this.value === 'completed') {
                        priceField.style.display = 'block';
                    } else {
                        priceField.style.display = 'none';
                    }
                }
            });
        });
    </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>