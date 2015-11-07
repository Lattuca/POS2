<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
#session_start();
#do_html_header("Current Product List");
require_once('POS_admin_header.php');
do_html_heading("Currrent Product List");
include('product_sidebar.php');

try {
  $db = db_connect();
?>

  <table border=4  CELLSPACING=0 CELLPADDING=0>
    <tr>
      <td BGCOLOR="#C0C0C0", align="center">Product UPC</td>
      <td BGCOLOR="#C0C0C0", align="center">Description</td>
      <td BGCOLOR="#C0C0C0", align="center">Quantity</td>
      <td BGCOLOR="#C0C0C0", align="center">Price</td>
      <td BGCOLOR="#C0C0C0", align="center">Cost</td>
      <td BGCOLOR="#C0C0C0", align="center">Category</td>
      <td BGCOLOR="#C0C0C0", align="center">Available</td>
      <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
      <td BGCOLOR="#C0C0C0", align="center" colspan="2">Select Options</td>
    </tr>

<?php

$query = "SELECT * from products";
$result = $db->query($query);
foreach($result as $row) {
   print "<tr>";
   print '<td align="left">'.$row['product_upc']."</td>";
   print "<td>".$row['product_desc']."</td>";
   print '<td align="center">'.$row['quantity']."</td>";
   print '<td align="center">'.$row['price']."</td>";
   print '<td align="center">'.$row['cost']."</td>";
   print '<td align="center">'.$row['catid']."</td>";
   print '<td align="center">'.$row['available']."</td>";
   print '<td align="center">'.$row['last_update']."</td>";
   print "<td align='center'><a href='edit_product_form.php?id=" . $row['product_upc']  . "'>edit</a></td>";
   print "<td align='center'><a href='delete_product.php?id=" . $row['product_upc'] . "'>delete</a></td>";

   }
 print "</table>";



 // close the database connection
 $db = NULL;

} catch (Exception $e) {
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;

}


//create short variable names

do_html_footer();
?>
