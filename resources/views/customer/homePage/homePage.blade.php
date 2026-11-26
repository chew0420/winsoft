<!DOCTYPE html>
<html>
<head>
    <title>Home | {{ $websiteSettings->website_name }}</title>
    <link href="css/customer.css" rel="stylesheet"/>
    @include('shared.favicon')
</head>
<body>
    @include('customer.navBar')
    @include('customer.homePage.homePageContent')
    @include('footer')
</body>
</html>