<?php 
    include_once('header.php');
    // select category without deleting 
    $select_payment_type = "SELECT * FROM payment_types
                            WHERE deleted_at = 0
                            ORDER BY id DESC";
    $select_payment_type_query = mysqli_query($connect,$select_payment_type);
    $count_payment_type = mysqli_num_rows($select_payment_type_query);
    // insert payment type
    if(isset($_POST['btnSubmit']))
    {
        $payment_type = $_POST['payment_type'];
        // check payment type already exists
        $check_payment_type = "SELECT * FROM payment_types
                              WHERE type = '$payment_type'
                             ";
        $check_payment_type_query = mysqli_query($connect,$check_payment_type);
        $count_payment_type = mysqli_num_rows($check_payment_type_query);
        if($count_payment_type > 0)
        {
            echo "<script>
                    alert('Payment type already exists.')
                  </script>
                ";
        }
        else
        {
            $insert = "INSERT INTO payment_types(`type`)
                       VALUES ('$payment_type')";
            $insert_query = mysqli_query($connect,$insert);
            if($insert_query)
            {
                echo "<script>
                        alert('Payment Type added successfully')
                        window.location.assign('payment_types.php')
                      </script>
                    ";
            }
        }
     
    }
    // update user
    if(isset($_POST['btnUpdate']))
    {
        $upaymenttype_id = $_POST['upaymenttype_id'];
        $upayment_type = $_POST['upayment_type'];
        $update = "UPDATE payment_types SET
                   type = '$upayment_type'
                   WHERE id = '$upaymenttype_id'
                  ";
        $update_query = mysqli_query($connect,$update);
        if($update_query)
        {
            echo "<script>
                    alert('Updated successfully')
                    window.location.assign('payment_types.php')
                  </script>
                 ";
        }
    }
    if(isset($_POST['btnDelete']))
    {
        $dpaymenttype_id = $_POST['dpaymenttype_id'];
        $delete = "UPDATE payment_types SET
                   deleted_at = 1
                   WHERE id = '$dpaymenttype_id'
                  ";
        $delete_query = mysqli_query($connect,$delete);
        if($delete_query)
        {
            echo "<script>
                    alert('Deleted payment type successfully')
                    window.location.assign('payment_types.php')
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
                <h4 class="card-title addbtn">Payment Types <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">Add Payment Types </button></h4>
                
              </div>
              <div class="card-body">
                    <table class="table table-hover table-striped" id="payment-type">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_payment_type > 0)
                            {
                                for ($i=1; $i <= $count_payment_type; $i++) { 
                                    $row_payment_type = mysqli_fetch_assoc($select_payment_type_query);
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_payment_type['type']; ?></td>
                                <td>
                                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModal" data-payment-type='<?php echo json_encode($row_payment_type); ?>'>Edit</button>
                                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row_payment_type['id']; ?>">Delete</button>
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
        <form action="payment_types.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title float-left">Add Payment Types</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="payment_type">Payment Type</label>
                            <input type="text" class="form-control" name="payment_type" id="payment_type" placeholder="Payment Type" value="<?php echo $_POST['payment_type'] ?? ''; ?>" required>
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
        <form action="payment_types.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Edit Payment Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="upayment_type">Payment Type</label>
                            <input type="text" class="form-control" id="upayment_type" name="upayment_type" placeholder="Payment Type" required>
                        </div>
                    </div>
                    <input type="hidden" name="upaymenttype_id" id="upaymenttype_id">
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
        <form action="payment_types.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Delete Payment Type</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this payment type ?</p>
                   <input type="hidden" name="dpaymenttype_id" id="dpaymenttype_id">
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
            $('#payment-type').DataTable();

            // edit button click
            $(".editbtn").click(function(){
                var payment_type_data = $(this).attr("data-payment-type");
                var payment_type_data_obj = $.parseJSON(payment_type_data);
                $('#upayment_type').val(payment_type_data_obj.type);
                $('#upaymenttype_id').val(payment_type_data_obj.id);
            });
            $(".deletebtn").click(function(){
                var paymenttype_id = $(this).attr("data-id");
                $("#dpaymenttype_id").val(paymenttype_id);
            });
    });

</script>