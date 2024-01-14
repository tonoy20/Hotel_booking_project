<?php 
    include("../server.php");
    $hotel_id = $_GET['h_id'];
    $sql1 = "SELECT * FROM `hotels` WHERE id = '$hotel_id'";
    $res1 = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_assoc($res1);
    $hotel_name = $row['hotel_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="images/icon/favicon.ico">
    <title>Hotel Map Location</title>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=API_KEY" defer></script>

    <script>
    function initMap() {
        // Initialize the map
        var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            zoom: 13,
            center: {lat: 0, lng: 0} // Centered at the initial location
        });

        // Try HTML5 geolocation to get the current user's location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Set the map center to the current location
                map.setCenter(pos);

                // Create a marker for the current location
                var marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    title: 'Current Location'
                });

                // Define the destination location
                var destination = new google.maps.LatLng(23.794571571898327, 90.4061992104241);

                // Create a marker for the destination
                var destinationMarker = new google.maps.Marker({
                    position: destination,
                    map: map,
                    title: '<?php echo $hotel_name; ?>',
                    icon : 'https://img.icons8.com/emoji/48/hotel-emoji.png'
                });

                // Create a directions service object to use the route method and get directions
                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();

                // Set the directions display to the map
                directionsDisplay.setMap(map);

                // Define the request object
                var request = {
                    origin: pos,
                    destination: destination,
                    travelMode: 'DRIVING'
                };

                // Use the directions service to get the route and display it on the map
                directionsService.route(request, function(response, status) {
                    if (status == 'OK') {
                        directionsDisplay.setDirections(response);
                    }
                });
            }, function() {
                // Handle location error
                handleLocationError(true, map.getCenter());
            });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, map.getCenter());
            }

        function handleLocationError(browserHasGeolocation, pos) {
            var infoWindow = new google.maps.InfoWindow({map: map});
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                  'Error: The Geolocation service failed.' :
                                  'Error: Your browser doesn\'t support geolocation.');
        }
    }
</script>

    <!-- <script>
// Initialize and add the map
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);
        
    // Multiple markers location, latitude, and longitude
    var markers = [
        ['Sheraton Hotel, BD', 23.794571571898327, 90.4061992104241]
    ];
                        
    // Info window content
    var infoWindowContent = [
        ['<div class="info_content">' +
        '<h2>Sheraton Hotel</h2>' +
        '<p>44 Kemal Ataturk Ave, Dhaka 1213, Bangladesh</p>' + 
        '</div>']
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });
}

window.initMap = initMap;

</script> -->

</head>
<style>
    #mapCanvas{
    width: 100%;
    height: 800px;
}
</style>
<body>
    <div id="mapCanvas"></div>
</body>
</html>
