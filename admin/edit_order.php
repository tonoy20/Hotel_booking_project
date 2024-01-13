<?php
include("sessionAd.php");
include("../server.php");
include("includes/header.php");
?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link align-middle px-0">
                            <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link align-middle px-0">
                            <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="order.php" class="nav-link px-0 align-middle">
                            <span class="ms-1 d-none d-sm-inline">Booking</span></a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        <div class="col py-3">
            <div class="container py-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center mb-5">Edit Booking Reservation</h2>
                        <div class="row bg-light">

                            <?php
                            $booking_id = '';
                            if (isset($_GET['edit'])) {
                                $booking_id = $_GET['edit'];
                            }

                            $sql1 = "SELECT * FROM `booking_details` WHERE id = '$booking_id' ";
                            $res1 = mysqli_query($conn, $sql1);
                            while ($row1 = mysqli_fetch_assoc($res1)) {
                            ?>
                                <div class="col-md-8 ps-5">
                                    <hr class="my-5">
                                    <!-- form complex example -->
                                    <form class="form" action="order_crud.php" method="POST">
                                        <div class="form-row mt-4">
                                            <?php 
                                                $sql2 = "SELECT * FROM `users` WHERE id = '$row1[user_id]'";
                                                $res2 = mysqli_query($conn, $sql2);
                                                $row2 = mysqli_fetch_assoc($res2);
                                            ?>

                                            <div class="col-sm-9 pb-3 ">
                                                <label for="exampleFirst">Name</label>
                                                <input type="text" class="form-control" name="user_name" value="<?php echo $row2['name']; ?>" disabled>
                                            </div>
                                            <div class="col-sm-9 pb-3">
                                                <label for="exampleFirst">Email address</label>
                                                <input type="email" class="form-control" name="user_email" value="<?php echo $row2['email']; ?>" disabled>
                                            </div>
                                            <div class="col-sm-6 pb-3">
                                                <label for="">Contact Number</label>
                                                <input type="text" class="form-control" value="<?php echo $row1['user_contact'] ?>" name="user_phone" disabled>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 pb-3">
                                                    <label for="">Check in Date</label>
                                                    <input type="date" class="form-control" value="<?php echo $row1['check_in']; ?>" name="checkinDate" required>
                                                </div>
                                                <div class="col-4 pb-3">
                                                    <label for="">Check out Date</label>
                                                    <input type="date" class="form-control" value="<?php echo $row1['check_out']; ?>" name="checkoutDate" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="">Room type</label>
                                                <input type="text" list="room_list" class="form-control" name="personRoom" value="<?php
                                                if($row1['reserve_room_type'] == 4) { echo "cottage"; } else if($row1['reserve_room_type'] == 1) { echo "single room"; } else if($row1['reserve_room_type'] == 2) { echo "double room"; } ?>" placeholder="Click here" required>
                                                <datalist id="room_list">
                                                    <option value="single room">Single Room</option>
                                                    <option value="double room">Double Room</option>
                                                    <option value="cottage">Cottage</option>
                                                </datalist>
                                            </div>
                                            <div class="col-sm-4 pb-3">
                                                <label for="">Number of Rooms</label>
                                                <input type="number" class="form-control" name="room_number" value="<?php echo $row1['reserve_room_number']; ?>" required>
                                            </div>
                                            <div class="col-md-9 pb-3">
                                                <label for="exampleMessage">Message</label>
                                                <textarea class="form-control" name="message"></textarea>
                                                <small class="text-info">
                                                    Add the packaging note here.
                                                </small>
                                            </div>
                                        </div>
                                        <input type="hidden" name="booking" value="<?php echo $booking_id; ?>">
                                        <div class="d-flex justify-content-center pt-5 pb-4">
                                            <input class="btn btn-outline-success w-25" type="submit" name="reserve_edit" value="Edit">
                                        </div>
                                    </form>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!--/row-->

                        <br><br><br><br>

                    </div>
                    <!--/col-->
                </div>
                <!--/row-->
                <hr>

            </div>
        </div>
    </div>
</div>