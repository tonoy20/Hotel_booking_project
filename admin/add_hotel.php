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
                            <span class="ms-1 d-none d-sm-inline">Orders</span></a>
                    </li>
                </ul>
                <hr>
            </div>
        </div>
        <div class="col py-3">
            <main role="main">
                <div class="container-sm pt-3" style="text-align:center">
                    <h1>ADD HOTELS</h1>
                </div>

                <div class="container w-50 border mt-5 ">
                    <form class="mt-5" action="hotel_crud.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city_name" required>
                        </div>
                        <h3 class="container-sm pt-3" style="text-align:center">Hotel</h3>
                        <div class="mb-3">
                            <label class="form-label">Hotel Name</label>
                            <input type="text" class="form-control" name="hotel_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel Description</label>
                            <textarea class="form-control" name="hotel_description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel Address</label>
                            <input type="text" class="form-control" name="hotel_address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hotel Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" required>
                        </div>
                        <h3 class="container-sm pt-3" style="text-align:center">Rooms</h3>
                        <div class="mb-3">
                            <label class="form-label">Single Bed Room</label>
                            <input type="number" class="form-control" name="single_room" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Double Bed Room</label>
                            <input type="number" class="form-control" name="double_room" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cottage</label>
                            <input type="number" class="form-control" name="cottage" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Room Price</label>
                            <input type="number" class="form-control" name="room_price" required>
                        </div>
                        <h3 class="container-sm pt-3" style="text-align:center">Image</h3>
                        <div class="row" id="image_box">
                            <div class="mb-3 col-lg-9">
                                <label for="" class="form-label">Hotel Image</label>
                                <input type="file" class="form-control" name="hotel_image" accept="">
                            </div>
                            <div class="pt-2 col-lg-3">
                                <label for="" class="form-label"></label>
                                <button type="button" onclick="add_more_images()" class="btn btn-outline-info text-dark form-control">Add Room Images</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="add_hotel" class="btn btn-success text-white  form-control w-50 m-3">Add hotel</button>
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
      var html = '<div class="mb-3 col-lg-6" id="add_image_box_' + total_image + '"><label for="" class="form-label">Room Image</label><input type="file" class="form-control" name="room_images[]" accept="jpg,.png,.svg,.webp"><div class="pt-1"><button type="button" class="btn btn-danger text-white form-control" onClick=remove_image("' + total_image + '")>Remove</button></div></div>';
      jQuery('#image_box').after(html);
    }

    function remove_image(id) {
      jQuery('#add_image_box_' + id).remove();
    }
  </script>

