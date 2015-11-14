<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Current customer List");

include('customer_sidebar.php');

try {
  #$db = db_connect();
  $db= db_pdo_open()
?>

  <table border=4  CELLSPACING=0 CELLPADDING=0>
    <tr>
      <td BGCOLOR="#C0C0C0", align="center">Customer #</td>
      <td BGCOLOR="#C0C0C0", align="center">Name</td>
      <td BGCOLOR="#C0C0C0", align="center">Address</td>
      <td BGCOLOR="#C0C0C0", align="center">City</td>
      <td BGCOLOR="#C0C0C0", align="center">State</td>
      <td BGCOLOR="#C0C0C0", align="center">ZIP</td>
      <td BGCOLOR="#C0C0C0", align="center">country</td>
      <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
      <td BGCOLOR="#C0C0C0", align="center" colspan="2">Select Options</td>
    </tr>

<?php

$query = "SELECT * from customers";
$result = $db->query($query);
foreach($result as $row) {
   print "<tr>";
   print '<td align="left">'.$row['customerid']."</td>";
   print '<td align="left">'.$row['name']."</td>";
   print "<td>".$row['address']."</td>";
   print '<td align="left">'.$row['city']."</td>";
   print '<td align="left">'.$row['state']."</td>";
   print '<td align="left">'.$row['zip']."</td>";
   print '<td align="left">'.$row['country']."</td>";
   print '<td align="center">'.$row['last_update']."</td>";
   print "<td align='center'><a href='pos_cust_update.php?id=" . $row['customerid']  . "'>edit</a></td>";
   print "<td align='center'><a href='pos_cust_delete.php?id=" . $row['customerid'] . "'>delete</a></td>";
   }
 print "</table>";



 // close the database connection
 $db = NULL;

} catch (PDOException $e) {
  echo 'Exception : '.$e->getMessage();
  echo "<br/>";
  $db = NULL;

}


//create short variable names

do_html_footer();
?>
