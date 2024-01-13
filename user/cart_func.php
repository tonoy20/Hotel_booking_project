<?php
include("../server.php");
session_start();
?>

<?php
$hotel_id = $_GET['h_id'];
if (isset($_GET['h_id'])) {
    $_SESSION['order_cart'][] = array('hotel_id' => $hotel_id);

    header("location: page-cart.php");  
}


if(isset($_GET['rem_id'])) {
    foreach($_SESSION['order_cart'] as $key => $value) {
        if($value['hotel_id'] === $_GET['rem_id']) {
            unset($_SESSION['order_cart'][$key]);
            $_SESSION['order_cart'] = array_values($_SESSION['order_cart']);
            header("location: page-cart.php");
        }
    }
}

?>