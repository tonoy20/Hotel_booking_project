<?php
include("../server.php");
include("includes/header.php");
?>


<div class="ps-5">
    <div class="row">

        <div class="col-lg-2">
            <h4 class="ms-5 pt-3">FILTERS</h4>
            <div class="container-fluid flex-lg-column align-items-stretch">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse flex-column" id="navbarNav">
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3">CHECK AVAILABILITY</h5>
                            <label for="form-label">Check-in</label>
                            <input type="date" name="checkinDate" id="" class="form-control shadow-none" value="<?php if(isset($_SESSION['checkinDate'])) echo $_SESSION['checkinDate']; ?>" disabled>
                            <label for="form-label">Check-out</label>
                            <input type="date" name="checkoutDate" id="" class="form-control shadow-none" value="<?php if(isset($_SESSION['checkoutDate'])) echo $_SESSION['checkoutDate']; ?>" disabled>
                            <?php
                            if (isset($_SESSION['numberOfDays'])) {
                                if ($_SESSION['numberOfDays'] == 0) {
                                    echo "<div class='text-center pt-3 fst-italic'>For a day</div>";
                                } else if ($_SESSION['numberOfDays'] == 1) {
                                    echo "<div class='text-center pt-3 fst-italic'>For " . $_SESSION['numberOfDays'] . " night </div>";
                                } else {
                                    echo "<div class='text-center pt-3 fst-italic'>For " . $_SESSION['numberOfDays'] . " nights </div>";
                                }
                            }
                            ?>
                        </div>
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3">Rooms</h5>
                            <div class="me-3">
                                <label for="form-label">room type</label>
                                <input type="text" name="" id="" class="form-control shadow-none" value="<?php if (isset($_SESSION['personRoom'])) {
                                                                                                                if ($_SESSION['personRoom'] == 1) echo "single room";
                                                                                                                else if ($_SESSION['personRoom'] == 2) echo "double room";
                                                                                                                else if ($_SESSION['personRoom'] == 4) echo "cottage";
                                                                                                            } ?>" disabled>
                            </div>
                            <div class="me-3">
                                <label for="form-label">room for reservation</label>
                                <input type="number" name="room_number" id="" class="form-control shadow-none" value="<?php if (isset($_SESSION['room_number'])) {
                                                                                                                            echo $_SESSION['room_number'];
                                                                                                                        } ?>" disabled>
                            </div>
                        </div>
                        <!-- <div class="border bg-light rounded">
                            <iframe class="w-100 rounded" src="https://www.google.com/maps/d/embed?mid=1Ud5DRnqhKifdeHQ0wjENsGgLp_0&hl=en_US&ehbc=2E312F" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div> -->
                    </div>
                </nav>
            </div>
        </div>

        <div class="col-lg-9 col-md-12 mb-lg-0 mb-4 pe-5">
            <?php
            $fetch_multiple = FETCH_MULTIPLE;
            $hotel_id = $_GET['h_id'];
            $sql1 = "SELECT * FROM hotels WHERE id = '$hotel_id'";
            $res1 = mysqli_query($conn, $sql1);
            while ($row1 = mysqli_fetch_assoc($res1)) {
            ?>
                <!--  -->
                <div class="gallery-container">
                    <h1 class="pt-5 ps-4"><?php echo $row1['hotel_name'] ?></h1>
                    <p class="page-description ps-4"><span class="pe-2"><a target="_blank" href="hotel_map.php?h_id=<?php echo $hotel_id; ?>"><i class="bi bi-geo-alt-fill text-primary"></i></a></span><?php echo $row1['hotel_address'] ?></p>

                    <div class="tz-gallery pt-3">
                        <div class="row">
                            <?php
                            $sql2 = "SELECT * FROM room_image WHERE hotel_id = '$row1[id]' LIMIT 1";
                            $res2 = mysqli_query($conn, $sql2);
                            while ($row2 = mysqli_fetch_assoc($res2)) {
                            ?>
                                <div class="col-sm-12 col-md-5">
                                    <img src="<?= $fetch_multiple . $row2['images'] ?>" class="w-100" alt="Bridge">
                                </div>
                            <?php
                            }
                            ?>
                            <div class="col-sm-6 col-md-3">
                                <?php
                                $sql3 = "SELECT * FROM room_image WHERE hotel_id = '$row1[id]' LIMIT 2 OFFSET 1";
                                $res3 = mysqli_query($conn, $sql3);
                                while ($row3 = mysqli_fetch_assoc($res3)) {
                                ?>
                                    <img src="<?= $fetch_multiple . $row3['images'] ?>" class="w-75 pb-1" alt="Park">
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="row pt-2">
                    <div class="card mb-3 col-2 me-1">
                        <div class="row g-0">
                            <div class="col-md-10">
                                <div class="card-body ">
                                    <p class="card-text ps-3"><span class="pe-4"><i class="bi bi-wifi"></i></span>Free Wifi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 col-2 me-1">
                        <div class="row g-0">
                            <div class="col-md-10">
                                <div class="card-body ">
                                    <p class="card-text ps-3"><span class="pe-4"><i class="bi bi-wifi"></i></span>Condition</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 col-2 me-1">
                        <div class="row g-0">
                            <div class="col-md-10">
                                <div class="card-body ">
                                    <p class="card-text ps-5"><span class="pe-4"><i class="bi bi-tv"></i></span>TV</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 col-2 me-1">
                        <div class="row g-0">
                            <div class="col-md-10">
                                <div class="card-body ">
                                    <p class="card-text ps-5"><span class="pe-4"><i class="bi bi-tv"></i></span>View</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card text-dark bg-light mb-3 col-8">
                    <div class="card-header">
                        <h5>Hotel Description</h5>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $row1['hotel_name'] ?></h3>
                        <p class="card-text fs-5 lh-lg"><?php echo $row1['hotel_description'] ?></p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="col-lg-1 Page-2_side">
            <div class="w-50 pb-4">
                <a href="page-book.php?h_id=<?php echo $hotel_id; ?>" class="btn btn-sm text-white w-100 shadow mb-3 bg-dark">Book Now</a>
            </div>
            <div class="bg-light p-5">
                <h4>Property Highlights</h4>
                <h6>Perfect for Stay!</h6>
                <div class="">
                    <div class="pt-3 pb-3"><i class="bi bi-compass pe-3"></i>Situated in the real heart of Kraków, this property has an excellent location score of 9.7
                    </div>
                    <div class="pb-3"><i class="bi bi-compass pe-3"></i>Want a great night's sleep? This property was highly rated for its very comfy beds.
                    </div>
                    <div class="pb-3"><i class="bi bi-compass pe-3"></i>Private parking available on-site
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");
?>