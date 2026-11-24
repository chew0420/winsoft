<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | Winsoft Solutions</title>
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet"/>
</head>
<body>
    @include('customer.navBar')
    @include('customer.productDetailPage.productDetailPageContent')
    @include('footer')
</body>
</html>