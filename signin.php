<?php 
    include_once('header.php');
    if(isset($_POST['btnSignIn']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $check_user = "SELECT * FROM users 
                       WHERE email = '$email'
                      ";
        $check_user_query = mysqli_query($connect,$check_user);
        $check_user_row = mysqli_num_rows($check_user_query);
        if($check_user_row > 0)
        {
            $row = mysqli_fetch_array($check_user_query);
            if(password_verify($password,$row['password']))
            {
                $_SESSION['user'] = $row;
                echo "<script>
                        window.location.assign('userprofile.php')
                      </script>
                     ";
            }
            else
            {
                echo "<script>
                        alert('Password is incorrect')
                      </script>
                     ";
            }
        }
        else
        {
            echo "<script>
                    alert('Email doesn\'t exist.')
                  </script>
                 ";
        }
    }
?>
    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sign In</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="contact-form col-12">
                <div id="success"></div>
                <form action="signin.php" method="POST">
                    <div class="row mb-3">
                        <div class="control-group col-12">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                            required="required" value="<?php echo $_POST['email'] ?? ''; ?>" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="control-group col-12">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                            required="required" value="<?php echo $_POST['password'] ?? ''; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 col-12">
                        <a href="signup.php" style="text-decoration:none !important;">Don't you have an account? Please create!</a>
                    </div>
                        <button class="btn btn-primary py-2 px-4" type="submit"  name="btnSignIn" id="sendMessageButton">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact End -->
<?php 
    include_once('footer.php');
?>
