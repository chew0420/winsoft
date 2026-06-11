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
                <h2><i class="bi bi-people"></i> Staff Management</h2>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ url('/superadmin/staffList/addStaff') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Staff</a>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->user_id }}</td>
                                    <td>
                                        <i class="bi bi-person-circle me-2"></i>
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number ?? '-' }}</td>
                                    <td>
                                        @if($user->role == 'staff')
                                            <span class="badge bg-primary">Staff</span>
                                        @elseif($user->role == 'technician')
                                            <span class="badge bg-info">Technician</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->user_id }})"><i class="bi bi-trash"></i> Delete</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="mt-2">No staff found</p>
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

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
    function confirmDelete(userId) {
            if(confirm('Are you sure you want to delete this staff?')) {
                var form = document.getElementById('deleteForm');
                form.action = '/superadmin/staffList/delete/' + userId;
                form.submit();
            }
        }
    </script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>