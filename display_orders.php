<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("List of Sale Orders");
include('admin_sidebar.php');

try {
  #$db = db_connect();

  #open database

  $db= db_pdo_open()

?>

  <table border=4  CELLSPACING=0 CELLPADDING=0>
    <tr>
      <td BGCOLOR="#C0C0C0", align="center">Order id</td>
      <td BGCOLOR="#C0C0C0", align="center">Customer</td>
      <td BGCOLOR="#C0C0C0", align="center">Amount</td>
      <td BGCOLOR="#C0C0C0", align="center">Date</td>
      <td BGCOLOR="#C0C0C0", align="center">Order Status</td>
      <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
    </tr>

<?php

$query = "SELECT * from orders";
$result = $db->query($query);
foreach($result as $row) {
   $customer = get_customer_name($row['customerid']);
   print "<tr>";
   print '<td align="left">'.$row['orderid']."</td>";
   print "<td>$customer</td>";
   print '<td align="center">'.$row['amount']."</td>";
   print '<td align="center">'.$row['date']."</td>";
   print '<td align="center">'.$row['order_status']."</td>";
   print '<td align="center">'.$row['last_update']."</td>";
      }
 print "</table>";

 // close the database connection
 $db = NULL;

} catch (PDOException $e) {
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;

}

do_html_footer();
?>
