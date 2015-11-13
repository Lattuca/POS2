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
do_html_heading("Delete Customer");

include "customer_sidebar.php";

if (!isset($_POST['submit']))
{
  $customerid =$_GET['id'];

try
  {
    //open the database and find product
    $db = db_connect();

    #get user to delete

    $query = "SELECT * from customers WHERE customers.customerid = '$customerid'";
    #$result = $db->query($query)->fetch(PDO::FETCH_ASSOC);
    $result = $db->query($query);
    if (!$result) {
         die($result->error);
    }
    $customer = $result->fetch_assoc();
    display_customer_delete_form($customer['customerid'], $customer['name'], $customer['address'],
                                 $customer['city'], $customer['state'],
                                 $customer['zip'], $customer['country']);
    }
    catch(PDOException $e)
    {
      echo 'Exception : '.$e->getMessage();
      echo "<br/>";
      $db = NULL;
    }
  }


  do_html_footer();

  ?>
