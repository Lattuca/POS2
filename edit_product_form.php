<?php

// include function files for this application
require_once('POS_fns.php');
session_start();

do_html_header("Edit product details");
if (check_admin_user()) {
  if ($product = get_product_details($_GET['product_upc'])) {
    display_product_form($product_upc);
  } else {
    echo "<p>Could not retrieve product details.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
