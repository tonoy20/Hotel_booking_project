<?php
include("../server.php");
session_start();
?>

<?php 
    $booking_id = "";
    $user_name= "";
    $user_email = "";
    $user_phone = "";
    $checkinDate = "";
    $checkoutDate = "";
    $room_type = "";
    $room_number= "";
    $guest = "";
    $children = "";
    $user_id = $_SESSION['res_user_id'];
    $hotel_id = $_SESSION['res_hotel_id'];
    if(isset($_POST['reserve_submit'])) {
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_phone = $_POST['user_phone'];
        $checkinDate = $_POST['checkinDate'];
        $checkoutDate = $_POST['checkoutDate'];
        $guest = $_POST['adult_number'];
        $children = $_POST['child_number'];
        if($_POST['personRoom'] == 'single room') {
            $room_type = 1;
        } else if($_POST['personRoom'] == 'double room') {
            $room_type = 2;
        } else if($_POST['personRoom'] == 'cottage') {
            $room_type = 4;
        }
        $room_number = $_POST['room_number'];


        $sql2 = "SELECT * FROM `rooms` WHERE hotel_id = '$hotel_id'";
        $res2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($res2);

        $checkinDate = $_POST['checkinDate'];
        $checkoutDate = $_POST['checkoutDate'];

        // Create DateTime objects for check-in and check-out dates
        $checkin = new DateTime($checkinDate);
        $checkout = new DateTime($checkoutDate);

        // Calculate the difference between the two dates
        $interval = $checkin->diff($checkout);

        // Get the total number of days
        $numberOfDays = $interval->days;

        if($numberOfDays == 0) {
            $_SESSION['total_payment'] = $row2['room_price'] * $room_type * $room_number;
        } else {
            $_SESSION['total_payment'] = $row2['room_price'] * $numberOfDays * $room_type * $room_number;
        }

        $_SESSION['checkinDate'] = $checkinDate;
        $_SESSION['checkoutDate'] = $checkoutDate;
        $_SESSION['personRoom'] = $_POST['personRoom'];
        $_SESSION['room_number'] = $room_number;

        $sql = "INSERT INTO `booking_details`(`user_id`, `hotel_id`, `user_contact`, `check_in`, `check_out`, `reserve_room_type`, `reserve_room_number`, `guest`, `children`) VALUES ('$user_id','$hotel_id','$user_phone','$checkinDate','$checkoutDate','$room_type','$room_number', $guest, $children)";
        

        mysqli_query($conn, $sql);
        
        $_SESSION['booking_id'] = mysqli_insert_id($conn);

        header("location: page-payment.php");
    }


    $booking_id = $_SESSION['booking_id'];
    $total_payment = "";
    $payment_method = "";
    if(isset($_POST['order_submit'])) {
        $payment_method = $_POST['inlineRadioOptions'];
        $total_payment = $_SESSION['total_payment'];

        $sql3 = "UPDATE `booking_details` SET `payment_method`='$payment_method',`payment_total`='$total_payment' WHERE id = '$booking_id'";


        unset($_SESSION['checkinDate']);
        unset($_SESSION['checkoutDate']);
        unset($_SESSION['personRoom']);
        unset($_SESSION['room_number']);
        unset($_SESSION['total_payment']);
        unset($_SESSION['order_cart']);
        unset($_SESSION['guest']);
        unset($_SESSION['children']);

        if(mysqli_query($conn,$sql3)) {
            echo '<script>';
            echo 'alert("ORDER COMPLETED!!");';
            echo 'window.location.href = "index.php";';
            echo '</script>';
        }
    }
?>