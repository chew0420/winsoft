<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winsoft Solution</title>
    <link href="/css/customer.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- store location content -->
    <div class="store-container">
        <div class="page-title">
            <h1>📍 Our Store Locations</h1>
            <p>Visit us at any of our convenient locations</p>
        </div>

        <div class="stores-grid">
            <!-- store HQ -->
            <div class="store-card">
                <img src="{{ asset('img/storehq.jpg') }}" alt="Winsoft Solution HQ" class="store-image" onerror="this.src='https://placehold.co/600x400/f0f0f0/333?text=Winsoft+HQ'">
                <div class="store-info">
                    <h2 class="store-name">Winsoft Solution (HQ)</h2>
                    <div class="store-address">
                        <i class="fas fa-map-marker-alt"></i> 
                        17, Jalan Cempaka 1, Taman Bunga Cempaka Biru,<br>
                        86400 Parit Raja, Batu Pahat, Johor
                    </div>
                    <div class="store-phone">
                        <i class="fas fa-phone"></i> 07-1234 5678
                    </div>
                    <div class="store-hours">
                        <i class="fas fa-clock"></i> 
                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 2:00 PM<br>
                        Sunday: Closed
                    </div>
                    <a href="https://maps.google.com/?q=1.8884,102.8834" target="_blank" class="map-link"><i class="fas fa-directions"></i> Get Directions</a>
                </div>
            </div>

            <!-- Store 2: Branch -->
            <div class="store-card">
                <img src="{{ asset('img/storebp.jpg') }}" alt="Winsoft Solution Branch" class="store-image" onerror="this.src='https://placehold.co/600x400/f0f0f0/333?text=Winsoft+Branch'">
                <div class="store-info">
                    <h2 class="store-name">Winsoft Solution (BP)</h2>
                    <div class="store-address">
                        <i class="fas fa-map-marker-alt"></i> 
                        15, Jalan Kuning, Taman Bukit Pasir,<br>
                        83000 Batu Pahat, Johor
                    </div>
                    <div class="store-phone">
                        <i class="fas fa-phone"></i> 07-8765 4321
                    </div>
                    <div class="store-hours">
                        <i class="fas fa-clock"></i> 
                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday: 9:00 AM - 2:00 PM<br>
                        Sunday: Closed
                    </div>
                    <a href="https://maps.google.com/?q=1.8413,102.8905" target="_blank" class="map-link"><i class="fas fa-directions"></i> Get Directions</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>