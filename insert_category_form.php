<?php

// include function files for this application
require_once('POS_fns.php');
require_once('POS_admin_header.php');
do_html_heading("Add a category");
require_once("admin_sidebar.php");
session_start();

#do_html_header("Add a category");
if (check_admin_user()) {
  display_category_form();
  
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
