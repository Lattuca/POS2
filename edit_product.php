<?php

// include function files for this application
require_once('POS_fns.php');

session_start();

do_html_header("Updating Product");
require_once('product_sidebar.php');
if (check_admin_user()) {
    $oldproduct_upc = $_POST['oldproduct_upc'];
    $product_upc = $_POST['product_upc'];
    $product_desc = $_POST['product_desc'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $cost = $_POST['cost'];
    $catid = $_POST['catid'];

    # After submit find value of checbox for database: 1=checked, 0=unchecked

    if (isset($_POST['available'])) {
      $available = 1;}
    else {
      $available = 0;
    }
    $product_notes = $_POST['product_notes'];
    # Validate Product data
    $errors = validate_product($oldproduct_upc, $product_upc, $product_desc, $quantity, $price, $cost);
    if (empty($errors)) {
      if(update_product($oldproduct_upc, $product_upc, $product_desc, $quantity, $price, $cost, $catid, $available, $product_notes)) {
        echo "<p>Product was updated.</p>";
      } else {
        echo "<p>Product could not be updated.</p>";
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
  #} else {
  #  echo "<p>You have not filled out the form.  Please try again.</p>";
  #}
  #do_html_url("manage_products.php", "Back to product list");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>
