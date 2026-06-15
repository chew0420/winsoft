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
        <div class="main-content p-4" style="width: 100%;">
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-file-person"></i> My Job History</h2>
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
                                    <th>Completed DateTime</th>
                                    <th>Final Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobHistories as $job)
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
                                    <td>{{ \Carbon\Carbon::parse($job->completed_date)->format('d/m/Y') }}</td>
                                    <td>RM {{ $job->final_price }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $job->request_id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <p class="mt-2">No job completed</p>
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