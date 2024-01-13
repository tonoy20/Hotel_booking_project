<?php
include("../server.php");
include("includes/header.php");
?>
<section class="banner">
    <div class="banner-text-item">
        <div class="banner-heading">
            <h1>Find your Place to Stay!</h1>
        </div>
        <form class="form" action="page-1.php" method="POST">
            <input type="text" list="mylist" name="cityname" placeholder="Where would you like to go?">
            <datalist id="mylist">
                <?php
                $sql = "SELECT * FROM city";
                $res = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <option value="<?php echo $row['city_name']; ?>"><?php echo $row['city_name'] ?></option>
                <?php
                }
                ?>
            </datalist>

            <input placeholder="Check In" type="text" onfocus="this.type='date';
                      this.setAttribute('onfocus','');this.blur();this.focus();" name="checkinDate" class="date">
            <!-- <label for="" class="pe-2 dateTO">TO</label> -->
            <input placeholder="Check Out" type="text" onfocus="this.type='date';
                      this.setAttribute('onfocus','');this.blur();this.focus();" name="checkoutDate" class="date">
                      
            <!-- <input type="text" list="room_list" class="date" name="personRoom" placeholder="Room type">
            <datalist id="room_list">
                <option value="single room">Single Room</option>
                <option value="double room">Double Room</option>
                <option value="cottage">Cottage</option>
            </datalist>
            <input type="number" class="date" name="room_number" placeholder="Quantity?"> -->

            <script type="text/javascript">
                function ShowHideDiv(btnPassport) {
                    var dvPassport = document.getElementById("dvPassport");
                    if (btnPassport.value == "Guest") {
                        dvPassport.style.display = "block";
                        btnPassport.style.display = "none";
                    }
                }
            </script>
            <input id="btnPassport" type="button" style="width: 50%;" value="Guest" onclick="ShowHideDiv(this)" />

            <div id="dvPassport" style="display: none;">
                <input type="number" class="date" style="width: 45%;" name="guest" placeholder="Guests">
                <input type="number" class="date" style="width: 45%;" name="child" placeholder="children">
            </div>

            <input type="submit" name="submit" class="book" value="Search">
        </form>
    </div>
</section>

<div class="row">
    <h1 class="text-center fst-italic fw-bold p-5">Our Famous Hotels</h1>
    <?php
    $fetch_src = FETCH_SRC;
    $img_location = "";
    $room_price = '';

    $sql = "SELECT * FROM `hotels` LIMIT 6";
    $res = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($res)) {
        $sql2 = "SELECT * FROM `city` WHERE id = '$row[city_id]'";
        $res2 = mysqli_query($conn, $sql2);
        $city_name = "";
        while ($row2 = mysqli_fetch_assoc($res2)) {
            $city_name = $row2['city_name'];
        }
        $sql3 = "SELECT * FROM `hotel_image` WHERE hotel_id = '$row[id]'";
        $res3 = mysqli_query($conn, $sql3);
        while ($row3 = mysqli_fetch_assoc($res3)) {
            $img_location = $fetch_src . $row3['image'];
        }
        $sql4 = "SELECT * FROM `rooms` WHERE hotel_id = '$row[id]'";
        $res4 = mysqli_query($conn, $sql4);
        while ($row4 = mysqli_fetch_assoc($res4)) {
            $room_price = $row4['room_price'];
        }
    ?>
        <div class="wrapper">
            <a class="text-decoration-none text-dark" href="page-2.php?h_id=<?php echo $row['id']; ?>">
                <h1><?php echo $city_name; ?></h1>
                <div class="Cardimage" style="background:url(<?php echo $img_location; ?>) no-repeat; background-size: 100%;"></div>
                <div class="details">
                    <h1><em><?php echo $row['hotel_name'] ?></em></h1>
                    <h6><?php echo $row['hotel_address'] ?></h6>
                    <h5>Contact Number : <?php echo $row['contact_number'] ?></h5>
                    <p>Rating : <span>
                            <?php
                            for ($x = 0; $x < $row['rating']; $x++) {
                            ?>
                                <i class="bi bi-star-fill text-warning"></i>
                            <?php
                            }
                            ?>
                        </span></p>
                </div>
                <h2>Per day room : <?php echo $room_price ?>/=</h2>
            </a>
        </div>
    <?php
    }
    ?>
</div>


<!--=========Services===============-->
<section class="services">
    <div class="service-item">
        <img src="https://res.cloudinary.com/dxssqb6l8/image/upload/v1605293634/tour-guide_onzla9.png">
        <h2>8000+ Our Local Guides</h2>
    </div>
    <div class="service-item">
        <img src="https://res.cloudinary.com/dxssqb6l8/image/upload/v1605293738/reliability_jbpn4g.png">
        <h2>100% Trusted Tour Agency</h2>
    </div>
    <div class="service-item">
        <img src="https://res.cloudinary.com/dxssqb6l8/image/upload/v1605293635/experience_a3fduk.png">
        <h2>8+ Years of Travel Experience</h2>
    </div>
    <div class="service-item">
        <img src="https://res.cloudinary.com/dxssqb6l8/image/upload/v1605293634/feedback_s8z7d9.png">
        <h2>98% Our Travelers are Happy</h2>
    </div>
</section>

<!--===========About Us===============-->
<section class="about">
    <div class="about-img">
        <img src="https://m.media-amazon.com/images/I/91nTEvvLOzL.png">
    </div>
    <div class="about-text">
        <small>ABOUT OUR COMPANY</small>
        <h2>We are Hotel Booking Management Support Company</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud</p>

        <label><input type="checkbox" checked><span class="ps-2">consectetur adipisicing elit</span></label>
        <label><input type="checkbox" checked><span class="ps-2">consectetur adipisicing elit</span></label>
        <label><input type="checkbox"><span class="ps-2">consectetur adipisicing elit</span></label>
        <label><input type="checkbox"><span class="ps-2">consectetur adipisicing elit</span></label>
        <a href="#">ABOUT US</a>
    </div>
</section>


<script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyD1aBu6vyPBDKxkC6ZViP_ZsP_qqoGA1SM" defer></script>

<script>
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

        var markers = [];
        var infoWindowContent = [];
        <?php
        $locations = array();
        $sql2 = "SELECT * FROM `hotels`";
        $res2 = mysqli_query($conn, $sql2);
        while ($row2 = mysqli_fetch_assoc($res2)) {
            $locations[] = array('name' => $row2['hotel_name'], 'lat' => $row2['latitude'], 'lng' => $row2['longitude']);
        }
        for ($i = 0; $i < sizeof($locations); $i++) {
        ?>
            // Multiple markers location, latitude, and longitude
            markers.push(
                ['<?php echo $locations[$i]['name']; ?>', <?php echo $locations[$i]['lat']; ?>, <?php echo $locations[$i]['lng']; ?>],
            );

            infoWindowContent.push(
                ['<div class="info_content">' +
                    '<h6><?php echo $locations[$i]['name']; ?></h6>' +
                    '<p><?php echo $city_name; ?>, Bangladesh-1219</p>' +
                    '</div>'
                ],
            );

        <?php
        }
        ?>

        // Add multiple markers to map
        var infoWindow = new google.maps.InfoWindow(),
            marker, i;

        // Place each marker on the map  
        for (i = 0; i < markers.length; i++) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: 'https://img.icons8.com/fluency/48/marker.png'
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
            this.setZoom(7);
            google.maps.event.removeListener(boundsListener);
        });
    }

    window.initMap = initMap;
</script>

<style>
    #mapCanvas {
        width: 100%;
        height: 480px;
    }
</style>

<!-- Reach us -->
<h2 class="mt-5 pt-4 text-center fw-bold h1">Reach Us</h2>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
            <div id="mapCanvas"></div>
        </div>
        <div class="col-lg-4">
            <div class="bg-white p-4 rounded mb-4">
                <h5>Call us</h5>
                <a href="" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +88 0176655511</a> <br>
                <a href="" class="d-inline-block  text-decoration-none text-dark"><i class="bi bi-telephone-fill"></i> +88 0172314567</a>
            </div>
            <div class="bg-white p-4 rounded mb-4">
                <h5 class="pb-3">Follow us</h5>
                <a href="" class="d-inline-block mb-3 "><span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-twitter me-2"></i> Twitter</span></a> <br>
                <a href="" class="d-inline-block mb-3 "><span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-instagram"></i> Instagram</span></a> <br>
                <a href="" class="d-inline-block mb-3 "><span class="badge bg-light text-dark fs-6 p-2"><i class="bi bi-facebook"></i> Facebook</span></a> <br>
            </div>
        </div>
    </div>
</div>

<?php
include("includes/footer.php")
?>