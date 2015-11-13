<?php

  include ('POS_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  if (we_are_not_logged_in()){
    display_button("POS_login.php","log-in","Log In");
    exit;
  }
  header("Cache-Control: max-age=300, must-revalidate");
  require_once('POS_admin_header.php');
  do_html_heading("Customer Update");
  require_once('POS_admin_header.php');
  include "customer_sidebar.php";



  // create short variable names
  $customer_id =$_POST['customerid'];
  $name = $_POST['name'];
  $address = $_POST['address'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];
  $country = $_POST['country'];
  $state = $_POST['state'];


  // if filled out
  if (($name) && ($address) && ($city) && ($zip) && ($country)) {
    // update customer

    $conn = db_connect();

    // update customer address
    $query = "Update customers SET
              name = '".$name."',
              address = '".$address."',
              city = '".$city."',
              state = '".$state."',
              zip = '".$zip."',
              country = '".$country."' WHERE customerid = '".$customer_id."'";

      $result = $conn->query($query);
      if (!$result) {
        throw new Exception('Could not update you in database - please try again later.');
      }



  } else {
    #echo "<p>You did not fill in all the fields, please try again.</p><hr />";
    try_again ("<p>You did not fill in all the fields, please try again.</p><hr />");
    display_button('pos_cust_update.php', 'back', 'Back');
  }

  do_html_footer();
?>
