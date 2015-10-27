<?php

// include function files for this application
require_once('POS_fns.php');
session_start();

do_html_header("Add a Product");
if (check_admin_user()) {
  display_product_form();
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>