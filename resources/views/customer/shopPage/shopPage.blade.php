<!DOCTYPE html>
<html>
<head>
    <title>Shop | {{ $websiteSettings->website_name }}</title>
    @include('shared.favicon')
    <link href="/css/customer.css" rel="stylesheet"/>
</head>
<body>
    @include('customer.navBar')
    @include('customer.shopPage.shopPageContent')
    @include('footer')
</body>
</html>