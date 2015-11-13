<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}

require_once('POS_admin_header.php');
do_html_heading("Add Product");

require("product_sidebar.php");

if (check_admin_user()) {
  display_product_form();
  #do_html_url("manage_products.php", "Back to manage product menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
