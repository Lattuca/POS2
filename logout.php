<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
if (we_are_not_logged_in()){
  exit;
}
$old_user = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : NULL;
#$old_user = $_SESSION['admin_user'];  // store  to test if they *were* logged in
#unset($_SESSION['admin_user']);
unset($old_user);
session_destroy();

// start output html
#do_html_header("Logging Out");
require_once('POS_admin_header.php');
do_html_heading("Logging Out");



if (!empty($old_user)) {
  echo "<p>Logged out.</p>";
  do_html_url("POS_login.php", "Login");
} else {
  // if they weren't logged in but came to this page somehow
  echo "<p>You are not logged in.</p>";
  show_login_button();


}

do_html_footer();

?>
