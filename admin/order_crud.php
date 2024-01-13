<?php 
    include("../server.php");
?>
<?php 
    $delete_booking = '';
    if(isset($_GET['del'])) {
        $delete_booking = $_GET['del'];
        echo $delete_booking;

        $sql = "DELETE FROM `booking_details` WHERE id = '$delete_booking'";

        if(mysqli_query($conn, $sql)) {
            header("location: order.php?delete=success");
        }
    }


    if(isset($_POST['reserve_edit'])) {
        $checkin = $_POST['checkinDate'];
        $checkout = $_POST['checkoutDate'];
        $room_type = '';
        if($_POST['personRoom'] == 'single room') {
            $room_type = 1;
        } else if($_POST['personRoom'] == 'double room') {
            $room_type = 2;
        } else if($_POST['personRoom'] == 'cottage') {
            $room_type = 4;
        }
        $room_number = $_POST['room_number'];
        
        $booking_id = $_POST['booking'];

        $sql1 = "SELECT * FROM `booking_details` WHERE id = '$booking_id' ";
        $res1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($res1);


        $sql2 = "SELECT * FROM `rooms` WHERE hotel_id = '$row1[hotel_id]' ";
        $res2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($res2);

        $total_booking_rooms = 0;

        function isWithinDateRange($checkin, $checkout, $pre_checkin, $pre_checkout) {
            $inputDateTime = new DateTime($checkin);
            $inputDateTime2 = new DateTime($checkout);
            $checkinDateTime = new DateTime($pre_checkin);
            $checkoutDateTime = new DateTime($pre_checkout);
        
            return (($checkinDateTime <= $inputDateTime && $inputDateTime <= $checkoutDateTime) || ($checkinDateTime <= $inputDateTime2 && $inputDateTime2 <= $checkoutDateTime) || ($checkinDateTime > $inputDateTime && $inputDateTime2 > $checkoutDateTime));
        }

        if($row1['reserve_room_type'] == $room_type) {
            $total_booking_rooms = 0 - $row1['reserve_room_number'];
        }

        if($total_booking_rooms < 0) {
            $total_booking_rooms = 0;
        }

    
        $sql3 = "SELECT * FROM `booking_details` WHERE hotel_id = '$row1[hotel_id]' ";
        $res3 = mysqli_query($conn, $sql3);
        while($row3 = mysqli_fetch_assoc($res3)) {
            if(isWithinDateRange($checkin, $checkout, $row3['check_in'], $row3['check_out'])) {
                if($row3['reserve_room_type'] == $room_type) {
                    $total_booking_rooms = $total_booking_rooms + $row3['reserve_room_number'];
                }
            }
        }

        $sql4 = "SELECT * FROM `room_types` WHERE id = '$row2[room_types_id]' ";
        $res4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_assoc($res4);

        $available = '';
        if($room_type == 1) {
            $available = $row4['available_single'] - $total_booking_rooms;
        } else if($room_type == 2) {
            $available = $row4['available_double'] - $total_booking_rooms;
        } else if($room_type == 4) {
            $available = $row4['available_cottage'] - $total_booking_rooms;
        }


        $checkinDate = $_POST['checkinDate'];
        $checkoutDate = $_POST['checkoutDate'];

        // Create DateTime objects for check-in and check-out dates
        $checkindate = new DateTime($checkinDate);
        $checkoutdate = new DateTime($checkoutDate);

        // Calculate the difference between the two dates
        $interval = $checkindate->diff($checkoutdate);

        // Get the total number of days
        $numberOfDays = $interval->days;

        $total_price = '';

        if($numberOfDays == 0) {
            $total_price = $row2['room_price'] * $room_number * $room_type;
        } else {
            $total_price = $row2['room_price'] * $room_number * $room_type * $numberOfDays;
        }

        $sql3 = "UPDATE `booking_details` SET `check_in`='$checkin',`check_out`='$checkout',`reserve_room_type`='$room_type',`reserve_room_number`='$room_number',`payment_total`='$total_price' WHERE id = '$booking_id'";

        if($available < $room_number) {
            echo '<script>';
            echo 'alert("Unavailble Room!!");';
            echo 'window.location.href = "order.php";';
            echo '</script>';
        } else if(mysqli_query($conn, $sql3)) {
            header("location: order.php?edit=success");
        }

    }
?>