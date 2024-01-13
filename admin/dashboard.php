<?php
include("sessionAd.php");
include("../server.php");
include("includes/header.php");
?>

<?php 
    $sql1 = "SELECT * FROM `booking_details`";
    $res1 = mysqli_query($conn, $sql1);
    $money = [];
    $count = 0;
    while($row1 = mysqli_fetch_assoc($res1)) {
        $sql2 = "SELECT * FROM hotels WHERE id = $row1[hotel_id]";
        $res2 = mysqli_query($conn,  $sql2);
        $row2 = mysqli_fetch_assoc($res2);
        $money[$count]["label"] = $row2['hotel_name'];
        $money[$count]["y"] = $row1['payment_total']; 
        $count++;
    }
?>


<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "Hotel Booking Payment - 2024"
	},
	axisY: {
        title: "In Millions",
		suffix: "%",
		scaleBreaks: {
			autoCalculate: true
		}
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0\"৳\"",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($money, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
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
                        <a href="order.php" class="nav-link px-0 align-middle">
                            <span class="ms-1 d-none d-sm-inline">Booking</span></a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        <div class="col py-3 pt-5">
            <h1 class="fw-bold text-center pb-5">Dahsboard</h1>
            <div class="row px-5">
                <div class="col shadow">
                    <div class="text-center h3 pt-5">Pending</div>
                    <?php 
                        $total = 0;
                        $sql2 = "SELECT * FROM `booking_details` WHERE payment_method = 'cash'";
                        $res2 = mysqli_query($conn, $sql2);
                        while($row2 = mysqli_fetch_assoc($res2)) {
                            $total = $total + $row2['payment_total'];
                        } 
                    ?>
                    <div class="d-flex h1 justify-content-center">৳<p class="counter ps-1"><?php echo $total; ?></p></div>
                    <div class="text-center h5 pb-5">Total Pending</div>
                </div>
                <div class="col-1"></div>
                <div class="col shadow">
                <div class="text-center h3 pt-5">Earning</div>
                    <?php 
                        $total = 0;
                        $sql3 = "SELECT * FROM `booking_details` WHERE payment_method = 'paypal'";
                        $res3 = mysqli_query($conn, $sql3);
                        while($row3 = mysqli_fetch_assoc($res3)) {
                            $total = $total + $row3['payment_total'];
                        } 
                    ?>
                    <div class="d-flex h1 justify-content-center">৳<p class="counter ps-1"><?php echo $total; ?></p></div>
                    <div class="text-center h5 pb-5">Total Earning</div>
                </div>
                <div class="col-1"></div>
                <div class="col shadow">    
                    <div class="text-center h3 pt-5">Services</div>
                    <?php 
                        $total = 0;
                        $sql3 = "SELECT * FROM `booking_details`";
                        $res3 = mysqli_query($conn, $sql3);
                        while($row3 = mysqli_fetch_assoc($res3)) {
                            $total = $total + 1;
                        } 
                    ?>
                    <div class="d-flex h1 justify-content-center"><p class="counter ps-1"><?php echo $total; ?></p></div>
                    <div class="text-center h5 pb-5">Total Bookable services</div>
                </div>
            </div>
            <!-- Chart Render -->
            <div class="pt-5" id="chartContainer" style="height: 400px; width: 100%;"></div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.0/jquery.waypoints.min.js" integrity="sha512-oy0NXKQt2trzxMo6JXDYvDcqNJRQPnL56ABDoPdC+vsIOJnU+OLuc3QP3TJAnsNKXUXVpit5xRYKTiij3ov9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js" integrity="sha512-d8F1J2kyiRowBB/8/pAWsqUl0wSEOkG5KATkVV4slfblq9VRQ6MyDZVxWl2tWd+mPhuCbpTB4M7uU/x9FlgQ9Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
</script>


<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

