<?php
include("sessionAd.php");
include("../server.php");
include("includes/header.php");
?>
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
                        <a href="#" class="nav-link align-middle px-0">
                            <span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <span class="ms-1 d-none d-sm-inline">Booking</span></a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        <div class="col py-3">
            <main role="main">
                <div class="container-sm pt-3" style="text-align:center">
                    <h1>EDIT HOTELS</h1>
                </div>
                <!-- Edit Hotel -->
                <?php
                $fetch_src = FETCH_SRC;
                $h_id = "";
                $city_name = "";
                $c_id = "";
                $hotel_name = "";
                $hotel_description = "";
                $hotel_address = "";
                $contact_number = "";
                $single_room = "";
                $double_room = "";
                $cottage = "";
                $room_price = "";
                $hotel_image = "";
                $room_image = [];
                $room_types_id = "";
                $room_id = "";
                if (isset($_GET['edit'])) {
                    $h_id = $_GET['edit'];
                }
                $sql1 = "SELECT * FROM `hotels` WHERE id = '$h_id'";
                $res1 = mysqli_query($conn, $sql1);
                while ($row1 = mysqli_fetch_assoc($res1)) {

                    $sql2 = "SELECT * FROM `city` WHERE id = '$row1[city_id]'";
                    $res2 = mysqli_query($conn, $sql2);
                    while ($row2 = mysqli_fetch_assoc($res2)) {
                        $city_name = $row2['city_name'];
                        $c_id = $row2['id'];
                    }

                    $hotel_name = $row1['hotel_name'];
                    $hotel_description = $row1['hotel_description'];
                    $hotel_address = $row1['hotel_address'];
                    $contact_number = $row1['contact_number'];

                    $sql3 = "SELECT * FROM `rooms` WHERE `hotel_id`='$h_id' ";
                    $res3 = mysqli_query($conn, $sql3);
                    while ($row3 = mysqli_fetch_assoc($res3)) {
                        $room_id = $row3['id'];
                        $room_types_id = $row3['room_types_id'];
                        $room_price = $row3['room_price'];
                    }

                    $sql4 = "SELECT * FROM `room_types` WHERE `id`='$room_types_id' ";
                    $res4 = mysqli_query($conn, $sql4);
                    while ($row4 = mysqli_fetch_assoc($res4)) {
                        $single_room = $row4['single_room'];
                        $double_room = $row4['double_room'];
                        $cottage = $row4['cottage'];
                    }
                    $sql5 = "SELECT * FROM `hotel_image` WHERE `hotel_id`='$h_id' ";
                    $res5 = mysqli_query($conn, $sql5);
                    while ($row5 = mysqli_fetch_assoc($res5)) {
                        $hotel_image = $row5['image'];
                    }

                    $resMultipleImg = mysqli_query($conn, "SELECT `id`, `hotel_id`, `images` FROM `room_image` WHERE `hotel_id` = '$h_id' ");
                    if (mysqli_num_rows($resMultipleImg) > 0) {
                        $j = 0;
                        while ($rowsImgs = mysqli_fetch_assoc($resMultipleImg)) {
                            $room_image[$j]['images'] = $rowsImgs['images'];
                            $room_image[$j]['id'] = $rowsImgs['id'];
                            $j++;
                        }
                    }
                }
                ?>
                <div class="container w-50 border mt-5 ">
                    <form class="mt-5" action="hotel_crud.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                        <input type="hidden" name="ct_id" id="ct_id" value="<?= $c_id; ?>">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city_name" value="<?php echo $city_name; ?>" required>
                        </div>
                        <h3 class="container-sm pt-3" style="text-align:center">Hotel</h3>
                        <div class="mb-3">
                            <label class="form-label">Hotel Name</label>
                            <input type="text" class="form-control" name="hotel_name" value="<?php echo $hotel_name; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel Description</label>
                            <textarea class="form-control" name="hotel_description"><?php echo $hotel_description; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel Address</label>
                            <input type="text" class="form-control" name="hotel_address" value="<?php echo $hotel_address; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" value="<?php echo $contact_number; ?>" required>
                        </div>
                        <h3 class="container-sm pt-3" style="text-align:center">Rooms</h3>
                        <input type="hidden" name="rmt_id" id="rmt_id" value="<?= $room_types_id; ?>">
                        <div class="mb-3">
                            <label class="form-label">Single Bed Room</label>
                            <input type="number" class="form-control" name="single_room" value="<?php echo $single_room; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Double Bed Room</label>
                            <input type="number" class="form-control" name="double_room" value="<?php echo $double_room; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cottage</label>
                            <input type="number" class="form-control" name="cottage" value="<?php echo $cottage; ?>" required>
                        </div>
                        <input type="hidden" name="rm_id" id="rm_id" value="<?= $room_id; ?>">
                        <div class="mb-3">
                            <label class="form-label">Room Price</label>
                            <input type="number" class="form-control" name="room_price" value="<?php echo $room_price; ?>" required>
                        </div>
                        <h3 class="container-sm pt-3" style="text-align:center">Image</h3>
                        <img src="<?= $fetch_src . $hotel_image; ?>" name="editimg" width="30%" class="mb-3">
                        <div class="row">
                            <div class="mb-3 col-lg-9">
                                <label for="" class="form-label">Hotel Image</label>
                                <input type="file" class="form-control" name="hotel_image" accept="">
                            </div>
                            <div class="pt-2 col-lg-3" id="image_box">
                                <label for="" class="form-label"></label>
                                <button type="button" onclick="add_more_images()" class="btn btn-outline-info text-dark form-control">Add Room Images</button>
                            </div>
                        </div>
                        <?php
                        if (isset($room_image[0])) {
                            foreach ($room_image as $list) {
                                echo '<div id="add_image_box_' . $list['id'] . '"><label for="" class="form-label"></label><input type="file" class="form-control" name="room_images[]" accept=""><a style="color:white" href="hotel_crud.php?h_id=' . $h_id . '&mid=' . $list['id'] . '"><button type="button" class="btn btn-danger text-white btn-outline-success form-control" >Remove</button></a>';
                                echo "<a target='_blank' href='" . FETCH_MULTIPLE . $list['images'] . "'><img height='150px' width='150px' src='" . FETCH_MULTIPLE . $list['images'] . "' /></a>";
                                echo '<input type="hidden" name="images_id[]" value="' . $list['id'] . '" /></div>';
                            }
                        }
                        ?>
                        <input type="hidden" name="ho_id" id="ho_id" value="<?= $h_id; ?>">
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="edit_hotel" class="btn btn-success text-white  form-control w-50 m-3">Edit hotel</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    var total_image = 1;

    function add_more_images() {
        total_image++;
        var html = '<div class="mb-3 col-lg-6" id="add_image_box_' + total_image + '"><label for="" class="form-label">Room Image</label><input type="file" class="form-control" name="room_images[]" accept=""><div class="pt-1"><button type="button" class="btn btn-danger text-white form-control" onClick=remove_image("' + total_image + '")>Remove</button></div></div>';
        jQuery('#image_box').after(html);
    }

    function remove_image(id) {
        jQuery('#add_image_box_' + id).remove();
    }
</script>