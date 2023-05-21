<?php 
    include_once('header.php');
    if(isset($_POST['btnSignUp']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $address = $_POST['address'];
        $check_email = "SELECT * FROM users
                        WHERE email = '$email'
                       ";
        $check_email_query = mysqli_query($connect,$check_email);
        $check_email_row = mysqli_num_rows($check_email_query);
        if($check_email_row > 0)
        {
            echo "<script>
                  alert('Email already exists.')
                </script>"; 
        }
        else
        {
            if($password != $confirm_password)
            {
                echo "<script>
                        alert('Password is incorrect.')
                    </script>
                    ";
            }
            else
            {
                $hash_password = password_hash($password,PASSWORD_DEFAULT);
                $insert = "INSERT INTO `users`( `name`, `role`, `email`, `phone_number`, `address`, `password`) 
                                VALUES ('$name',3,'$email','$phone_number','$address','$hash_password')";
                $insert_query = mysqli_query($connect,$insert);
                if($insert_query)
                {
                    echo "<script>
                            alert('Save Successfully')
                            window.location.assign('signin.php')
                        </script>
                        ";
                }

            }
           
        }
    }
?>
<!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Sign up</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Sign Up</p>
            </div>
        </div>
    </div>
 <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sign Up</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="contact-form col-12">
                <div id="success"></div>
                <form action="signup.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="control-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                required="required" value="<?php echo $_POST['name'] ?? ''; ?>"  required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                                required="required" value="<?php echo $_POST['email'] ?? ''; ?>"  required/>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="control-group">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                                required="required" value="<?php echo $_POST['password'] ?? ''; ?>" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                                required="required" value="<?php echo $_POST['confirm_password'] ?? ''; ?>" required/>
                            </div>
                        </div>
                    </div>
                    <div class="control-group mb-3">
                        <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number"
                        required="required" value="<?php echo $_POST['phone_number'] ?? ''; ?>" required/>
                    </div>
                    <div class="control-group mb-3">
                        <textarea class="form-control" rows="6" name="address" id="address" placeholder="Address"
                        required="required" value="<?php echo $_POST['address'] ?? ''; ?>" required></textarea>
                    </div>
                        <button class="btn btn-primary py-2 px-4" type="submit"  name="btnSignUp" id="sendMessageButton">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact End -->
<?php 
    include_once('footer.php');
?>
