<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solutions</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
{{-- =====================================================
     FLASH MESSAGE
===================================================== --}}

@if(session()->has('success'))

    <div class="profile-toast profile-toast-success">

        <span class="profile-toast-icon">
            ✓
        </span>

        <span>
            {{ session()->get('success') }}
        </span>

    </div>

@elseif(session()->has('error'))

    <div class="profile-toast profile-toast-error">

        <span class="profile-toast-icon">
            !
        </span>

        <span>
            {{ session()->get('error') }}
        </span>

    </div>

@endif



<div class="account-page">

    <div class="account-container">


        {{-- =====================================================
             PAGE HEADER
        ===================================================== --}}

        <div class="account-page-header">

            <div>

                <span class="account-eyebrow">
                    Account
                </span>

                <h1>
                    My Profile
                </h1>

                <p>
                    Manage your personal information
                    and delivery details.
                </p>

            </div>

        </div>



        <div class="account-layout">


            {{-- =================================================
                 SIDEBAR
            ================================================== --}}

            <aside class="account-sidebar">


                <div class="account-user-card">

                    <div class="account-avatar">

                        <i class="fas fa-user"></i>

                    </div>


                    <div class="account-user-info">

                        <strong>
                            {{ $customer->name }}
                        </strong>

                        <span>
                            {{ $customer->email }}
                        </span>

                    </div>

                </div>



                <nav class="account-menu">
                    <a
                        href="{{ url('/customer/profile') }}"
                        class="active"
                    >
                        <span class="account-menu-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <div>
                            <strong>
                                My Account
                            </strong>
                            <span>
                                Personal information
                            </span>
                        </div>
                    </a>


                    <a
                        href="{{ url('/customer/order') }}"
                    >
                        <span class="account-menu-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </span>
                        <div>
                            <strong>
                                My Purchase
                            </strong>
                            <span>
                                Orders and purchases
                            </span>
                        </div>
                    </a>

                    <a href="{{ url('/customer/serviceRequests') }}">
                        <span class="account-menu-icon"><i class="fas fa-screwdriver-wrench"></i></span>
                        <div>
                            <strong>Service Requests</strong>
                            <span>Repair and support</span>
                        </div>
                    </a>

                </nav>

            </aside>



            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}

            <main class="account-content">


                <section class="profile-main-card">


                    {{-- =========================================
                         HEADER
                    ========================================== --}}

                    <div class="profile-card-header">

                        <div>

                            <span class="profile-card-label">
                                Profile Information
                            </span>

                            <h2>
                                Personal Details
                            </h2>

                            <p>
                                Member since
                                {{ date('F Y', strtotime($customer->created_at)) }}
                            </p>

                        </div>


                        <div class="profile-mini-avatar">

                            <i class="fas fa-user"></i>

                        </div>

                    </div>



                    {{-- =========================================
                         VIEW MODE
                    ========================================== --}}

                    <div
                        id="viewMode"
                        class="profile-view-mode"
                    >


                        <div class="profile-info-grid">


                            {{-- NAME --}}

                            <div class="profile-info-item">

                                <div class="profile-info-icon">

                                    <i class="fas fa-user"></i>

                                </div>


                                <div>

                                    <span class="profile-info-label">
                                        Full Name
                                    </span>

                                    <strong id="viewName">
                                        {{ $customer->name }}
                                    </strong>

                                </div>

                            </div>



                            {{-- EMAIL --}}

                            <div class="profile-info-item">

                                <div class="profile-info-icon">

                                    <i class="fas fa-envelope"></i>

                                </div>


                                <div>

                                    <span class="profile-info-label">
                                        Email Address
                                    </span>

                                    <strong id="viewEmail">
                                        {{ $customer->email }}
                                    </strong>

                                </div>

                            </div>



                            {{-- PHONE --}}

                            <div class="profile-info-item">

                                <div class="profile-info-icon">

                                    <i class="fas fa-phone"></i>

                                </div>


                                <div>

                                    <span class="profile-info-label">
                                        Phone Number
                                    </span>

                                    <strong id="viewPhone">

                                        {{
                                            $customer->phone_number
                                            ?: 'Not provided'
                                        }}

                                    </strong>

                                </div>

                            </div>



                            {{-- ADDRESS --}}

                            <div class="profile-info-item profile-address-item">

                                <div class="profile-info-icon">

                                    <i class="fas fa-location-dot"></i>

                                </div>


                                <div>

                                    <span class="profile-info-label">
                                        Address
                                    </span>

                                    <strong id="viewAddress">

                                        {{
                                            $customer->address
                                            ?: 'Not provided'
                                        }}

                                    </strong>

                                </div>

                            </div>

                        </div>



                        <div class="profile-view-footer">

                            <button
                                type="button"
                                class="profile-edit-button"
                                onclick="showEditForm()"
                            >

                                <i class="fas fa-pen"></i>

                                Edit Profile

                            </button>

                        </div>

                    </div>



                    {{-- =========================================
                         EDIT MODE
                    ========================================== --}}

                    <div
                        id="editMode"
                        class="profile-edit-mode"
                    >

                        <form
                            method="POST"
                            action="{{ url('/customer/profile/update') }}"
                        >

                            @csrf



                            <div class="profile-form-grid">


                                {{-- NAME --}}

                                <div class="profile-form-group">

                                    <label>
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ $customer->name }}"
                                        required
                                    >

                                </div>



                                {{-- EMAIL --}}

                                <div class="profile-form-group">

                                    <label>
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ $customer->email }}"
                                        required
                                    >

                                </div>



                                {{-- PHONE --}}

                                <div class="profile-form-group">

                                    <label>
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        name="phone_number"
                                        value="{{ $customer->phone_number }}"
                                        placeholder="Enter your phone number"
                                    >

                                </div>



                                {{-- ADDRESS --}}

                                <div class="profile-form-group profile-form-full">

                                    <label>
                                        Address
                                    </label>

                                    <textarea
                                        name="address"
                                        rows="4"
                                        placeholder="Enter your delivery address"
                                    >{{ $customer->address }}</textarea>

                                </div>

                            </div>



                            <div class="profile-form-actions">


                                <button
                                    type="button"
                                    class="profile-cancel-button"
                                    onclick="hideEditForm()"
                                >

                                    Cancel

                                </button>


                                <button
                                    type="submit"
                                    class="profile-save-button"
                                >

                                    <span>
                                        Save Changes
                                    </span>

                                    <span>
                                        →
                                    </span>

                                </button>

                            </div>

                        </form>

                    </div>


                </section>

            </main>

        </div>

    </div>

</div>



<script>

    function showEditForm() {

        document
            .getElementById('viewMode')
            .style.display =
            'none';


        document
            .getElementById('editMode')
            .style.display =
            'block';

    }


    function hideEditForm() {

        document
            .getElementById('viewMode')
            .style.display =
            'block';


        document
            .getElementById('editMode')
            .style.display =
            'none';

    }



    setTimeout(
        function() {

            const toast =
                document.querySelector(
                    '.profile-toast'
                );


            if(toast) {

                toast.style.opacity =
                    '0';


                setTimeout(
                    function() {

                        toast.remove();

                    },
                    300
                );

            }

        },
        3000
    );

</script>
</body>
</html>