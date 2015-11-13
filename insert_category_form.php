<?php

// include function files for this application
require_once('POS_fns.php');
require_once('POS_admin_header.php');
do_html_heading("Add a category");
require_once("admin_sidebar.php");
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}

if (check_admin_user()) {
  display_category_form();

} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
