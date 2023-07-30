<?php 
    include_once('header.php');
    // select payment without deleting 
    $select_payment = "SELECT * FROM payments p, payment_types pt, orders o, users u
                       WHERE pt.id = p.paymenttype_id AND o.id = p.order_id AND o.customer_id = u.id
                       ORDER BY p.id DESC";
    $select_payment_query = mysqli_query($connect,$select_payment);
    $count_payment = mysqli_num_rows($select_payment_query);
?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Payments  <a href="export.php" class="btn btn-primary" style="float:right !important;">Export</a></h4>
              </div>
              <div class="card-body">
                    <table class="table table-hover table-striped" id="payment-list">
                        <thead>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Payment Type</th>
                            <th>Transaction No </th>
                            <th>Amount</th>
                            <th>Order Information</th>
                        </thead>
                        <tbody>
                        <?php 
                            if($count_payment > 0)
                            {
                                for ($i=1; $i <= $count_payment; $i++) { 
                                    $row_payment = mysqli_fetch_assoc($select_payment_query);
                                    $order_information = json_decode($row_payment['order_information']);
                                ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_payment['name'];?></td>
                                <td><?php echo $row_payment['type']; ?></td>
                                <td><?php echo $row_payment['transaction_no']; ?></td>
                                <td><?php echo $row_payment['amount']; ?> MMK </td>
                                <td>
                                    <?php 
                                        foreach($order_information as $order_informations)
                                        {
                                    ?>
                                        <div class="row">
                                            <div class="col-md-5">Menu Name</div>
                                            <div class="col-md-1">-</div>
                                            <div class="col-md-5"><?php echo $order_informations->menu_name; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">Quantity</div>
                                            <div class="col-md-1">-</div>
                                            <div class="col-md-5"><?php echo $order_informations->quantity; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">Price</div>
                                            <div class="col-md-1">-</div>
                                            <div class="col-md-5"><?php echo $order_informations->price; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">Total</div>
                                            <div class="col-md-1">-</div>
                                            <div class="col-md-5"><?php echo $order_informations->total; ?></div>
                                        </div>
                                    <?php
                                        }
                                    ?>
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
<script>
        $(document).ready( function () {

            // datatable
            $('#payment-list').DataTable();

    });

</script>