<!DOCTYPE html>
<html>
<head>
    <title>Contact Us | {{ $websiteSettings->website_name }}</title>
    @include('shared.favicon')
    <link href="/css/visitor.css" rel="stylesheet"/>
</head>
<body>
    @include('visitor.navBar')
    @include('visitor.contactUsPage.contactUsPageContent')
    @include('footer')
</body>
</html>