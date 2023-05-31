<?php 
    include_once('header.php');
    // select location without deleting 
    $select_location = "SELECT * FROM locations
                        WHERE deleted_at = 0
                        ORDER BY id DESC";
    $select_location_query = mysqli_query($connect,$select_location);
    $count_location = mysqli_num_rows($select_location_query);
    // insert location
    if(isset($_POST['btnSubmit']))
    {
        $location_range = $_POST['location_range'];
        $duration = $_POST['duration'];
        $fees = $_POST['fees'];
        // check location already exists
        $check_location = "SELECT * FROM locations
                           WHERE location_range = '$location_range'
                          ";
        $check_location_query = mysqli_query($connect,$check_location);
        $count_location = mysqli_num_rows($check_location_query);
        if($count_location > 0)
        {
            echo "<script>
                    alert('location already exists.')
                  </script>
                ";
        }
        else
        {
            $insert = "INSERT INTO locations(`location_range`,`duration`,`fees`)
                       VALUES ('$location_range','$duration','$fees')";
            $insert_query = mysqli_query($connect,$insert);
            if($insert_query)
            {
                echo "<script>
                        alert('location added successfully')
                        window.location.assign('locations.php')
                      </script>
                    ";
            }
        }
     
    }
    // update user
    if(isset($_POST['btnUpdate']))
    {
        $ulocation_id = $_POST['ulocation_id'];
        $ulocation_range = $_POST['ulocation_range'];
        $uduration = $_POST['uduration'];
        $ufees = $_POST['ufees'];
        $update = "UPDATE locations SET
                   location_range = '$ulocation_range',
                   duration = '$uduration',
                   fees = '$ufees'
                   WHERE id = '$ulocation_id'
                  ";
        $update_query = mysqli_query($connect,$update);
        if($update_query)
        {
            echo "<script>
                    alert('Updated successfully')
                    window.location.assign('locations.php')
                  </script>
                 ";
        }
    }
    if(isset($_POST['btnDelete']))
    {
        $dlocation_id = $_POST['dlocation_id'];
        $delete = "UPDATE locations SET
                   deleted_at = 1
                   WHERE id = '$dlocation_id'
                  ";
        $delete_query = mysqli_query($connect,$delete);
        if($delete_query)
        {
            echo "<script>
                    alert('Deleted location successfully')
                    window.location.assign('locations.php')
                 </script>";
        }
    }
?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Locations <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">Add Location</button></h4>
                
              </div>
              <div class="card-body">
                    <table class="table table-hover table-striped" id="location-list">
                        <thead>
                            <th>ID</th>
                            <th>Location Range</th>
                            <th>Duration</th>
                            <th>Fees</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_location > 0)
                            {
                                for ($i=1; $i <= $count_location; $i++) { 
                                    $row_location = mysqli_fetch_assoc($select_location_query);
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_location['location_range']; ?></td>
                                <td><?php echo $row_location['duration']; ?></td>
                                <td><?php echo $row_location['fees']; ?> MMK </td>
                                <td>
                                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModal" data-location='<?php echo json_encode($row_location); ?>'>Edit</button>
                                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row_location['id']; ?>">Delete</button>
                                </td>
                            </tr>
                            <?php
                                }
                                              
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php 
    include_once('footer.php');
?>
<!-- Add Modal -->
<div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
        <form action="locations.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title float-left">Add Location</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="location_range">Location Range</label>
                            <input type="text" class="form-control" name="location_range" id="location_range" placeholder="Hledan To Sanchaung" value="<?php echo $_POST['location_range'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="duration">Estimated Duration</label>
                            <input type="text" class="form-control" name="duration" id="duration" placeholder="1 hour 30 minutes" value="<?php echo $_POST['duration'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="fees">fees</label>
                            <input type="number" class="form-control" name="fees" id="fees" placeholder="fees" value="<?php echo $_POST['fees'] ?? ''; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnSubmit">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <form action="locations.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Edit Location</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="ulocation_range">Location Range</label>
                            <input type="text" class="form-control" id="ulocation_range" name="ulocation_range" placeholder="Location Range" required>
                        </div>
                        <div class="col-md-12">
                            <label for="uduration">Estimated Duration</label>
                            <input type="text" class="form-control" id="uduration" name="uduration" placeholder="Duration" required>
                        </div>
                        <div class="col-md-12">
                            <label for="ufees">fees</label>
                            <input type="text" class="form-control" id="ufees" name="ufees" placeholder="fees" required>
                        </div>
                    </div>
                    <input type="hidden" name="ulocation_id" id="ulocation_id">
                </div>
                
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnUpdate">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
  </div>
  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
        <form action="locations.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Delete Location</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this location ?</p>
                   <input type="hidden" name="dlocation_id" id="dlocation_id">
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="btnDelete">Delete</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
      </form>
    </div>
  </div>
<script>
        $(document).ready( function () {

            // datatable
            $('#location-list').DataTable();

            // edit button click
            $(".editbtn").click(function(){
                var location_data = $(this).attr("data-location");
                var location_data_obj = $.parseJSON(location_data);
                $('#ulocation_range').val(location_data_obj.location_range);
                $('#uduration').val(location_data_obj.duration);
                $('#ufees').val(location_data_obj.fees);
                $('#ulocation_id').val(location_data_obj.id);
            });
            $(".deletebtn").click(function(){
                var location_id = $(this).attr("data-id");
                $("#dlocation_id").val(location_id);
            });
    });

</script>