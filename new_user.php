<?php
 require_once('POS_fns.php');

 session_start();
 if (we_are_not_logged_in()){
   exit;
 }
 require_once('POS_admin_header.php');
 do_html_heading("Add User");

 require ("user_sidebar.php");

 display_registration_form("add_user");

 do_html_footer();
?>
