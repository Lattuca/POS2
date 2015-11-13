<?php

// include function files for this application
require_once('POS_fns.php');

session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Add a category");
require_once("category_sidebar.php");

display_category_form();
do_html_footer();

?>
