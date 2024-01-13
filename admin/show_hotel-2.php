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
                        <a href="#" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Booking</span></a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        <div class="col py-3">
            <main role="main">
                <div class="container-sm pt-2" style="text-align:right">
                    <a class="btn btn-success ps-5 pe-5 pt-2 pb-2" href="add_hotel.php">Add hotel</a>
                </div>
                <div class="mt-5">
                    <div class="">
                        <table class="fi-table">
                            <thead class="bg-dark text-white">
                                <tr class="text-center shadow">
                                    <th width="2%" scope="col">No</th>
                                    <th width="25%" scope="col">Hotel Name</th>
                                    <th width="15%" scope="col">Single Room</th>
                                    <th width="15%" scope="col">Double Room</th>
                                    <th width="15%" scope="col">Cottage</th>
                                    <th width="20%" scope="col">Per Room Cost</th>
                                    <th width="45%" scope="col">Room Images</th>
                                    <th width="45%" scope="col"></th>
                                    <th width="45%" scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $h_id = $_GET['h_id'];
                                $sql = "SELECT * FROM `hotels` WHERE id = '$h_id'";
                                $res = mysqli_query($conn, $sql);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $sql2 = "SELECT * FROM `city` WHERE id = '$row[city_id]'";
                                    $res2 = mysqli_query($conn, $sql2);
                                    $city_name = "";
                                    while ($row2 = mysqli_fetch_assoc($res2)) {
                                        $city_name = $row2['city_name'];
                                    }
                                ?>
                                    <tr class="align-middle shadow">
                                        <td><?php echo $i++; ?></td>
                                        <td class="fw-bold"><?php echo $row['hotel_name']; ?></td>
                                        <?php
                                        $sql3 = "SELECT * FROM `rooms` WHERE hotel_id = '$row[id]'";
                                        $res3 = mysqli_query($conn, $sql3);
                                        while ($row3 = mysqli_fetch_assoc($res3)) {
                                            $sql4 = "SELECT * FROM `room_types` WHERE id = '$row3[room_types_id]'";
                                            $res4 = mysqli_query($conn, $sql4);
                                            while ($row4 = mysqli_fetch_assoc($res4)) {
                                        ?>
                                                <td><?php echo $row4['single_room']; ?></td>
                                                <td><?php echo $row4['double_room']; ?></td>
                                                <td><?php echo $row4['cottage']; ?></td>
                                            <?php
                                            }
                                            ?>
                                            <td><?php echo $row3['room_price']; ?></td>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        $fetch_multiple = FETCH_MULTIPLE;
                                        $sql5 = "SELECT * FROM `room_image` WHERE `hotel_id` = '$row[id]'";
                                        $res5 = mysqli_query($conn, $sql5);
                                        while ($row5 = mysqli_fetch_assoc($res5)) {
                                        ?>
                                            <td><img src=<?= $fetch_multiple.$row5['images']; ?> width="150px"></td>
                                        <?php
                                        }
                                        ?>
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