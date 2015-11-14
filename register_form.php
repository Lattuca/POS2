<?php
 require_once('POS_fns.php');
 do_html_header('User Registration');
session_start();
if (we_are_not_logged_in()){
    exit;
}

 display_registration_form("register");

 do_html_footer();
?>
