<?php
 require_once('POS_fns.php');
 require_once('POS_admin_header.php');
 #session_start();
 #do_html_header("Carmelo POS System");

 html_head("Carmelo POS System");

 session_start();
 $_SESSION['logged_in']=0;
 display_login_form();

 do_html_footer();
?>
