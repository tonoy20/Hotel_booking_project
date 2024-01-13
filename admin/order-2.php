<?php
include("sessionAd.php");
include("../server.php");
include("includes/header.php");
?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="dashboard.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link align-middle px-0">
                            <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link align-middle px-0">
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
            <main role="main">
                <div class="container-sm pt-2" style="text-align:center">
                    <h1 class="fw-bold">Booking Table</h1>
                </div>
                <div class="mt-5">
                    <div class="">
                        <table class="fi-table">
                            <thead class="bg-dark text-white">
                                <tr class="text-center shadow">
                                    <th width="3%" scope="col"></th>
                                    <th width="8%" scope="col">Hotel name</th>
                                    <th width="8%" scope="col">Hotel Contact Number</th>
                                    <th width="8%" scope="col">Room Type</th>
                                    <th width="8%" scope="col">Quantity</th>
                                    <th width="8%" scope="col">Total Amount</th>
                                    <th width="3%" scope="col"></th>
                                    <th width="3%" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $order_id = $_GET['ord_id'];
                                $sql1 = "SELECT * FROM `booking_details` WHERE id = '$order_id' ";
                                $res1 = mysqli_query($conn, $sql1);
                                while ($row1 = mysqli_fetch_assoc($res1)) {
                                ?>
                                    <tr class="align-middle shadow">
                                        <td></td>
                                        <?php 
                                            $sql2 = "SELECT * FROM `hotels` WHERE id = '$row1[hotel_id]'";
                                            $res2 = mysqli_query($conn, $sql2);
                                            $row2 = mysqli_fetch_assoc($res2);
                                        ?>
                                        <td><?php echo $row2['hotel_name']; ?></td>
                                        <td><?php echo $row2['contact_number']; ?></td>
                                        <td><?php if($row1['reserve_room_type'] == 1) echo "Single Room"; else if($row1['reserve_room_type'] == 2) echo "Double Room"; else if($row1['reserve_room_type'] == 4) echo "Cottage" ?></td>
                                        <td><?php echo $row1['reserve_room_number']; ?></td>
                                        <td><?php echo $row1['payment_total']; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>