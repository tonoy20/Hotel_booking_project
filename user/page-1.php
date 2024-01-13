<?php
include("../server.php");
include("includes/header.php");
?>

<?php
function validateReservation($checkInDate, $checkOutDate)
{
    // Convert date strings to timestamps
    $checkInTimestamp = strtotime($checkInDate);
    $checkOutTimestamp = strtotime($checkOutDate);

    // Compare timestamps
    if ($checkInTimestamp > $checkOutTimestamp) {
        echo '<script>';
        echo 'alert("checkout date is before the check in date!!");';
        echo 'window.location.href = "index.php";';
        echo '</script>';
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $checkInDate = $_POST["checkinDate"];
    $checkOutDate = $_POST["checkoutDate"];
    validateReservation($checkInDate, $checkOutDate);
}
?>


<div class="bg-dark bg-gradient">
    <div class="head_form d-flex justify-content-center p-5">
        <form class="form" action="" method="POST">
            <input type="text" list="mylist" name="cityname" value="<?php if (isset($_POST['cityname'])) echo $_POST['cityname'] ?>" placeholder="Where would you like to go?">
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
            <input type="date" name="checkinDate" class="date" value="<?php if (isset($_POST['checkinDate'])) echo $_POST['checkinDate']; ?>">
            <label for="" class="pe-2 dateTO">TO</label>
            <input type="date" name="checkoutDate" class="date" value="<?php if (isset($_POST['checkoutDate'])) echo $_POST['checkoutDate']; ?>">
            <input type="text" class="date" list="room_list" name="personRoom" value="<?php if (isset($_POST['personRoom'])) echo $_POST['personRoom']; ?>" placeholder="Room type" required>
            <datalist id="room_list">
                <option value="single room">Single Room</option>
                <option value="double room">Double Room</option>
                <option value="cottage">Cottage</option>
            </datalist>
            <input type="number" class="date" name="room_number" value="<?php if (isset($_POST['room_number'])) echo $_POST['room_number']; ?>" placeholder="Quantity?" required>
            <input type="submit" name="submit" class="book" value="Search">
        </form>
    </div>
</div>


<div class="ps-5">
    <div class="row">
        <div class="col-lg-3">
            <h4 class="ms-5 pt-3">FILTERS</h4>
            <div class="container-fluid flex-lg-column align-items-stretch">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column" id="navbarNav">
                        <div class="border bg-light p-4 rounded mb-3 w-100">
                            <h5 class="mb-4 text-center">Your bughet (Per night)</h5>
                            <div id="slider"></div>
                            <div id="slider-values">Range: <span id="min-value"><?php if (isset($_SESSION['minValue'])) {
                                                                                    echo $_SESSION['minValue'];
                                                                                } else {
                                                                                    echo '10000';
                                                                                }  ?></span>TK - <span id="max-value"><?php if (isset($_SESSION['specificValue'])) {
                                                                                                                            echo $_SESSION['specificValue'];
                                                                                                                        } else {
                                                                                                                            echo '20000';
                                                                                                                        }  ?></span>TK</div>
                            <br>
                            <div class="d-flex justify-content-center">
                                <button id="send-values" class="btn btn-outline-dark">Search</button>
                            </div>
                            
                        </div>
                        <script>
                            $(function() {
                                var minValueLabel = $("#min-value");
                                var maxValueLabel = $("#max-value");
                                $("#slider").slider({
                                    range: true,
                                    min: 5000,
                                    max: 30000,
                                    values: [<?php if (isset($_SESSION['minValue'])) {
                                                    echo $_SESSION['minValue'];
                                                } else {
                                                    echo '10000';
                                                }  ?>, <?php if (isset($_SESSION['specificValue'])) {
                                                            echo $_SESSION['specificValue'];
                                                        } else {
                                                            echo '20000';
                                                        }  ?>],
                                    slide: function(event, ui) {
                                        minValueLabel.text(ui.values[0]);
                                        maxValueLabel.text(ui.values[1]);

                                        console.log(ui.values[0], ui.values[1]);
                                    }
                                });

                                $("#send-values").on("click", function() {
                                    var minValue = $("#slider").slider("values", 0);
                                    var maxValue = $("#slider").slider("values", 1);

                                    // Send values to PHP using AJAX
                                    $.ajax({
                                        url: 'range-filter.php',
                                        method: 'POST',
                                        dataType: 'json',
                                        data: {
                                            min: minValue,
                                            max: maxValue
                                        },
                                        success: function(response) {
                                            var specificValue = response.specificValue;
                                            console.log(specificValue);

                                            setTimeout(function() {
                                                location.reload();
                                            }, 10);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(xhr.responseText);
                                        }
                                    });
                                });
                            });
                        </script>

                        <!-- Google Map -->
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
                                $city_name = '';
                                if (isset($_POST['submit'])) {
                                    $city_name = addslashes($_POST['cityname']);
                                }
                                $sql1 = "SELECT id FROM `city` WHERE city_name = '$city_name' ";
                                $res1 = mysqli_query($conn, $sql1);
                                $city_id = '';
                                while ($row1 = mysqli_fetch_assoc($res1)) {
                                    $city_id = $row1['id'];
                                }

                                $locations=array();
                                $sql2 = "SELECT * FROM `hotels` WHERE city_id = '$city_id' ";
                                $res2 = mysqli_query($conn, $sql2);
                                while ($row2 = mysqli_fetch_assoc($res2)) {
                                    $locations[]=array( 'name'=>$row2['hotel_name'], 'lat'=>$row2['latitude'], 'lng'=>$row2['longitude'] );
                                }
                                for($i=0;$i<sizeof($locations);$i++) {
                                ?>
                                    // Multiple markers location, latitude, and longitude
                                    markers.push (
                                        ['<?php echo $locations[$i]['name']; ?>', <?php echo $locations[$i]['lat']; ?>, <?php echo $locations[$i]['lng']; ?>],
                                    );

                                    infoWindowContent.push (
                                    ['<div class="info_content">' +
                                        '<h6><?php echo $locations[$i]['name']; ?></h6>' +
                                        '<p><?php echo $city_name; ?>, Bangladesh-1219</p>' +
                                        '</div>'
                                    ],
                                );

                                <?php
                                }
                                ?>
                                // Info window content
                                // var infoWindowContent = [
                                //     ['<div class="info_content">' +
                                //         '<h6></h6>' +
                                //         '<p>, Bangladesh</p>' +
                                //         '</div>'
                                //     ],
                                //     ['<div class="info_content">' +
                                //         '<h6></h6>' +
                                //         '<p>, Bangladesh 1229</p>' +
                                //         '</div>'
                                //     ],
                                // ];

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
                                    this.setZoom(10);
                                    google.maps.event.removeListener(boundsListener);
                                });
                            }

                            window.initMap = initMap;
                        </script>


                        <style>
                            #mapCanvas {
                                width: 400px;
                                height: 300px;
                            }
                        </style>

                        <div class="border bg-light rounded">
                            <div id="mapCanvas"></div>
                        </div>

                        <div class="p-2"></div>

                        <div class="border bg-light p-3 rounded mb-3 w-100">
                            <h5 class="mb-3 text-center">CHECK AVAILABILITY</h5>
                            <label for="form-label">Check-in</label>
                            <input type="date" name="" id="" class="form-control shadow-none" value="<?php if (isset($_POST['checkinDate'])) echo $_POST['checkinDate']; ?>" disabled>
                            <label for="form-label">Check-out</label>
                            <input type="date" name="" id="" class="form-control shadow-none" value="<?php if (isset($_POST['checkoutDate'])) echo $_POST['checkoutDate']; ?>" disabled>
                            <?php
                            // Replace these variables with your actual check-in and check-out dates
                            $checkinDate = $_POST['checkinDate'];
                            $checkoutDate = $_POST['checkoutDate'];

                            // Create DateTime objects for check-in and check-out dates
                            $checkin = new DateTime($checkinDate);
                            $checkout = new DateTime($checkoutDate);

                            // Calculate the difference between the two dates
                            $interval = $checkin->diff($checkout);

                            // Get the total number of days
                            $numberOfDays = $interval->days;

                            // Output the result
                            if ($numberOfDays == 0) {
                                echo "<div class='text-center pt-3 fst-italic'>For a day</div>";
                            } else if ($numberOfDays == 1) {
                                echo "<div class='text-center pt-3 fst-italic'>For " . $numberOfDays . " night </div>";
                            } else {
                                echo "<div class='text-center pt-3 fst-italic'>For " . $numberOfDays . " nights </div>";
                            }

                            $_SESSION['checkinDate'] = $_POST['checkinDate'];
                            $_SESSION['checkoutDate'] = $_POST['checkoutDate'];

                            if(isset($_POST['room_number'])) {
                            $_SESSION['room_number'] = $_POST['room_number'];
                            } 
                            $_SESSION['numberOfDays'] = $numberOfDays;

                            if (isset($_POST['personRoom'])) {
                                if ($_POST['personRoom'] == 'single room') {
                                    $_SESSION['personRoom'] = 1;
                                } else if ($_POST['personRoom'] == 'double room') {
                                    $_SESSION['personRoom'] = 2;
                                } else if ($_POST['personRoom'] == 'cottage') {
                                    $_SESSION['personRoom'] = 4;
                                }
                            }
                            ?>
                        </div>

                        <div class="border bg-light p-3 rounded mb-3 w-100">
                            <h4 class="mb-3 text-center">Rooms</h4>
                            <div class="me-3">
                                <label for="form-label">room type</label>
                                <input type="text" name="" id="" class="form-control shadow-none" value="<?php if (isset($_POST['personRoom'])) echo $_POST['personRoom']; ?>" disabled>
                            </div>
                            <div class="me-3">
                                <label for="form-label">room for reservation</label>
                                <input type="number" name="" id="" class="form-control shadow-none" value="<?php if (isset($_POST['room_number'])) echo $_POST['room_number']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <?php
        function isWithinDateRange($inputCheckin, $inputCheckout, $checkinDate, $checkoutDate)
        {
            $inputDateTime = new DateTime($inputCheckin);
            $inputDateTime2 = new DateTime($inputCheckout);
            $checkinDateTime = new DateTime($checkinDate);
            $checkoutDateTime = new DateTime($checkoutDate);

            return (($checkinDateTime <= $inputDateTime && $inputDateTime <= $checkoutDateTime) || ($checkinDateTime <= $inputDateTime2 && $inputDateTime2 <= $checkoutDateTime) || ($checkinDateTime > $inputDateTime && $inputDateTime2 > $checkoutDateTime));
        }

        // input checkin date & check out Date
        $inputCheckin = $_POST['checkinDate'];
        $inputCheckout = $_POST['checkoutDate'];
        ?>
        <div class="col-lg-8 col-md-12 mb-lg-0 mb-4 pe-5">
            <?php
            $fetch_src = FETCH_SRC;
            $city_name = '';
            if (isset($_POST['submit'])) {
                $city_name = addslashes($_POST['cityname']);
            }
            if ($city_name == '') {
                echo "<h1 class='text-center fw-bold mt-5'>Please select a place to find awesome hotels to stay!!</h1>";
            }
            $sql1 = "SELECT id FROM `city` WHERE city_name = '$city_name' ";
            $res1 = mysqli_query($conn, $sql1);
            $city_id = '';
            while ($row1 = mysqli_fetch_assoc($res1)) {
                $city_id = $row1['id'];
            }

            $h_id = "";
            $sql2 = "SELECT * FROM `hotels` WHERE city_id = '$city_id' ";
            $res2 = mysqli_query($conn, $sql2);
            while ($row2 = mysqli_fetch_assoc($res2)) {
                $h_id = $row2['id'];

                if (isset($_SESSION['specificValue'])) {
                    $max_val = $_SESSION['specificValue'];
                    $sql7 = "SELECT * FROM `rooms` WHERE hotel_id = '$row2[id]'";
                    $res7 = mysqli_query($conn, $sql7);
                    while ($row7 = mysqli_fetch_assoc($res7)) {
                        if ($row7['room_price'] <= $max_val) {
            ?>
                            <div class="card mb-4 mt-5 border-0 shadow">
                                <div class="row g-0 p-3 align-items-center">
                                    <div class="col-md-4">
                                        <?php
                                        $sql5 = "SELECT * FROM `hotel_image` WHERE hotel_id = '$row2[id]'";
                                        $res5 = mysqli_query($conn, $sql5);
                                        $img_lc = '';
                                        while ($row5 = mysqli_fetch_assoc($res5)) {
                                            $img_lc = $row5['image'];
                                        }
                                        ?>
                                        <img src="<?= $fetch_src . $img_lc ?>" class="img-fluid rounded-start w-75" alt="">

                                        <a href="cart_func.php?h_id=<?php echo $h_id; ?>"><i class="bi bi-heart btn btn-outline-danger wishlistIcon"></i> </a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h3 class="card-title text-info"><?php echo $row2['hotel_name'] ?></h3>
                                            <p class="card-text text-success">Available Rooms - <br>
                                                <?php
                                                $room_price = '';
                                                $sql3 = "SELECT * FROM rooms WHERE hotel_id = '$row2[id]'";
                                                $res3 = mysqli_query($conn, $sql3);
                                                while ($row3 = mysqli_fetch_assoc($res3)) {
                                                    $room_price = $row3['room_price'];
                                                    $sql4 = "SELECT * FROM room_types WHERE id = '$row3[room_types_id]'";
                                                    $res4 = mysqli_query($conn, $sql4);

                                                    while ($row4 = mysqli_fetch_assoc($res4)) {
                                                        $single_room = $row4['available_single'];
                                                        $double_room = $row4['available_double'];
                                                        $cottage = $row4['available_cottage'];

                                                        $sql6 = "SELECT * FROM `booking_details` WHERE hotel_id = '$h_id'";
                                                        $res6 = mysqli_query($conn, $sql6);

                                                        while ($row6 = mysqli_fetch_assoc($res6)) {
                                                            if (isWithinDateRange($inputCheckin, $inputCheckout, $row6['check_in'], $row6['check_out'])) {
                                                                if ($row6['reserve_room_type'] == 1) {
                                                                    $single_room = $single_room - $row6['reserve_room_number'];
                                                                } else if ($row6['reserve_room_type'] == 2) {
                                                                    $double_room = $double_room - $row6['reserve_room_number'];
                                                                } else if ($row6['reserve_room_type'] == 4) {
                                                                    $cottage = $cottage - $row6['reserve_room_number'];
                                                                }
                                                            }
                                                        }
                                                ?>
                                                        Single Room : <?php echo $single_room; ?> <br>
                                                        Double Room : <?php echo $double_room; ?> <br>
                                                        Cottage : <?php echo $cottage; ?>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </p>
                                            <p class="text-muted">Rating : <span class="ps-2">
                                                    <?php
                                                    for ($x = 0; $x < $row2['rating']; $x++) {
                                                    ?>
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    <?php
                                                    }
                                                    ?>
                                                </span></p>
                                            <p class="text-dark">Contact Number : <?php echo $row2['contact_number'] ?> </p>
                                            <p class="card-text"><small class="text-muted"><?php echo $row2['hotel_address'] ?></small></p>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-align-center">
                                        <h5 class="mb-4">TK <?php
                                                            $room_type = 1;
                                                            $r_number = 1;
                                                            if (isset($_SESSION['personRoom'])) {
                                                                if ($_SESSION['personRoom'] > 0) {
                                                                    $room_type = $_SESSION['personRoom'];
                                                                }
                                                            }
                                                            if(isset($_POST['room_number'])) {
                                                                if ($_POST['room_number'] > 0) {
                                                                    $r_number = $_POST['room_number'];
                                                                }
                                                            }
                                                            if ($numberOfDays == 0) {
                                                                echo $room_price * $room_type * $r_number;
                                                            } else {
                                                                echo $room_price * $room_type * $numberOfDays * $r_number;
                                                            } ?>/=</h5>
                                        <a href="page-book.php?h_id=<?php echo $h_id; ?>" class="btn btn-sm text-white w-100 shadow mb-3 bg-dark">Book Now</a>
                                        <a href="page-2.php?h_id=<?php echo $h_id; ?>" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                } else {
                    ?>
                    <div class="card mb-4 mt-5 border-0 shadow">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-4">
                                <?php
                                $sql5 = "SELECT * FROM `hotel_image` WHERE hotel_id = '$row2[id]'";
                                $res5 = mysqli_query($conn, $sql5);
                                $img_lc = '';
                                while ($row5 = mysqli_fetch_assoc($res5)) {
                                    $img_lc = $row5['image'];
                                }
                                ?>
                                <img src="<?= $fetch_src . $img_lc ?>" class="img-fluid rounded-start w-75" alt="">

                                <a href="cart_func.php?h_id=<?php echo $h_id; ?>"><i class="bi bi-heart btn btn-outline-danger wishlistIcon"></i> </a>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <h3 class="card-title text-info"><?php echo $row2['hotel_name'] ?></h3>
                                    <p class="card-text text-success">Available Rooms - <br>
                                        <?php
                                        $room_price = '';
                                        $sql3 = "SELECT * FROM rooms WHERE hotel_id = '$row2[id]'";
                                        $res3 = mysqli_query($conn, $sql3);
                                        while ($row3 = mysqli_fetch_assoc($res3)) {
                                            $room_price = $row3['room_price'];
                                            $sql4 = "SELECT * FROM room_types WHERE id = '$row3[room_types_id]'";
                                            $res4 = mysqli_query($conn, $sql4);

                                            while ($row4 = mysqli_fetch_assoc($res4)) {
                                                $single_room = $row4['available_single'];
                                                $double_room = $row4['available_double'];
                                                $cottage = $row4['available_cottage'];

                                                $sql6 = "SELECT * FROM `booking_details` WHERE hotel_id = '$h_id'";
                                                $res6 = mysqli_query($conn, $sql6);

                                                while ($row6 = mysqli_fetch_assoc($res6)) {
                                                    if (isWithinDateRange($inputCheckin, $inputCheckout, $row6['check_in'], $row6['check_out'])) {
                                                        if ($row6['reserve_room_type'] == 1) {
                                                            $single_room = $single_room - $row6['reserve_room_number'];
                                                        } else if ($row6['reserve_room_type'] == 2) {
                                                            $double_room = $double_room - $row6['reserve_room_number'];
                                                        } else if ($row6['reserve_room_type'] == 4) {
                                                            $cottage = $cottage - $row6['reserve_room_number'];
                                                        }
                                                    }
                                                }
                                        ?>
                                                Single Room : <?php echo $single_room; ?> <br>
                                                Double Room : <?php echo $double_room; ?> <br>
                                                Cottage : <?php echo $cottage; ?>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </p>
                                    <p class="text-muted">Rating : <span class="ps-2">
                                            <?php
                                            for ($x = 0; $x < $row2['rating']; $x++) {
                                            ?>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            <?php
                                            }
                                            ?>
                                        </span></p>
                                    <p class="text-dark">Contact Number : <?php echo $row2['contact_number'] ?> </p>
                                    <p class="card-text"><small class="text-muted"><?php echo $row2['hotel_address'] ?></small></p>
                                </div>
                            </div>
                            <div class="col-md-1 text-align-center">
                                <h5 class="mb-4">TK <?php
                                                    $room_type = 1;
                                                    $r_number = 1;
                                                    if (isset($_SESSION['personRoom'])) {
                                                        if ($_SESSION['personRoom'] > 0) {
                                                            $room_type = $_SESSION['personRoom'];
                                                        }
                                                    }
                                                    if(isset($_POST['room_number'])) {
                                                        if ($_POST['room_number'] > 0) {
                                                            $r_number = $_POST['room_number'];
                                                        }
                                                    }
                                                    if ($numberOfDays == 0) {
                                                        echo $room_price * $room_type * $r_number;
                                                    } else {
                                                        echo $room_price * $room_type * $numberOfDays * $r_number;
                                                    } ?>/=</h5>
                                <a href="page-book.php?h_id=<?php echo $h_id; ?>" class="btn btn-sm text-white w-100 shadow mb-3 bg-dark">Book Now</a>
                                <a href="page-2.php?h_id=<?php echo $h_id; ?>" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php 
    if(isset($_POST['guest'])) {
        $_SESSION['guest'] = $_POST['guest'];
    }
    if(isset($_POST['child'])) {
        $_SESSION['children'] = $_POST['child'];
    }
?>

<?php
include("includes/footer.php");
?>