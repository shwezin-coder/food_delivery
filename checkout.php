<?php 
    include_once('header.php');
    $user_id = $_SESSION['user']['id'];
    if(isset($_POST['btnsubmit']))
    {
        if(!isset($_POST['delivery_id']))
        {
            echo "<script>
                    alert('We can\'t deliver your order now')
                    window.location.assign('checkout.php')
                </script>";
        }
        $delivered_address = $_POST['delivered_address'];
        $transaction_no = $_POST['transaction_no'];
        $special_note = $_POST['special_note'];
        $payment_type = $_POST['payment_type'];
        $customer_id = $_POST['customer_id'];
        $delivery_id = $_POST['delivery_id'];
        $order_informations = json_encode($_POST['order_information']);
        foreach($_POST['order_information'] as $order_information)
        {
            $cart_id = $order_information['id'];
            $update = "UPDATE shopping_carts SET
                       status = 1
                       WHERE id = '$cart_id'
                      ";
            $update_query = mysqli_query($connect,$update);
        }
        $insert = "INSERT INTO orders(`customer_id`,`delivery_id`, `order_information`, `delivered_address`, `special_note`)
                   VALUES('$customer_id','$delivery_id','$order_informations','$delivered_address','$special_note')";
        $insert_query = mysqli_query($connect,$insert);
        $order_id = mysqli_insert_id($connect);
        if($insert_query)
        {
            $total= $_POST['total'];
            $insert_delivery = "INSERT INTO payments(`order_id`,`paymenttype_id`, `transaction_no`,`amount`) 
                                VALUES('$order_id','$payment_type','$transaction_no','$total')
                               ";
            $insert_delivery_query = mysqli_query($connect,$insert_delivery);
            if($insert_delivery_query)
            {
                echo "<script>
                    alert('Checkout Successfully');
                    window.location.assign('index.php')
                  </script>
                 ";
            }
        }
        else
        {
            echo "<script>
                    alert('Something Wrong');
                    window.location.assign('checkout.php')
                  </script>
                 ";
        }
    }
?>

<form action="checkout.php" method="POST">
    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Check Out</h4>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="delivered_address">New Address</label>
                            <textarea class="form-control" name="delivered_address" id="delivered_address" cols="30" rows="10" placeholder="New Address"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="special_note">Special Note</label>
                            <textarea class="form-control" name="special_note" id="special_note" cols="30" rows="10" placeholder="Special Note"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="payment_type">Payment Type</label>
                            <select class="custom-select" name="payment_type" id="payment_type">
                                <?php 
                                    $select_payment_types = "SELECT * FROM payment_types 
                                                             WHERE deleted_at = 0
                                                            ";
                                    $select_payment_types_query = mysqli_query($connect,$select_payment_types);
                                    $count_payment_types = mysqli_num_rows($select_payment_types_query);
                                    for($i = 0; $i < $count_payment_types; $i++)
                                    {
                                        $row_payment = mysqli_fetch_assoc($select_payment_types_query);
                                ?>  
                                        <option value="<?php echo $row_payment['id']; ?>"><?php echo $row_payment['type']; ?> </option>
                                <?php 
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Transaction No</label>
                            <input class="form-control" name="transaction_no" type="text" placeholder="Transaction No">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="location">Location</label>
                            <select name="location" class="form-control" id="location">
                                <option value="">Choose Location</option>
                                <?php 
                                    $select_locations = "SELECT * FROM locations
                                                         WHERE deleted_at = 0
                                                        ";
                                    $select_locations_query = mysqli_query($connect,$select_locations);
                                    $count_locations = mysqli_num_rows($select_locations_query);
                                    for ($l=0; $l < $count_locations ; $l++) { 
                                        $row_locations = mysqli_fetch_assoc($select_locations_query);
                                ?>
                                    <option value="<?php echo $row_locations['id'] .','. $row_locations['fees'].",". $row_locations['duration']; ?>"><?php echo $row_locations['location_range']; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <?php 
                            $select_cart = "SELECT * FROM shopping_carts
                                            WHERE status = 0 AND user_id = '$user_id'
                                           ";
                            $select_cart_query = mysqli_query($connect,$select_cart);
                            $select_cart_count = mysqli_num_rows($select_cart_query);
                            $total = 0;
                            $orderinformation = array();
                            for($i=0; $i < $select_cart_count; $i++)
                            {
                                $row_cart = mysqli_fetch_assoc($select_cart_query);
                                $cart_total = $row_cart['quantity'] * $row_cart['price'];
                                $total = $total + ($row_cart['price'] * $row_cart['quantity']);
                        ?>
                                <input type="hidden" name="order_information[<?php echo $i; ?>][id]" value="<?php echo $row_cart['id']; ?>">
                                <input type="hidden" name="order_information[<?php echo $i; ?>][menu_name]" value="<?php echo $row_cart['menu_name']; ?>">
                                <input type="hidden" name="order_information[<?php echo $i; ?>][quantity]" value="<?php echo $row_cart['quantity']; ?>">
                                <input type="hidden" name="order_information[<?php echo $i; ?>][price]" value="<?php echo $row_cart['price']; ?>">
                                <input type="hidden" name="order_information[<?php echo $i; ?>][total]" value="<?php echo $cart_total; ?>">
                                <div class="d-flex justify-content-between">
                                    <p><?php echo $row_cart['menu_name']; ?>(<?php echo $row_cart['quantity']; ?>)</p>
                                    <p><?php echo $row_cart['quantity'] * $row_cart['price']; ?> MMK</p>
                                </div>
                        <?php 
                            }
                        ?>
                        <hr class="mt-0">
                        <h5 class="font-weight-medium mb-3">Delivery Information</h5>
                        <div class="d-flex justify-content-between">
                            <p>Estimated Time</p>
                            <p id="estimated_time">0 hour</p>
                        </div>
                        <?php 
                            $select_delivery = "SELECT * FROM users
                                                WHERE deleted_at = 0 AND role = 4 AND delivery_status = 0
                                                ORDER BY id DESC
                                               ";
                            $select_delivery_query = mysqli_query($connect,$select_delivery);
                            $select_delivery_count = mysqli_num_rows($select_delivery_query);
                            if($select_delivery_count > 0)
                            {
                                $row_delivery = mysqli_fetch_assoc($select_delivery_query);
                        ?>
                                <div class="d-flex justify-content-between">
                                    <p>Name</p>
                                    <p><?php echo $row_delivery['name']; ?></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Phone No</p>
                                    <p><?php echo $row_delivery['phone_number']; ?></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Email</p>
                                    <p><?php echo $row_delivery['email']; ?></p>
                                </div>
                                <input type="hidden" name="delivery_id" value="<?php echo $row_delivery['id']; ?>">
                                <input type="hidden" name="total" id="total" value="<?php echo $total; ?>">
                        <?php
                            }
                            if(isset($_SESSION['user']))
                            {
                        ?>
                                <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $_SESSION['user']['id']; ?>">
                        <?php
                            }
                        ?>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium"><?php echo $total; ?> MMK</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery Fees</h6>
                            <h6 class="font-weight-medium" id="delivery_fees"> 0 MMK</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="grand_total"><?php echo $total; ?> MMK</h5>
                        </div>
                    </div>
                    <input type="hidden" name="total" value="<?php echo $total; ?>">
                    <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" name="btnsubmit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3"> Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
</form>
<?php 
    include_once('footer.php');
?>
<script>
    $('#location').on("change",function(){
        var location = $(this).val();
        var total = $('#total').val();
        var location_arr = location.split(",");
        var grand_total = parseInt(total) + parseInt(location_arr[1]);
        $('#delivery_fees').html(location_arr[1] + "MMK");
        $('#estimated_time').html(location_arr[2]);
        $('#grand_total').html(grand_total + "MMK");
    });
</script>