<?php
include("../server.php");
include("includes/header.php");
?>


<div class="ps-5">
    <div class="row">

        <div class="col-lg-2">
            <h4 class="ms-5 pt-3">FILTERS</h4>
            <div class="container-fluid flex-lg-column align-items-stretch">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="collapse navbar-collapse flex-column" id="navbarNav">
                        <div class="border bg-light rounded">
                            <iframe class="w-100 rounded" src="https://www.google.com/maps/d/embed?mid=1Ud5DRnqhKifdeHQ0wjENsGgLp_0&hl=en_US&ehbc=2E312F" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="col-lg-9 col-md-12 mb-lg-0 mb-4 pe-5">
            <h1 class="text-center py-5 fw-bold">BOOKING CART</h1>
            <?php
            if (isset($_SESSION['order_cart'])) {
                foreach ($_SESSION['order_cart'] as $key => $value1) {
                    $h_id = $value1['hotel_id'];

                    $sql2 = "SELECT * FROM `hotels` WHERE id = '$h_id' ";
                    $res2 = mysqli_query($conn, $sql2);
                    while ($row2 = mysqli_fetch_assoc($res2)) {
            ?>
                        <div class="card mb-4 mt-5 border-0 shadow">
                            <div class="row g-0 p-3 align-items-center">
                                <div class="col-md-4">
                                    <?php
                                    $sql5 = "SELECT * FROM `hotel_image` WHERE hotel_id = '$row2[id]'";
                                    $res5 = mysqli_query($conn, $sql5);
                                    $img_lc = '';
                                    while ($row5 = mysqli_fetch_assoc($res5)) {
                                        $img_lc = $row5['image'];
                                    }
                                    ?>
                                    <img src="<?= FETCH_SRC . $img_lc ?>" class="img-fluid rounded-start w-75" alt="">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <h3 class="card-title text-info"><?php echo $row2['hotel_name'] ?></h3>

                                        <p class="text-muted">Rating : <span class="ps-2">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </span></p>
                                        <p class="text-dark">Contact Number : <?php echo $row2['contact_number'] ?> </p>
                                        <p class="card-text"><small class="text-muted"><?php echo $row2['hotel_address'] ?></small></p>
                                    </div>
                                </div>
                                <div class="col-md-1 text-align-center">
                                    <a href="page-book.php?h_id=<?php echo $h_id; ?>" class="btn btn-sm text-white w-100 shadow mb-3 bg-dark">Book Now</a>
                                    <a href="page-2.php?h_id=<?php echo $h_id; ?>" class="btn btn-sm w-100 btn-outline-dark shadow-none">More Details</a>
                                    <div class="pt-5"></div>
                                    <a href="cart_func.php?rem_id=<?php echo $h_id; ?>" class="btn btn-sm text-white w-100 shadow mb-3 bg-danger">Remove</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
            <?php
                }
            }
            ?>
        </div>

    </div>
</div>


<?php
include("includes/footer.php");
?>