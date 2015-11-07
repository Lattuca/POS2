<?php
 require_once('POS_fns.php');

 #session_start();
 #do_html_header("Add User");
 require_once('POS_admin_header.php');
 do_html_heading("Add User");

 require ("user_sidebar.php");

 display_registration_form("add_user");

 do_html_footer();
?>
