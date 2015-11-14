<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
if (we_are_not_logged_in()){
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Adding a product");
require_once('product_sidebar.php');

if (check_admin_user()) {
  #if (filled_out($_POST)) {
    $product_upc = $_POST['product_upc'];
    $oldproduct_upc = "~xyz~"; # set up a dummy product
    $product_desc = $_POST['product_desc'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];
    $catid = $_POST['catid'];
    #$available = $_POST['available'];
    $product_notes = $_POST['product_notes'];


    # After submit find value of checbox for database: 1=checked, 0=unchecked

    if (isset($_POST['available'])) {
      $available = 1;}
    else {
      $available = 0;
    }


    # Validate Product data
    $errors = validate_product($oldproduct_upc, $product_upc, $product_desc, $quantity, $price, $cost);
    if (empty($errors)) {
      if(insert_product($product_upc, $product_desc, $quantity, $price, $cost, $catid, $available, $product_notes)) {
        echo "<p>product <em>".stripslashes($product_upc)."</em> was added to the database.</p><hr />";
        #do_html_URL("manage_products.php", "Product list");
      } else {
        echo "<p>product <em>".stripslashes($product_upc)."</em> could not be added to the database.</p><hr />";
     }
   }else{
     echo "Errors found in product entry:<br/>";
     echo "Product UPC: $product_upc<br/>";
     echo "Product Description: $product_desc<br/>";
     echo "Quantity: $quantity<br/>";
     echo "Price: $price<br/>";
     echo "Cost: $cost<br/>";
     foreach($errors as $error) {
       echo $error."<br/>";
     }
     echo "<br/><br/>";
     try_again("Error on product form.");
    }
  /*} else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
    try_again("<p>You have not filled out the form.  Please try again.</p>");
  }*/

  #do_html_url("admin.php", "Back to administration menu");

} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>
