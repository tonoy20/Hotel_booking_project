<main role="main">
    <div class="container-sm pt-2" style="text-align:right">
        <a class="btn btn-success ps-5 pe-5 pt-2 pb-2" href="add_hotel.php">Add hotel</a>
    </div>
    <div class="mt-5">
        <div class="">
            <table class="fi-table">
                <thead class="bg-dark text-white">
                    <tr class="text-center shadow">
                        <th width="5%" scope="col">No</th>
                        <th width="8%" scope="col">City</th>
                        <th width="20%" scope="col">Hotel Name</th>
                        <th width="30%" scope="col">Hotel Address</th>
                        <th width="13%" scope="col">Contact Number</th>
                        <th width="35%" scope="col">Image</th>
                        <th width="5%" scope="col"></th>
                        <th width="5%" scope="col"></th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $sql = "SELECT * FROM `hotels`";
                    $res = mysqli_query($conn, $sql);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $sql2 = "SELECT * FROM `city` WHERE id = '$row[city_id]'";
                        $res2 = mysqli_query($conn, $sql2);
                        $city_name = "";
                        while ($row2 = mysqli_fetch_assoc($res2)) {
                            $city_name = $row2['city_name'];
                        }
                    ?>
                        <tr class="align-middle shadow">
                            <td><a href="show_hotel-2.php?h_id=<?= $row['id']; ?>"><p class="btn btn-secondary"><?php echo $i++; ?></p></a></td>
                            <td><?php echo $city_name; ?></td>
                            <td class="fw-bold"><?php echo $row['hotel_name']; ?></td>
                            <td><?php echo $row['hotel_address']; ?></td>
                            <td><?php echo $row['contact_number']; ?></td>
                           
                            <?php 
                                $fetch_src = FETCH_SRC;
                                 $sql5 = "SELECT * FROM `hotel_image` WHERE hotel_id = '$row[id]'";
                                 $res5 = mysqli_query($conn, $sql5);
                                 while ($row5 = mysqli_fetch_assoc($res5)) {
                                     ?>
                                         <td><img src=<?= $fetch_src.$row5['image']; ?> width="150px"></td>
                                     <?php 
                                 }
                            ?> 
                            <td class="pe-2"><a href="edit_hotel.php?edit=<?= $row['id']; ?>" class="text-decoration-none text-white"><button class="btn btn-info">Edit</a></button></td>
                            <td class="pe-2"><a onclick="return confirm('Are you sure?')" href="hotel_crud.php?del=<?= $row['id'] ?>" class="text-decoration-none text-white"><button class="btn btn-danger">Delete</a></button></td>
                        </tr>
                    <?php
                    }
                    ?> 
                </tbody>
            </table>
        </div>
    </div>
</main>