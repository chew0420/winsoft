<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Location | {{ $websiteSettings->website_name }}</title>
    @include('shared.favicon')
    <link href="/css/visitor.css" rel="stylesheet"/>
</head>
<body>
    @include('visitor.navBar');
    @include('visitor.storeLocationPage.storeLocationPageContent');
    @include('footer')
</body>
</html>