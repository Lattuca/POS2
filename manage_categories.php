<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Currrent Category List");
include('category_sidebar.php');

try {
  #open database

  $db= db_pdo_open()

?>

  <table border=4  CELLSPACING=0 CELLPADDING=0>
    <tr>
      <td BGCOLOR="#C0C0C0", align="center">Category Id</td>
      <td BGCOLOR="#C0C0C0", align="center">Name</td>
      <td BGCOLOR="#C0C0C0", align="center">Last Update</td>
      <td BGCOLOR="#C0C0C0", align="center" colspan="2">Select Options</td>
    </tr>

<?php

$query = "SELECT * from categories";
$result = $db->query($query);
foreach($result as $row) {
   $category = get_category_name($row['catid']);
   print "<tr>";
   print '<td align="left">'.$row['catid']."</td>";
   print "<td>".$row['catname']."</td>";
   print '<td align="center">'.$row['last_update']."</td>";
   print "<td align='center'><a href='edit_category_form.php?id=" . $row['catid']  . "'>edit</a></td>";
   print "<td align='center'><a href='delete_category.php?id=" . $row['catid'] . "'>delete</a></td>";

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
