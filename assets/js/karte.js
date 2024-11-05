/**
 * Verwendete Quellen / Tutorials. Optimiert mit ChatGPT
 * Leaflet: https://leafletjs.com/examples/quick-start/
 * Nominatim: https://nominatim.org/release-docs/latest/api/Reverse/#how-it-works
 */
// Funktion zur Initialisierung der Leaflet-Karte
function initMap(lat, lng, zoomLevel) {
    var map = L.map('map').setView([lat, lng], zoomLevel);

    // Tile-Layer für die Karte hinzufügen (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    return map;
}

// Funktion zum Reverse-Geocoding via Nominatim
function reverseGeocode(lat, lng, popup, locationInput) {
    var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data && data.address) {
                var road = data.address.road || '';
                var houseNumber = data.address.house_number || '';
                var postcode = data.address.postcode || '';
                var city = data.address.city || data.address.town || data.address.village || '';

                var shortAddress = `${road} ${houseNumber}, ${postcode} ${city}`.trim();

                locationInput.value = shortAddress;

                popup
                    .setLatLng([lat, lng])
                    .setContent(shortAddress)
                    .openOn(map);
            } else {
                alert("Adresse konnte nicht ermittelt werden.");
            }
        })
        .catch(error => {
            console.error('Fehler beim Reverse Geocoding:', error);
        });
}

// Funktion zum Hinzufügen von Markern auf der Karte für Beiträge
function addMarkersToMap(map, beitraege) {
    beitraege.forEach(function(beitrag) {
        // Marker mit lat/lng für jeden Beitrag hinzufügen
        const marker = L.marker([beitrag.lat, beitrag.lng]).addTo(map);

        // Popup für jeden Marker mit Titel, Location und Link
        marker.bindPopup("<b><a href='beitrag-anzeigen.php?id=" + beitrag.id + "'>" + beitrag.title + "</a></b><br>" + beitrag.location);
    });
}
