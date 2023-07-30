<?php 
include_once('function.php');
if(isset($_SESSION['user']))
{
    $user_id = $_SESSION['user']['id'];
    // count shopping cart 
    $select_cart = "SELECT SUM(quantity) AS totalitems FROM shopping_carts
                    WHERE status = 0 AND user_id = '$user_id'
                    ";
    $select_cart_query = mysqli_query($connect,$select_cart);
    $cart_data = mysqli_fetch_assoc($select_cart_query);
    $_SESSION['totalitems'] = $cart_data['totalitems'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Food Delivery</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-9 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <a href="cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <?php 
                        if(isset($_SESSION['totalitems']))
                        {
                    ?>
                         <span class="badge" id="cart-data"><?php echo $_SESSION['totalitems']; ?></span>
                    <?php
                        }
                        else 
                        {
                    
                    ?>
                         <span class="badge" id="cart-data">0</span>
                    <?php 
                        }
                    ?>
                   
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <?php 
                                if(isset($_SESSION['user']))
                                {
                            ?>
                                <a href="userprofile.php" class="nav-item nav-link">User Profile</a>
                                <div class="nav-item dropdown mobile-dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Settings</a>
                                <div class="dropdown-menu rounded-0 m-0  text-center" style="margin-left:-100px !important;">
                                    <a href="changepassword.php" class="dropdown-item">Change password</a>
                              
                            <?php
                                if($_SESSION['user']['role'] == 1)
                                {
                            ?>
                                    <a href="admin/dashboard.php" class="dropdown-item">Go to Dashboard</a>
                            <?php
                                }
                            ?>
                                      <a href="logout.php" class="dropdown-item">Log Out</a>
                                </div>
                            </div>
                            <?php
                                }
                                else
                                {
                            ?>
                            <a href="signin.php" class="nav-item nav-link">Login</a>
                            <a href="signup.php" class="nav-item nav-link">Register</a>
                            <?php                   
                                }
                            ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->
