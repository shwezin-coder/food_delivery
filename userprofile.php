<?php 
    include_once('header.php');
    echo authentication();

    if(isset($_POST['btnSubmit']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $id = $_POST['id'];
        $update_user = "UPDATE users SET
                        name = '$name',
                        email = '$email',
                        phone_number = '$phone_number',
                        address = '$address'
                        WHERE id = '$id'";
        $update_user_query = mysqli_query($connect,$update_user);
        if($update_user_query){
            echo "<script>
                    alert('Update Profile Successfully')
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
    // echo user
    $id = $_SESSION['user']['id']; 
    $select_user = "SELECT * FROM users
                    WHERE id = '$id'
                   ";
    $select_user_query = mysqli_query($connect,$select_user);
    $row = mysqli_fetch_assoc($select_user_query);
?>
<!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">User Profile</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">User Profile</p>
            </div>
        </div>
    </div>
 <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">User Profile</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="contact-form col-12">
                <div id="success"></div>
                <form action="userprofile.php" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="control-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                                required="required" value="<?php echo $_POST['name'] ?? $row['name']; ?>"  required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email"
                                required="required" value="<?php echo $_POST['email'] ?? $row['email']; ?>"  required/>
                            </div>
                        </div>
                    </div>
                    <div class="control-group mb-3">
                        <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number"
                        required="required" value="<?php echo $_POST['phone_number'] ?? $row['phone_number']; ?>" required/>
                    </div>
                    <div class="control-group mb-3">
                        <textarea class="form-control" rows="6" name="address" id="address" placeholder="Address"
                        required="required" required><?php echo $_POST['address'] ?? $row['address']; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <button class="btn btn-primary py-2 px-4" type="submit"  name="btnSubmit" id="sendMessageButton">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Contact End -->
<?php 
    include_once('footer.php');
?>
