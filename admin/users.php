<?php 
    include_once('header.php');
    // select user without deleting their account by admin and not admin role
    $select_user = "SELECT * FROM users
                    WHERE deleted_at = 0 AND role != 1
                    ORDER BY id DESC";
    $select_user_query = mysqli_query($connect,$select_user);
    $count_user = mysqli_num_rows($select_user_query);
    // insert user
    if(isset($_POST['btnSubmit']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = $_POST['role'];
        $address = $_POST['address'];
        // password and confirm password do not match
        if($password != $confirm_password)
        {
            echo "
                    <script>
                        alert('Password and Confirm Password do not match')
                    </script>
                 ";
        }
        else
        {
               // check email already exists
            $check_email = "SELECT * FROM users
                            WHERE email = '$email'
                           ";
            $check_email_query = mysqli_query($connect,$check_email);
            $count_email = mysqli_num_rows($check_email_query);
            if($count_email > 0)
            {
                echo "<script>
                        alert('Email already exists.')
                     </script>
                    ";
            }
            else
            {
                $hash_password = sha1($password);
                $insert = "INSERT INTO users(`name`, `role`, `email`, `password`, `phone_number`,`address`)
                           VALUES ('$name','$role','$email','$hash_password','$phone_number','$address')";
                $insert_query = mysqli_query($connect,$insert);
                if($insert_query)
                {
                    echo "<script>
                            alert('User added successfully')
                            window.location.assign('users.php')
                          </script>
                        ";
                }
            }
        }
     
    }
    // update user
    if(isset($_POST['btnUpdate']))
    {
        $uuser_id = $_POST['uuser_id'];
        $uname = $_POST['uname'];
        $uemail = $_POST['email'];
        $uphone_number =$_POST['uphone_number'];
        $urole = $_POST['urole'];
        $uaddress = $_POST['uaddress'];
        $update = "UPDATE users SET
                   name = '$uname',
                   email = '$uemail',
                   phone_number = '$uphone_number',
                   role = '$urole',
                   address = '$uaddress'
                   WHERE id = '$uuser_id'
                  ";
        $update_query = mysqli_query($connect,$update);
        if($update_query)
        {
            echo "<script>
                    alert('Updated successfully')
                    window.location.assign('users.php')
                  </script>
                 ";
        }
    }
    if(isset($_POST['btnDelete']))
    {
        $duser_id = $_POST['duser_id'];
        $delete = "UPDATE users SET
                   deleted_at = 1
                   WHERE id = '$duser_id'
                  ";
        $delete_query = mysqli_query($connect,$delete);
        if($delete_query)
        {
            echo "<script>
                    alert('Deleted account successfully')
                    window.location.assign('users.php')
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
                <h4 class="card-title addbtn">Users <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModal">Add Users</button></h4>
                
              </div>
              <div class="card-body">
                    <table class="table table-hover table-striped" id="user-list">
                        <thead>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_user > 0)
                            {
                                for ($i=1; $i <= $count_user; $i++) { 
                                    $row_user = mysqli_fetch_assoc($select_user_query);
                                    switch ($row_user['role']) {
                                        case 4:
                                        $role_name = "Delivery";
                                        break;
                                        case 3:
                                        $role_name = "Customer";
                                        break;
                                        case 2:
                                        $role_name = "Staff";
                                        break;
                                    }
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_user['name']; ?></td>
                                <td><?php echo $role_name; ?></td>
                                <td><?php echo $row_user['email']; ?></td>
                                <td><?php echo $row_user['phone_number']; ?></td>
                                <td><?php echo $row_user['address']; ?></td>
                                <td>
                                    <button class="btn btn-primary editbtn" data-toggle="modal" data-target="#editModal" data-user='<?php echo json_encode($row_user); ?>'>Edit</button>
                                    <button class="btn btn-danger deletebtn" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row_user['id']; ?>">Delete</button>
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
        <form action="users.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title float-left">Add Users</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">User Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="User Name" value="<?php echo $_POST['name'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">User Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="2" <?php if((isset($_POST['role'])) && ($_POST['role'] == 2)){ echo 'selected'; } ?>>Staff</option>
                                <option value="4" <?php if((isset($_POST['role'])) && ($_POST['role'] == 4)){ echo 'selected'; } ?>>Delivery</option>
                                <option value="3" <?php if((isset($_POST['role'])) && ($_POST['role'] == 3)){ echo 'selected'; } ?>>Customer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?php echo $_POST['phone_number'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $_POST['password'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" value="<?php echo $_POST['confirm_password'] ?? ''; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="address">Address</label>
                            <textarea name="address" cols="30" class="form-control" rows="10" required><?php echo $_POST['address'] ?? ''; ?></textarea>
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
        <form action="users.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="uname">User Name</label>
                            <input type="text" class="form-control" id="uname" name="uname" placeholder="User Name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="uemail">User Email</label>
                            <input type="email" name="email" class="form-control" id="uemail" placeholder="Email" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="urole">Role</label>
                            <select name="urole" id="urole" class="form-control">
                                <option value="2">Staff</option>
                                <option value="4">Delivery</option>
                                <option value="3">Customer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="uphone_number">Phone Number</label>
                            <input type="text" class="form-control" name="uphone_number" id="uphone_number" placeholder="Phone Number" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="uaddress">Address</label>
                            <textarea name="uaddress" class="form-control" cols="30" id="uaddress" rows="10" required></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="uuser_id" id="uuser_id">
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
        <form action="users.php" method="POST">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title float-left">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this account ?</p>
                   <input type="hidden" name="duser_id" id="duser_id">
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
            $('#user-list').DataTable();

            // edit button click
            $(".editbtn").click(function(){
                var user_data = $(this).attr("data-user");
                var user_data_obj = $.parseJSON(user_data);
                $('#uname').val(user_data_obj.name);
                $('#uemail').val(user_data_obj.email);
                $('#urole').val(user_data_obj.role);
                $('#uphone_number').val(user_data_obj.phone_number);
                $('#uuser_id').val(user_data_obj.id);
                $('#uaddress').val(user_data_obj.address);
            });
            $(".deletebtn").click(function(){
                var user_id = $(this).attr("data-id");
                $("#duser_id").val(user_id);
            });
    });

</script>