<!DOCTYPE html>
<html>
<head>
    <title>Home | {{ $websiteSettings->website_name }}</title>
    @include('shared.favicon')
    <link href="css/visitor.css" rel="stylesheet"/>
</head>
<body>
    @include('visitor.navBar')
    @include('visitor.homePage.homePageContent')
    @include('footer')
</body>
</html>