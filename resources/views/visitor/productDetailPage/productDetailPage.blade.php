<!DOCTYPE html>
<html>
<head>
    <title>Product Detail | {{ $websiteSettings->website_name }}</title>
    @include('shared.favicon')
    <link href="/css/visitor.css" rel="stylesheet"/>
</head>
<body>
    @include('visitor.navBar')
    @include('visitor.productDetailPage.productDetailPageContent')
    @include('footer')
</body>
</html>