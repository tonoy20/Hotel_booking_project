<?php
include("../server.php");
session_start();
?>
<?php 
    $rating = '';
    if(isset($_POST['checkout'])) {
        $checkout_id = $_POST['checkout_id'];
        $rating = $_POST['rating'];
        $sql1 = "SELECT * FROM `booking_details` WHERE id = '$checkout_id'";
        $res1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($res1);

        if($rating != '') {
            $sql2 = "UPDATE `hotels` SET `rating`='$rating' WHERE id = '$row1[hotel_id]' ";
            mysqli_query($conn, $sql2);
        }

        if($row1['payment_method'] == 'paypal') {
            echo '<script>';
            echo 'alert("Complete your payment to checkout!");';
            echo 'window.location.href = "page-checkout.php";';
            echo '</script>';
            exit();
        }

        $checkOutTimestamp = strtotime($row1['check_out']);
        $current = time();

        $date = date("y-m-d");

        if($current < $checkOutTimestamp) {
            $sql3 = "UPDATE `booking_details` SET `check_out`='$date' WHERE id = '$checkout_id' ";
            mysqli_query($conn, $sql3);

            echo '<script>';
            echo 'alert("Checkout Complete!");';
            echo 'window.location.href = "page-checkout.php";';
            echo '</script>';
        }


    }
?>