<?php
 require_once('POS_fns.php');

 session_start();
 do_html_header("Add User");

 display_registration_form();
 require ("user_sidebar.php");
 do_html_footer();
?>
