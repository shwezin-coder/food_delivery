<?php 
    include_once('header.php');
    // select payment
    $select_delivery = "SELECT * FROM payments p, payment_types pt, orders o, users u
                       WHERE pt.id = p.paymenttype_id AND o.id = p.order_id AND o.customer_id = u.id
                       ORDER BY p.id DESC";
    $select_delivery_query = mysqli_query($connect,$select_delivery);
    $count_delivery = mysqli_num_rows($select_delivery_query);
?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                    <table class="table table-hover table-striped" id="payment-list">
                        <thead>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Delivery Name</th>
                            <th>Delivered Address</th>
                            <th>Order Status</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_delivery > 0)
                            {
                                for ($i=1; $i <= $count_delivery; $i++) { 
                                    $row_delivery = mysqli_fetch_assoc($select_delivery_query);
                                    $address = $row_delivery['delivered_address'];
                                    $delivery_id = $row_delivery['delivery_id'];
                                    $order_status = $row_delivery['order_status'];
                                    if($order_status == 0)
                                    {
                                        $delivery_status = "Waiting for delivery";
                                    }
                                    elseif($order_status == 1)
                                    {
                                        $delivery_status = "Pick up the order from delivery";
                                    }
                                    else
                                    {
                                        $delivery_status = "Already delivered";
                                    }
                                    if($address != "")
                                    {
                                        $delivery_address = $address;
                                    }
                                    else
                                    {
                                        $address = $row_delivery['address'];
                                    }
                                    // select delivery name
                                    $select_delivery_name = "SELECT * FROM users
                                                             WHERE id = '$delivery_id'
                                                            ";
                                    $select_delivery_name_query = mysqli_query($connect,$select_delivery_name);
                                    $row_delivery_name = mysqli_fetch_assoc($select_delivery_name_query);
                                    $delivery_name = $row_delivery_name['name'];

                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_delivery['name'];?></td>
                                <td><?php echo $row_delivery_name['name'];?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $delivery_status; ?></td>
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
<script>
        $(document).ready( function () {

            // datatable
            $('#payment-list').DataTable();

    });

</script>