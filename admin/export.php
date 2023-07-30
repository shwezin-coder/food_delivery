<?php 
// Load the database configuration file 
$connect = mysqli_connect('localhost','root','','food_deliverydb');
 
// Excel file name for download 
$filename = "payment-data_" . date('Y-m-d') . ".csv"; 
$delimiter = ","; 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
$fields = array('ID', 'Customer Name', 'Payment Type', 'Transaction No', 'Amount','ORDER INFORMATION'); 
fputcsv($f, $fields, $delimiter); 
 // select user without deleting their account by admin and not admin role
 $select_payment = "SELECT * FROM payments p, payment_types pt, orders o, users u
                    WHERE pt.id = p.paymenttype_id AND o.id = p.order_id AND o.customer_id = u.id
                    ORDER BY p.id DESC";
$select_payment_query = mysqli_query($connect,$select_payment);
$count_payment = mysqli_num_rows($select_payment_query);
if($count_payment > 0){ 
// Output each row of the data  
for ($i=1; $i <= $count_payment; $i++) { 
$row_payment = mysqli_fetch_assoc($select_payment_query);
$name = $row_payment['name'];
$type = $row_payment['type'];
$transaction_no = $row_payment['transaction_no'];
$amount = $row_payment['amount'];
$order_informations = json_decode($row_payment['order_information']);
$order_data = "";
foreach ($order_informations as $order_information) 
{
$order_data .=  "Menu Name: " .$order_information->menu_name ." Quantity: ". $order_information->quantity . " Price: " .$order_information->price ."MMK Total: ". $order_information->total ."MMK";
}
$lineData = array($i, $name, $type, $transaction_no, $amount, $order_data);
fputcsv($f, $lineData, $delimiter); 
}
fseek($f, 0); 
     
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 
}
exit; 