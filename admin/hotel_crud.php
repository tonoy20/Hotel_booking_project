<?php 
    include("../server.php");
function image_upload($img)
{
    $tmp_loc = $img['tmp_name'];
    $new_name = random_int(11111, 99999) . $img['name'];

    $new_loc = UPLOAD_SRC . $new_name;
    if (!move_uploaded_file($tmp_loc, $new_loc)) {
        header("location: index.php");
        exit;
    } else {
        return $new_name;
    }
}


if (isset($_POST['add_hotel'])) {
    $city_name = mysqli_real_escape_string($conn, $_POST['city_name']);
    $hotel_name = mysqli_real_escape_string($conn, $_POST['hotel_name']);
    $hotel_description = mysqli_real_escape_string($conn, $_POST['hotel_description']);
    $hotel_address = mysqli_real_escape_string($conn, $_POST['hotel_address']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $single_room = mysqli_real_escape_string($conn, $_POST['single_room']);
    $double_room = mysqli_real_escape_string($conn, $_POST['double_room']);
    $cottage = mysqli_real_escape_string($conn, $_POST['cottage']);

    $room_price = mysqli_real_escape_string($conn, $_POST['room_price']);

    $img_path = image_upload($_FILES['hotel_image']);

    $resCity = mysqli_query($conn, "SELECT * FROM city WHERE city_name = '$city_name' ");

    $city_id='';
    if (mysqli_num_rows($resCity) > 0) {
       while($res = mysqli_fetch_assoc($resCity)) {
        $city_id = $res['id'];
       }
    } else {
        mysqli_query($conn, "INSERT INTO `city`(`city_name`) VALUES ('$city_name')");
        $city_id = mysqli_insert_id($conn);
    }  

    $inHotel = mysqli_query($conn, "INSERT INTO `hotels`(`city_id`, `hotel_name`,`hotel_description`, `hotel_address`,`contact_number`) VALUES ('$city_id','$hotel_name','$hotel_description','$hotel_address', '$contact_number')");

    $hotel_id = mysqli_insert_id($conn);

    mysqli_query($conn, "INSERT INTO `hotel_image`(`hotel_id`, `image`) VALUES ('$hotel_id','$img_path')");

     // multiple image upload
     if (isset($_FILES['room_images']['name'])) {
        foreach ($_FILES['room_images']['name'] as  $key => $val) {
            $imgs = rand(11111, 99999) . $_FILES['room_images']['name'][$key];
            move_uploaded_file($_FILES['room_images']['tmp_name'][$key], MULTIPLE_IMG . $imgs);
            mysqli_query($conn, "INSERT INTO `room_image`(`hotel_id`, `images`)  VALUES ('$hotel_id','$imgs')");
        }
    }

    $inRoomType = mysqli_query($conn, "INSERT INTO `room_types`(`single_room`, `double_room`, `cottage`,  `available_single`, `available_double`, `available_cottage`) VALUES ('$single_room','$double_room','$cottage', '$single_room','$double_room','$cottage')");

    $roomType_id = mysqli_insert_id($conn);

    $inRoom = mysqli_query($conn, "INSERT INTO `rooms`(`hotel_id`, `room_types_id`, `room_price`) VALUES ('$hotel_id','$roomType_id','$room_price')");

    if($inRoom) {
        header("location: index.php?success=added");
    } else {
        header("location: index.php?success=failed");
    }
}

// delete hotel
if(isset($_GET['del'])) {
    $h_id = $_GET['del'];
    $sql1 = "DELETE FROM `hotels` WHERE `id`= '$h_id' ";
    mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM `hotel_image` WHERE `hotel_id`='$h_id' ";
    mysqli_query($conn, $sql2);

    $sql3 = "SELECT * FROM `rooms` WHERE `hotel_id`='$h_id' ";
    $res3 = mysqli_query($conn, $sql3);
    $row3 = mysqli_fetch_assoc($res3);
    $room_id = $row3['room_types_id'];

    $sql4 = "DELETE FROM `rooms` WHERE `hotel_id` = '$h_id' ";
    mysqli_query($conn, $sql4);

    $sql5 = "DELETE FROM `room_types` WHERE `id` = '$room_id' ";
    mysqli_query($conn, $sql5);

    $sql6 = "DELETE FROM `room_image` WHERE `hotel_id` = '$h_id' ";
    $res6 =  mysqli_query($conn, $sql6);

    if($res6) {
        header("location: index.php?success=deleted");
    }
}


// Delete multiple
if (isset($_GET['mid']) && $_GET['mid'] > 0) {
    $room_image_id =  $_GET['mid'];
    $sql = "SELECT * FROM `room_image` WHERE id = '$room_image_id'";
    $res = mysqli_query($conn, $sql);
    $fetchimg = mysqli_fetch_assoc($res);
    unlink(MULTIPLE_IMG . $fetchimg['images']);

    $sql2 = "DELETE FROM `room_image` WHERE id = '$room_image_id'";
    $res2 = mysqli_query($conn, $sql2);
    $hotel_id = $_GET['h_id'];
    if ($res2) {
        header("location: edit_hotel.php?edit=$hotel_id");
    }
}

// Edit Hotel

if(isset($_POST['edit_hotel'])) {
    $hotel_id = mysqli_real_escape_string($conn, $_POST['ho_id']);
    $city_id = mysqli_real_escape_string($conn, $_POST['ct_id']);
    $room_id = mysqli_real_escape_string($conn, $_POST['rm_id']);
    $room_types_id = mysqli_real_escape_string($conn, $_POST['rmt_id']);
    $city_name = mysqli_real_escape_string($conn, $_POST['city_name']);

    $resCity = mysqli_query($conn, "SELECT * FROM city WHERE city_name = '$city_name' ");

    if (mysqli_num_rows($resCity) > 0) {
       while($res = mysqli_fetch_assoc($resCity)) {
        $city_id = $res['id'];
       }
    } else {
        mysqli_query($conn, "UPDATE `city` SET `city_name`='$city_name' WHERE id = '$city_id'");
    }  

    $hotel_name = mysqli_real_escape_string($conn, $_POST['hotel_name']);
    $hotel_description = mysqli_real_escape_string($conn, $_POST['hotel_description']);
    $hotel_address = mysqli_real_escape_string($conn, $_POST['hotel_address']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    $sql1 = "UPDATE `hotels` SET `city_id`='$city_id',`hotel_name`='$hotel_name',`hotel_description`='$hotel_description',`hotel_address`='$hotel_address',`contact_number`='$contact_number' WHERE id = '$hotel_id'";
    mysqli_query($conn, $sql1);

    $single_room = mysqli_real_escape_string($conn, $_POST['single_room']);
    $double_room = mysqli_real_escape_string($conn, $_POST['double_room']);
    $cottage = mysqli_real_escape_string($conn, $_POST['cottage']);

    $sql2 = "UPDATE `room_types` SET `single_room`='$single_room',`double_room`='$double_room',`cottage`='$cottage',`available_single`='$single_room',`available_double`='$double_room',`available_cottage`='$cottage' WHERE id = '$room_types_id'";
    mysqli_query($conn, $sql2);

    $room_price = mysqli_real_escape_string($conn, $_POST['room_price']);

    $sql3 = "UPDATE `rooms` SET `room_price`='$room_price' WHERE id='$room_id' ";
    mysqli_query($conn, $sql3);

    if (is_uploaded_file($_FILES['hotel_image']['tmp_name'])) {
        $imgname = image_upload($_FILES['hotel_image']);
        $sql4 = "UPDATE `hotel_image` SET `image`='$imgname' WHERE hotel_id = '$hotel_id'";
        mysqli_query($conn, $sql4);
    } 

       // multiple images Update
       if (isset($_FILES['room_images']['name'])) {
        foreach ($_FILES['room_images']['name'] as $key => $val) {
             if ($_FILES['room_images']['name'][$key] != '') {
                if (isset($_POST['images_id'][$key])) {
                    $imgs = rand(11111, 99999) . $_FILES['room_images']['name'][$key];
                    move_uploaded_file($_FILES['room_images']['tmp_name'][$key], MULTIPLE_IMG . $imgs);
                    mysqli_query($conn, "UPDATE `room_image` SET `images` = '$imgs' WHERE id = '".$_POST['images_id'][$key]."' ");
                } else {
                    $imgs = rand(11111, 99999) . $_FILES['room_images']['name'][$key];
                    move_uploaded_file($_FILES['room_images']['tmp_name'][$key], MULTIPLE_IMG . $imgs);
                    mysqli_query($conn, "INSERT INTO `room_image`(`hotel_id`, `images`) VALUES ('$hotel_id','$imgs')");
                }
             }
        }
    }


    header("location: index.php");
}
?>
