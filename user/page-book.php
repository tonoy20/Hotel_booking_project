<?php
include("../server.php");
include("includes/header.php");
?>
<?php
$username = "";
if (isset($_SESSION['uname'])) {
    $username = $_SESSION['uname'];
}

$sql = "SELECT * FROM users WHERE name = '$username'";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) < 1) {
    header("location: ../index.php");
}


$useremail = '';
while ($row = mysqli_fetch_assoc($res)) {
    $_SESSION['res_user_id'] = $row['id'];
    $useremail = $row['email'];
}


?>

<div class="">
    <div class="row">
        <div class="col-lg-2">
            <h4 class="ms-5 pt-5">Reservation</h4>
            <div class="container-fluid flex-lg-column align-items-stretch">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="collapse navbar-collapse flex-column" id="navbarNav">
                        <div class="border bg-light p-4 rounded mb-3">
                            <?php
                            $hotel_id = "";
                            if (isset($_GET['h_id'])) {
                                $hotel_id = $_GET['h_id'];
                            }
                            $_SESSION['res_hotel_id'] = $hotel_id;
                            $sql = "SELECT * FROM `hotels` WHERE id = '$hotel_id'";
                            $res = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($res)) {
                            ?>
                                <h6 class="mb-3 fw-bold"><?php echo $row['hotel_name'] ?></h6>
                                <p><?php echo $row['hotel_address']; ?></p>
                                <p><i class="bi bi-geo-alt-fill pe-2"></i> Excellent location</p>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="border bg-light p-4 rounded mb-3">
                            <h5>Your Booking Details</h5>
                            <label for="form-label">Check-in</label>
                            <input type="date" name="checkinDate" id="" class="form-control shadow-none" value="<?php if (isset($_SESSION['checkinDate'])) echo $_SESSION['checkinDate']; ?>" disabled>
                            <label for="form-label">Check-out</label>
                            <input type="date" name="checkoutDate" id="" class="form-control shadow-none" value="<?php if (isset($_SESSION['checkoutDate'])) echo $_SESSION['checkoutDate']; ?>" disabled>
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
        <div class="col-lg-9">
            <!--  -->
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-5">Hotel Reservation Form</h2>
                        <div class="row bg-light">

                            <div class="col-md-10 offset-md-1 ps-5">
                                <hr class="my-5">
                                <!-- form complex example -->
                                <form class="form" action="page-book_func.php" method="POST">
                                    <div class="form-row mt-4">
                                        <div class="col-sm-6 pb-3 ">
                                            <label for="exampleFirst">Name</label>
                                            <input type="text" class="form-control" name="user_name" value="<?php echo $username; ?>" required>
                                        </div>
                                        <div class="col-sm-6 pb-3">
                                            <label for="exampleFirst">Email address</label>
                                            <input type="email" class="form-control" name="user_email" value="<?php echo $useremail; ?>" required>
                                        </div>
                                        <div class="col-sm-3 pb-3">
                                            <label for="">Contact Number</label>
                                            <input type="text" class="form-control" name="user_phone" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-3 pb-3">
                                                <label for="">Check in Date</label>
                                                <input type="date" class="form-control" value="<?php if (isset($_SESSION['checkinDate'])) echo $_SESSION['checkinDate']; ?>" name="checkinDate" required>
                                            </div>
                                            <div class="col-3 pb-3">
                                                <label for="">Check out Date</label>
                                                <input type="date" class="form-control" value="<?php if (isset($_SESSION['checkoutDate'])) echo $_SESSION['checkoutDate'];  ?>" name="checkoutDate" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 pb-3">
                                            <label for="">Room type</label>
                                            <input type="text" list="room_list" class="form-control" name="personRoom" value="<?php if (isset($_SESSION['personRoom'])) {
                                                                                                                                    if ($_SESSION['personRoom'] == 4) {
                                                                                                                                        echo "cottage";
                                                                                                                                    } else if ($_SESSION['personRoom'] == 1) {
                                                                                                                                        echo "single room";
                                                                                                                                    } else if ($_SESSION['personRoom'] == 2) {
                                                                                                                                        echo "double room";
                                                                                                                                    }
                                                                                                                                }  ?>" placeholder="Click here" required>
                                            <datalist id="room_list">
                                                <option value="single room">Single Room</option>
                                                <option value="double room">Double Room</option>
                                                <option value="cottage">Cottage</option>
                                            </datalist>
                                        </div>
                                        <div class="col-sm-3 pb-3">
                                            <label for="">Number of Rooms</label>
                                            <input type="number" class="form-control" name="room_number" value="<?php if (isset($_SESSION['room_number'])) echo $_SESSION['room_number']; ?>" required>
                                        </div>
                                        <div class="row">
                                            <label for="" class="pb-3 h5">One room is available for Two adults or three children. <br> If more then the price will be increased :-</label>
                                            <div class="col-sm-3 pb-3">
                                                <label for="">Adult</label>
                                                <input type="number" class="form-control" name="adult_number" value="<?php if(isset($_SESSION['guest'])) echo $_SESSION['guest']; ?>" required>
                                            </div>
                                            <div class="col-sm-3 pb-3">
                                                <label for="">child</label>
                                                <input type="number" class="form-control" name="child_number" value="<?php if(isset($_SESSION['children'])) echo $_SESSION['children']; ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6 pb-3">
                                            <label for="exampleMessage">Message</label>
                                            <textarea class="form-control" name="message"></textarea>
                                            <small class="text-info">
                                                Add the packaging note here.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center pt-5 pb-4">
                                        <input class="btn btn-outline-success w-25" type="submit" name="reserve_submit" value="Book">
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!--/row-->

                        <br><br><br><br>

                    </div>
                    <!--/col-->
                </div>
                <!--/row-->
                <hr>

            </div>
            <!--/container-->
            <!--  -->
        </div>
    </div>
</div>



<?php
include("includes/footer.php");
?>