<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking Project</title>
    <link rel="icon" type="image/png" sizes="32x32" href="images/icon/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand px-5 hotelh1" href="index.php">HOTEL BOOKING</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse ps-5" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item px-5">
                        <a class="nav-link active" aria-current="page" href="index.php">HOME</a>
                    </li>
                    <?php 
                        session_start();
                        if(isset($_SESSION['uname'])) {       
                    ?>
                    <li class="nav-item px-5">
                        <a class="nav-link" href="page-userOrder.php">MY ORDERS</a>
                    </li>
                    <?php 
                        }
                    ?>
                    <?php 
                        if(isset($_SESSION['uname'])) {       
                    ?>
                    <li class="nav-item px-5">
                        <a class="nav-link" href="page-checkout.php">CHECKOUT</a>
                    </li>
                    <?php 
                        }
                    ?>
                    <!--    <li class="nav-item dropdown px-5">
                        <a class="nav-link" href="#">BOOKING</a>
                    </li> -->
                </ul>
            </div>
            <?php 
                 $cnt = 0;
                 if(isset($_SESSION['order_cart'])) {
                     $cnt = count($_SESSION['order_cart']);
                 }
            ?>
            <div id="basket-overview" class="pe-5"><a href="page-cart.php" class="btn btn-outline-success navbar-btn"><i class="bi bi-cart"></i><span class="badge rounded badge-notification bg-outline-secondary text-dark"><?php echo $cnt; ?></span></a></div>
            <?php
            if (isset($_SESSION['uname'])) {
            ?>
                <div class="d-flex pe-5">
                    <p class="pe-5 h4 text-dark text-uppercase"><i class="bi bi-person-fill pe-2"></i><?php echo $_SESSION['uname']; ?></p>
                    <a class="btn btn-outline-danger" aria-current="page" href="../logout.php">Log Out</a>
                </div>
            <?php
            } else {
            ?>
                <div class="d-flex pe-5">
                    <a href="../index.php"><button class="btn btn-outline-success">Login</button></a>
                    <a href="registerUser.php" class="ps-2"><button class="btn btn-outline-dark">Register</button></a>
                </div>
            <?php
            }
            ?>
        </div>
    </nav>