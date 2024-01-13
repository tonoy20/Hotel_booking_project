<?php
include("../server.php");
include("includes/header.php");
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
                            $sql = "SELECT * FROM `hotels` WHERE id = '$_SESSION[res_hotel_id]'";
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

                        </div>
                        <div class="border bg-light p-3 rounded mb-3">
                            <h5 class="mb-3">Rooms</h5>
                            <div class="me-3">
                                <label for="form-label">room type</label>
                                <input type="text" name="" id="" class="form-control shadow-none" value="<?php if (isset($_SESSION['personRoom'])) {
                                                                                                                echo $_SESSION['personRoom'];
                                                                                                            } ?>" disabled>
                            </div>
                            <div class="me-3">
                                <label for="form-label">room for reservation</label>
                                <input type="number" name="room_number" id="" class="form-control shadow-none" value="<?php if (isset($_SESSION['room_number'])) {
                                                                                                                            echo $_SESSION['room_number'];
                                                                                                                        } ?>" disabled>
                            </div>
                        </div>
                        <div class="border bg-light rounded">
                            <iframe class="w-100 rounded" src="https://www.google.com/maps/d/embed?mid=1Ud5DRnqhKifdeHQ0wjENsGgLp_0&hl=en_US&ehbc=2E312F" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="col-lg-9">
            <!--  -->
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-5">Payment Form</h2>
                        <div class="row bg-light">

                            <div class="col-md-10 offset-md-1 ps-5">
                                <hr class="my-5">
                                <!-- form complex example -->
                                <form class="form" action="page-book_func.php" method="POST">
                                    <div class="form-row mt-4">
                                        <div class="col-md-6 pb-3">
                                            <label for="exampleAccount">Payment Method</label>
                                            <div class="form-group small">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="paypal">Paypal
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="cash"> Cash
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 pb-3">
                                                <label for="">Total Payment</label>
                                                <div class="input-group input-medium pt-2">
                                                    <span class="input-group-btn h3 pe-2">TK - </span>
                                                    <input type="number" class="form-control" name="total_payment" value="<?php echo $_SESSION['total_payment']; ?>" disabled>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center pt-5 pb-4">
                                        <input class="btn btn-outline-success w-25" type="submit" name="order_submit" value="Order">
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