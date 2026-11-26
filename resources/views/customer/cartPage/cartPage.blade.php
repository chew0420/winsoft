<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | {{ $websiteSettings->website_name }}</title>
    @include('shared.favicon')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
</head>
<body>
    @include('customer.navBar')
    @include('customer.cartPage.cartPageContent')
    @include('footer')
</body>
</html>