<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Edit Customer Details");

include "customer_sidebar.php";
require_once('state_drop_down.php');

# Get the Users by user id
if (!isset($_POST['submit']))
{
  $customerid =$_GET['id'];
  #echo "customer record id is: $customerid</br>";
try
  {
    //open the database and find product
    $db = db_connect();

    // get user to update

    $query = "SELECT * from customers WHERE customers.customerid = $customerid";
    #echo "customer select $query";

    $result = $db->query($query);
    $customer = $result->fetch_assoc();
    $custname = $customer['name'];

    #echo "customer name  is $custname";

    display_customer_update_form($customer['customerid'], $customer['name'], $customer['address'],
                                 $customer['city'], $customer['state'],
                                 $customer['zip'], $customer['country']);
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }
  #display user update form and get updates
}


do_html_footer();

?>
