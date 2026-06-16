<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <div class="profile-wrapper">
        <!-- Sidebar -->
        <div class="profile-sidebar">
            <div class="sidebar-header">
                <div class="sidebar-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h3>{{ $customer->name }}</h3>
                <p>{{ $customer->email }}</p>
            </div>
            <div class="sidebar-menu">
                <a href="{{ url('/customer/profile') }}" class="active">
                    <i class="fas fa-user"></i> My Account
                </a>
                <a href="{{ url('/customer/order') }}">
                    <i class="fas fa-shopping-bag"></i> My Purchase
                </a>
            </div>
        </div>

        <div class="profile-content">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h2 id="displayName">{{ $customer->name }}</h2>
                    <p>Member since {{ date('F Y', strtotime($customer->created_at)) }}</p>
                </div>

                <div class="profile-body">
                    <div id="viewMode">
                        <div class="info-group">
                            <div class="info-label">Full Name:</div>
                            <div class="info-value" id="viewName">{{ $customer->name }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Email Address:</div>
                            <div class="info-value" id="viewEmail">{{ $customer->email }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Phone Number:</div>
                            <div class="info-value" id="viewPhone">{{ $customer->phone_number ?: 'Not provided' }}</div>
                        </div>
                        <div class="info-group">
                            <div class="info-label">Address:</div>
                            <div class="info-value" id="viewAddress">{{ $customer->address ?: 'Not provided' }}</div>
                        </div>
                        <div style="text-align: center; margin-top: 20px;">
                            <button class="edit-btn" onclick="showEditForm()">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                    
                    <!-- Edit Mode -->
                    <div id="editMode" class="edit-form">
                        <form method="post" action="{{ url('/customer/profile/update') }}">
                            @csrf
                            <label>Full Name:</label>
                            <input type="text" name="name" value="{{ $customer->name }}" required>
                            
                            <label>Email Address:</label>
                            <input type="email" name="email" value="{{ $customer->email }}" required>
                            
                            <label>Phone Number:</label>
                            <input type="text" name="phone_number" value="{{ $customer->phone_number }}">
                            
                            <label>Address:</label>
                            <textarea name="address" rows="3">{{ $customer->address }}</textarea>
                            
                            <div style="text-align: center;">
                                <button type="submit" class="save-btn">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                                <button type="button" class="cancel-btn" onclick="hideEditForm()">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <script>
        function showEditForm() {
            document.getElementById('viewMode').style.display = 'none';
            document.getElementById('editMode').style.display = 'block';
        }
        
        function hideEditForm() {
            document.getElementById('viewMode').style.display = 'block';
            document.getElementById('editMode').style.display = 'none';
        }
    </script>
</body>
</html>