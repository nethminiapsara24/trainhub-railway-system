<?php
// ====================================================================
// PROJECT NAME: TrainHub Railway System
// FILE NAME: route_map.php
// DESCRIPTION: Dedicated Standalone Live Leaflet Map for Railway Routes (Cleaned & Updated)
// ====================================================================

// 1. Header ගොනුව සම්බන්ධ කිරීම (බාහිර සිතියම් ලින්ක්ස් header.php හි ඇත)
require_once 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card bg-dark text-white p-4 shadow-lg border-0 rounded-3">
                <div class="text-center mb-4">
                    <span class="badge bg-info text-dark mb-2 px-3 py-2 text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px;">Interactive Map</span>
                    <h2 class="fw-bold text-white d-block">ඩිජිටල් ජාල සිතියම (Railway Route Map)</h2>
                    <p class="text-muted small">ශ්‍රී ලංකා දුම්රිය ජාලයේ ප්‍රධාන මාර්ග, ධාවන පථ සහ දුම්රිය ස්ථාන සජීවීව මෙතැනින් නරඹන්න.</p>
                </div>
                
                <div id="railway-map" class="shadow-sm my-3" style="height: 500px; width: 100%; border-radius: 8px; border: 1px solid #444;"></div>

                <div class="row mt-4 pt-3 border-top border-secondary small text-white-50">
                    <div class="col-md-4 mb-2">
                        <p class="m-0"><i class="fa fa-circle text-info me-2"></i><strong>ප්‍රධාන මාර්ගය (Main Line):</strong> <br>කොළඹ සිට බදුල්ල දක්වා (උඩරට දුම්රිය මාර්ගය)</p>
                    </div>
                    <div class="col-md-4 mb-2">
                        <p class="m-0"><i class="fa fa-circle text-warning me-2"></i><strong>මුහුදුබඩ මාර්ගය (Coast Line):</strong> <br>කොළඹ සිට මාතර/බෙලිඅත්ත දක්වා</p>
                    </div>
                    <div class="col-md-4 mb-2">
                        <p class="m-0"><i class="fa fa-circle text-success me-2"></i><strong>උතුරු මාර්ගය (Northern Line):</strong> <br>කොළඹ සිට යාපනය/කන්කසන්තුරය දක්වා</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. ශ්‍රී ලංකාව කේන්ද්‍ර කර ගනිමින් සිතියම ආරම්භ කිරීම (Latitude, Longitude, Zoom Level)
    var map = L.map('railway-map').setView([7.8731, 80.7718], 7.5);

    // 2. OpenStreetMap සිතියම් පින්තූර (Tiles) ලෝඩ් කිරීම
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // 3. ප්‍රධාන දුම්රිය ස්ථාන සිතියම මත සලකුණු කිරීම (Markers)
    var stationsData = [
        { name: "Colombo Fort (කොළඹ කොටුව)", coords: [6.9344, 79.8501] },
        { name: "Kandy (මහනුවර)", coords: [7.2896, 80.6324] },
        { name: "Badulla (බදුල්ල)", coords: [6.9934, 81.0550] },
        { name: "Matara (මාතර)", coords: [5.9514, 80.5436] },
        { name: "Jaffna (යාපනය)", coords: [9.6647, 80.0210] }
    ];

    stationsData.forEach(function(station) {
        L.marker(station.coords)
            .addTo(map)
            .bindPopup("<b>" + station.name + "</b><br>දුම්රිය ස්ථානය");
    });

    // 4. මුහුදුබඩ දුම්රිය මාර්ගය නිල් පැහැති රේඛාවකින් (Polyline) ඇඳ පෙන්වීම
    var coastalRoute = [
        [6.9344, 79.8501], // Colombo Fort
        [6.7730, 79.8816], // Panadura
        [6.5854, 79.9607], // Kalutara
        [6.1397, 80.1042], // Hikkaduwa
        [6.0329, 80.2168], // Galle
        [5.9514, 80.5436]  // Matara
    ];
    L.polyline(coastalRoute, {color: '#00d2ff', weight: 5, opacity: 0.9}).addTo(map);
</script>

<?php 
// 2. Footer ගොනුව සම්බන්ධ කිරීම
require_once 'includes/footer.php'; 
?>