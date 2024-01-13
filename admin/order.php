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
                        <a href="#" class="nav-link px-0 align-middle">
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
                                    <th width="3%" scope="col">No</th>
                                    <th width="8%" scope="col">Order's Name</th>
                                    <th width="8%" scope="col">Order's Contact Number</th>
                                    <th width="10%" scope="col">Hotel Name</th>
                                    <th width="8%" scope="col">Checkin Date</th>
                                    <th width="8%" scope="col">Checkout Date</th>
                                    <th width="8%" scope="col">Payment method</th>
                                    <th width="3%" scope="col"></th>
                                    <th width="3%" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $sql1 = "SELECT * FROM `booking_details`";
                                $res1 = mysqli_query($conn, $sql1);
                                $i = 1;
                                while ($row1 = mysqli_fetch_assoc($res1)) {
                                ?>
                                    <tr class="align-middle shadow">
                                        <td><a href="order-2.php?ord_id=<?php echo $row1['id']; ?>">
                                                <p class="btn btn-outline-secondary"><?php echo $i++; ?></p>
                                            </a></td>
                                            <?php 
                                                $sql2 = "SELECT * FROM `users` WHERE id = $row1[user_id]";
                                                $res2 = mysqli_query($conn, $sql2);
                                                $row2 = mysqli_fetch_assoc($res2);
                                            ?>
                                        <td class="fw-bold"><?php echo $row2['name']; ?></td>
                                        <td><?php echo $row1['user_contact']; ?></td>
                                        <?php 
                                                $sql3 = "SELECT * FROM `hotels` WHERE id = $row1[hotel_id]";
                                                $res3 = mysqli_query($conn, $sql3);
                                                $row3 = mysqli_fetch_assoc($res3);
                                            ?>
                                        <td><?php echo $row3['hotel_name']; ?></td>
                                        <td><?php echo $row1['check_in']; ?></td>
                                        <td><?php echo $row1['check_out']; ?></td>
                                        <td><?php echo $row1['payment_method']; ?></td>
                                        <td><a href="edit_order.php?edit=<?php echo $row1['id']; ?>" class="text-decoration-none text-white"><button class="btn btn-info">Edit</a></button></td>
                                        <td><a onclick="return confirm('Are you sure?')" href="order_crud.php?del=<?= $row1['id'] ?>" class="text-decoration-none text-white"><button class="btn btn-danger">Delete</a></button></td>
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