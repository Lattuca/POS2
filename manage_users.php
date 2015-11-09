<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
#session_start();
#do_html_header("Current User List");
require_once('POS_admin_header.php');
do_html_heading("Current User List");

include('user_sidebar.php');

try {
  #$db = db_connect();
  $db= db_pdo_open()
?>

  <table border=4  CELLSPACING=0 CELLPADDING=0>
    <tr>
      <td BGCOLOR="#C0C0C0", align="center">Username</td>
      <td BGCOLOR="#C0C0C0", align="center">First</td>
      <td BGCOLOR="#C0C0C0", align="center">Last</td>
      <td BGCOLOR="#C0C0C0", align="center">Email</td>
      <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
      <td BGCOLOR="#C0C0C0", align="center" colspan="2">Select Options</td>
    </tr>

<?php

$query = "SELECT * from user Order BY last";
$result = $db->query($query);
foreach($result as $row) {
   print "<tr>";
   print '<td align="left">'.$row['username']."</td>";
   print "<td>".$row['first']."</td>";
   print '<td align="left">'.$row['last']."</td>";
   print '<td align="left">'.$row['email']."</td>";
   print '<td align="center">'.$row['last_update']."</td>";
   print "<td align='center'><a href='pos_usr_update.php?id=" . $row['username']  . "'>edit</a></td>";
   print "<td align='center'><a href='pos_usr_delete.php?id=" . $row['username'] . "'>delete</a></td>";
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
