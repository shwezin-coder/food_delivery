<?php 
    include_once('header.php');
    if(!isset($_SESSION['user']))
    {
        echo "<script>
                alert('You need to login first.')
                window.location.assign('signin.php')
              </script>
            ";
    }
    else
    {
        $select_cart_data = "SELECT * FROM shopping_carts
                            WHERE status = 0 AND user_id = '$user_id'
                            ";
        $select_cart_data_query = mysqli_query($connect,$select_cart_data);
        $count_cart = mysqli_num_rows($select_cart_data_query);
    }
?>
    
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Menus</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php 
                            $subtotal = 0;
                            $shipping_fees = 2000;
                            if($count_cart > 0)
                            {
                                for ($i=0; $i < $count_cart; $i++) { 
                                    $row_cart = mysqli_fetch_assoc($select_cart_data_query);
                                    $target_dir = "storage/menus/";
                                    $subtotal = $subtotal + ($row_cart['price'] * $row_cart['quantity']);
                        ?>
                                <tr>
                                    <td class="align-middle"><img src="<?php echo $target_dir.$row_cart['image'];  ?>" alt="<?php echo $row_cart['image']; ?>" style="width: 50px;"><br /><?php echo $row_cart['menu_name']; ?></td>
                                    <td class="align-middle"><?php echo $row_cart['category_name']; ?></td>
                                    <td class="align-middle price" data-price=<?php echo $row_cart['price']; ?>><?php echo $row_cart['price']; ?> MMK</td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus btn-cart" data-size="decrease" data-cart-id=<?php echo $row_cart['id'];?> data-noofquantity=<?php echo $row_cart['quantity']; ?>>
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary text-center noofquantity" value="<?php echo $row_cart['quantity']; ?>">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus btn-cart" data-size="increase" data-cart-id=<?php echo $row_cart['id'];?> data-noofquantity=<?php echo $row_cart['quantity']; ?>>
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle totalprice"><?php echo $row_cart['price'] * $row_cart['quantity']; ?> MMK</td>
                                    <td class="align-middle"><button class="btn btn-sm btn-primary removebtn" data-cart-id=<?php echo $row_cart['id'];?>><i class="fa fa-times"></i></button></td>
                                </tr>
                        <?php
                               
                            }
                        }
                        else
                        {
                            $shipping_fees = 0;
                        ?>
                            <tr>
                                <td colspan=7>
                                    Cart is Empty. <br />
                                    <a href="menu_list.php" class="btn btn-primary">Go to Shop</a>
                                </td>
                            </tr>
                        <?php 
                        }
                            $grandtotal = $shipping_fees + $subtotal;
                        ?>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium"><?php echo $subtotal; ?> MMK</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium"><?php echo $shipping_fees; ?> MMK</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold"><?php echo $grandtotal; ?> MMK</h5>
                        </div>
                        <a href="checkout.php" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
<?php 
    include_once('footer.php');
?>
<script>
    $('.btn-cart').click(function (){
        if($(this).attr('data-size') == "increase")
        {
            var noofquantity = parseInt($(this).attr('data-noofquantity')) + 1;
        }
        else
        {
            var noofquantity = parseInt($(this).attr('data-noofquantity')) - 1;
        }
        var price = $('.price').attr('data-price');
        var totalprice = noofquantity * price;
        var cart_id = $(this).attr('data-cart-id');
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: { cart_id:cart_id,quantity:noofquantity,function:'updatecart'},
            dataType: 'json',
            success: function(response) {
             // window onload
                location.reload();
            }
        });
        $('.totalprice').html(totalprice + 'MMK');
    });
    $('.removebtn').click(function (){
        var cart_id = $(this).attr('data-cart-id');
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            data: { cart_id:cart_id,function:'removefromcart'},
            dataType: 'json',
            success: function(response) {
             // window onload
                location.reload();
            }
        });
    });
</script>