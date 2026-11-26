<!DOCTYPE html>
<html>
    <head>
        <title>Shop | {{ $websiteSettings->website_name }}</title>
        @include('shared.favicon')
        <link href="css/visitor.css" rel="stylesheet"/>
    </head>
    <body>
        @include('visitor.navBar')
        @include('visitor.shopPage.shopPageContent')
        @include('footer')
    </body>
</html>