<?php

// include function files for this application
require_once('POS_fns.php');
session_start();

do_html_header("Deleting Product");
if (check_admin_user()) {
  if (isset($_POST['product_upc'])) {
    $product_upc = $_POST['product_upc'];
    if(delete_product($product_upc)) {
      echo "<p>Product ".$product_upc." was deleted.</p>";
    } else {
      echo "<p>Product ".$product_upc." could not be deleted.</p>";
    }
  } else {
    echo "<p>We need an Product UPC to delete a Product.  Please try again.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>
