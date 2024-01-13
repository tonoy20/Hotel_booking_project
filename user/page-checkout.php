<?php
include("../server.php");
include("includes/header.php");
?>

<div class="px-5">
    <div class="px-5">
        <h1 class="text-center fw-bold py-5">MY CHECKOUT DETAILS</h1>
        <table class="table table-light shadow">
            <thead>
                <td>No</td>
                <td>Hotel Name</td>
                <td>Check In</td>
                <td>Check Out</td>
                <td>Payment Method</td>
                <td>Total amount</td>
                <td>Paid/Unpaid</td>
                <td>Give Rating</td>
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
                        <td><?php echo $row1['payment_method']; ?></td>
                        <td>৳ <?php echo $row1['payment_total']; ?></td>
                        <td><?php if ($row1['payment_method'] == 'cash') {
                                echo "PAID";
                            } else if ($row1['payment_method'] == 'paypal') {
                                echo "UNPAID";
                            } ?></td>
                        <td>

                            <form action="userCheckout_func.php" method="POST">
                                <?php 
                                    $checkInTimestamp = strtotime($row1['check_in']);
                                    $checkOutTimestamp = strtotime($row1['check_out']);
                                    $current = time();
                                    if ($current > $checkInTimestamp && $current < $checkOutTimestamp) {
                                ?>
                                <select class="form-select" name="rating" aria-label="Default select example">
                                    <option selected disabled>Give Rating</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <?php } ?>
                                <input type="hidden" name="checkout_id" value="<?php echo $row1['id']; ?>">
                        </td>
                        <td><?php
                            if ($current > $checkInTimestamp && $current < $checkOutTimestamp) {
                            ?><a onclick="return confirm('Are you sure to checkout?')"><input type="submit" name="checkout" value="Checkout" class="btn btn-danger"></a></td> <?php } ?>
                    </form>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include("includes/footer.php");
?>