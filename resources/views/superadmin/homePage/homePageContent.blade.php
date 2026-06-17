<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="css/superadmin.css" rel="stylesheet"/>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="d-flex">
        <!-- Main Content - scrollable -->
        <div class="main-content p-4" style="width: 100%;">
            <!-- Welcome Banner -->
            <div class="welcome-banner p-4 mb-4">
                <h2><i class="bi bi-person-circle"></i> Welcome, {{ $admin-> name }}</h2> 
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="mb-0">{{ $totalUsers }}</h2>
                            <i class="bi bi-people stat-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Total Products</h5>
                            <h2 class="mb-0">{{ $totalProducts }}</h2>
                            <i class="bi bi-box-seam stat-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-warning text-dark">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Service Requests</h5>
                            <h2 class="mb-0">{{ $totalServices }}</h2>
                            <i class="bi bi-tools stat-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body position-relative">
                            <h5 class="card-title">Total Orders</h5>
                            <h2 class="mb-0">{{ $totalOrders }}</h2>
                            <i class="bi bi-cart stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card table-card">
                        <div class="card-header bg-white fw-bold">
                            <i class="bi bi-lightning-charge"></i> Quick Actions
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ url('/superadmin/pageList') }}" class="btn btn-outline-primary w-100 py-3">
                                        <i class="bi bi-pencil-square fs-4 d-block"></i>
                                        Edit Website
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ url('/superadmin/productList/addProduct') }}" class="btn btn-outline-success w-100 py-3">
                                        <i class="bi bi-plus-circle fs-4 d-block"></i>
                                        Add Product
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ url('/superadmin/staffList/addStaff') }}" class="btn btn-outline-warning w-100 py-3">
                                        <i class="bi bi-person-plus fs-4 d-block"></i>
                                        Add Staff
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ url('/superadmin/serviceRequestList') }}" class="btn btn-outline-info w-100 py-3">
                                        <i class="bi bi-file-text fs-4 d-block"></i>
                                        Assign Technician
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Service Requests -->
                 <div class="col-md-6 mb-4">
                    <div class="card table-card h-100">
                        <div class="card-header bg-white fw-bold">
                            <i class="bi bi-tools"></i> Recent Service Requests
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentServices as $service)
                                            <tr>
                                                <td>#{{ $service->request_id }}</td>
                                                <td>{{ $service->service_type }}</td>
                                                <td>
                                                    @php
                                                        $statusClass = match($service->status) {
                                                            'pending' => 'bg-warning',
                                                            'in-progress' => 'bg-info',
                                                            'completed' => 'bg-success',
                                                            default => 'bg-secondary'
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $statusClass }}">{{ $service->status }}</span>
                                                </td>
                                                <td>{{ date('d/m/Y', strtotime($service->created_at)) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No service requests</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="/superadmin/serviceRequestList" class="text-decoration-none">View all requests →</a>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Users -->
                <div class="col-md-6 mb-4">
                    <div class="card table-card h-100">
                        <div class="card-header bg-white fw-bold">
                            <i class="bi bi-people"></i> Recent Users
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentUsers as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $user->role }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No users found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="/superadmin/staffList" class="text-decoration-none">View all users →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>