<?php

// include function files for this application
require_once('POS_fns.php');


session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}

#do_html_header("Edit product details");
require_once('POS_admin_header.php');
do_html_heading("Edit Product");

require_once("product_sidebar.php");
if (check_admin_user()) {
  if ($product = get_product_details($_GET['id'])) {
    display_product_form($product);
  } else {
    echo "<p>Could not retrieve product details.</p>";
  }
  #do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
