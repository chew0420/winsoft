<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-sidebar {
            width: 280px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            height: fit-content;
        }
        
        .sidebar-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px;
            text-align: center;
            color: white;
        }
        
        .sidebar-avatar {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .sidebar-avatar i {
            font-size: 40px;
            color: #667eea;
        }
        
        .sidebar-header h3 {
            margin: 0;
            font-size: 18px;
        }
        
        .sidebar-header p {
            margin: 5px 0 0;
            font-size: 12px;
            opacity: 0.8;
        }
        
        .sidebar-menu {
            padding: 10px 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a i {
            width: 25px;
            margin-right: 10px;
            color: #666;
        }
        
        .sidebar-menu a:hover {
            background: #f8f9fa;
            color: #e42b2b;
        }
        
        .sidebar-menu a.active {
            background: #e42b2b20;
            color: #e42b2b;
            border-right: 3px solid #e42b2b;
        }
        
        .sidebar-menu a.active i {
            color: #e42b2b;
        }
        .profile-content {
            flex: 1;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            padding: 25px;
        }

        .profile-wrapper {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
        }
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .profile-avatar i {
            font-size: 50px;
            color: #667eea;
        }
        .profile-header h2 {
            margin: 0;
            font-size: 24px;
        }
        .profile-header p {
            margin: 5px 0 0;
            opacity: 0.9;
        }
        .profile-body {
            padding: 30px;
        }
        .info-group {
            margin-bottom: 20px;
            display: flex;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
        .info-label {
            width: 120px;
            font-weight: bold;
            color: #555;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .edit-btn {
            background: #e42b2b;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .edit-btn:hover {
            background: #c41e1e;
        }
        .save-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        .save-btn:hover {
            background: #218838;
        }
        .cancel-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .cancel-btn:hover {
            background: #5a6268;
        }
        .edit-form {
            display: none;
            margin-top: 20px;
        }
        .edit-form input, .edit-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .edit-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        }
        .flash-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .flash-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .view-mode {
            display: block;
        }
        @media (max-width: 768px) {
            .info-group {
                flex-direction: column;
            }
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
            .profile-wrapper {
                margin: 20px auto;
            }
        }
    </style>
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