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
                <h2><i class="bi bi-list-ul"></i> Assigned Job List</h2>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Service Type</th>
                                    <th>Service Option</th>
                                    <th>Preferred Date</th>
                                    <th>Preferred Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignedJobs as $request)
                                <tr>
                                    <td>{{ $request->request_id }}</td>
                                    <td>{{ $request->user->name }}</td>
                                    <td>{{ $request->service_type }}</td>
                                    <td>
                                        @if($request->service_option == 'door-to-door')
                                            <span class="badge bg-info">Door-to-Door</span>
                                        @else
                                            <span class="badge bg-secondary">Walk-in</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($request->preferred_date)) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->preferred_time)->format('h:i A') }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            if($request->status == 'pending') $statusClass = 'bg-warning';
                                            elseif($request->status == 'confirmed') $statusClass = 'bg-info';
                                            elseif($request->status == 'in-progress') $statusClass = 'bg-primary';
                                            elseif($request->status == 'completed') $statusClass = 'bg-success';
                                            else $statusClass = 'bg-danger';
                                        @endphp
                                        <span class="badge {{ $statusClass }}">{{ ucfirst($request->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ url('/technician/'.$request->request_id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2">No service requests found</p>
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
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>