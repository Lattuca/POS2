<?php
 require_once('POS_fns.php');
 session_start();
 do_html_header("Carmelo POS System");

 display_login_form();

 do_html_footer();
?>
