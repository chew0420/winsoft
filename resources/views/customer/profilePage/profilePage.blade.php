<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Winsoft Solutions</title>
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    @include('customer.navBar')
    @include('customer.profilePage.profilePageContent')
    @include('footer')
</body>
</html>