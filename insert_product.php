<?php

// include function files for this application
require_once('POS_fns.php');
session_start();

do_html_header("Adding a product");
if (check_admin_user()) {
  if (filled_out($_POST)) {
    $product_upc = $_POST['product_upc'];
    $product_desc = $_POST['product_desc'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $cost = $_POST['cost']
    $catid = $_POST['catid'];
    $available = $_POST['available'];
    $product_notes = $_POST['product_notes'];


    if(insert_product($product_upc, $product_desc, $quantity, $price, $cost,$catid, $availble, $product_notes)) {
      echo "<p>product <em>".stripslashes($prduct_upc)."</em> was added to the database.</p>";
    } else {
      echo "<p>product <em>".stripslashes($product_upc)."</em> could not be added to the database.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }

  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>
