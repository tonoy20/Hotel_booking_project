<?php 
    include("../server.php");
    session_start();

    $booking_del = "";
    if(isset($_GET['del'])) {
        $booking_del = $_GET['del'];

        $sql = "DELETE FROM `booking_details` WHERE id = '$booking_del' ";
        $res = mysqli_query($conn, $sql);

        if($res) {
            header("location: page-userOrder.php");
        }
    }
?>