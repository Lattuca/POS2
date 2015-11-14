<?php
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}

require_once('POS_admin_header.php');
do_html_heading("Delete Customer from database");
include "customer_sidebar.php";

# Code for your web page follows
# Point Of Sale Project

if (!isset($_POST['submit']))
{
  $customerid =$_GET['id'];

  try
  {
    //open the database

    $db = db_connect();

    $query = "DELETE FROM customers WHERE customers.customerid = '$customerid'";
    #echo "delete query $query <br>";
    $result = $db->query($query);
    if (!$result) {
      throw new Exception('Could not delete you in database - please try again later.');
    }
    echo "<p>Customer successfully deleted.</p><hr />";

  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }

}
?>
