<?php 
    include_once('header.php');
    echo authentication();
    if(isset($_POST['btnChange']))
    {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $id = $_POST['id'];
        $select_user = "SELECT * FROM users
                        WHERE id = '$id'
                       ";
        $select_user_query = mysqli_query($connect,$select_user);
        $row = mysqli_fetch_assoc($select_user_query);
        $password = $row['password'];
        if(password_verify($old_password,$password))
        {
            if($new_password === $confirm_password)
            {
                $hash_password = password_hash($new_password,PASSWORD_DEFAULT);
                $update = "UPDATE users SET 
                           password = '$hash_password'
                           WHERE id = '$id'
                          ";
                $update_query = mysqli_query($connect,$update);
                if($update_query)
                {
                    echo "<script>
                            alert('Changed password Successfully')
                            window.location.assign('signin.php')
                          </script>
                         ";
                }
                else
                {
                    echo "<script>
                            alert('Something Wrong')
                          </script>
                         ";
                }
            }
            else
            {
                echo "<script>
                        alert('New password and confirm password are not the same')
                      </script>
                     ";
            }
        }
        else
        {
            echo "<script>
                    alert('Password is incorrect')
                 </script>
                 ";
        }
    }
?>
<!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Change Password</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Change Password</p>
            </div>
        </div>
    </div>
 <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Change Password</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="contact-form col-12">
                <div id="success"></div>
                <form action="changepassword.php" method="POST">
                    <div class="control-group mb-3">
                        <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password"
                        required="required" required/>
                    </div>
                    <div class="control-group mb-3">
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password"
                        required="required" required/>
                    </div>
                    <div class="control-group mb-3">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                        required="required" required/>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <button class="btn btn-primary py-2 px-4" type="submit"  name="btnChange">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact End -->
<?php 
    include_once('footer.php');
?>
