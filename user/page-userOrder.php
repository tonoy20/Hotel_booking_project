<?php
include("../server.php");
include("includes/header.php");
?>

<div class="px-5">
    <div class="px-5">
        <h1 class="text-center fw-bold py-5">MY BOOKING DETAILS</h1>
        <table class="table table-dark">
            <thead>
                <td>NO</td>
                <td>Hotel Name</td>
                <td>Check In</td>
                <td>Check Out</td>
                <td>Room Type</td>
                <td>Number of Rooms</td>
                <td>Payment Method</td>
                <td>Total amount</td>
                <td>Paid/Unpaid</td>
                <td></td>
            </thead>
            <tbody>
                <?php
                $user_id = $_SESSION['uid'];
                $sql1 = "SELECT * FROM `booking_details` WHERE user_id = '$user_id' ";
                $res1 = mysqli_query($conn, $sql1);
                $i = 1;
                while ($row1 = mysqli_fetch_assoc($res1)) {
                ?>
                    <tr class="table-active">
                        <td class="ps-3"><?php echo $i++; ?></td>
                        <?php
                        $sql2 = "SELECT * FROM `hotels` WHERE id = '$row1[hotel_id]' ";
                        $res2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($res2);
                        ?>
                        <td><?php echo $row2['hotel_name']; ?></td>
                        <td><?php echo $row1['check_in']; ?></td>
                        <td><?php echo $row1['check_out']; ?></td>
                        <td><?php if ($row1['reserve_room_type'] == 4) {
                                echo "cottage";
                            } else if ($row1['reserve_room_type'] == 1) {
                                echo "single room";
                            } else if ($row1['reserve_room_type'] == 2) {
                                echo "double room";
                            } ?></td>
                        <td><?php echo $row1['reserve_room_number']; ?></td>
                        <td><?php echo $row1['payment_method']; ?></td>
                        <td>৳ <?php echo $row1['payment_total']; ?></td>
                        <td><?php if ($row1['payment_method'] == 'cash') {
                                echo "PAID";
                            } else if ($row1['payment_method'] == 'paypal') {
                                echo "UNPAID";
                            } ?></td>
                        <td><?php
                            $checkInTimestamp = strtotime($row1['check_in']);
                            $current = time();
                            if ($current < $checkInTimestamp) {
                            ?><a onclick="return confirm('Are you sure to cancel?')" href="userOrder_func.php?del=<?php echo $row1['id']; ?>" class="btn btn-outline-danger">cancel</a></td> <?php } ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include("includes/footer.php")
?>