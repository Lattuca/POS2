<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
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
  echo "<p>You were not logged in.</p>";
  #do_html_url("POS_login.php", "Login");

  echo '<form method="post" action="POS_login.php">';
  echo '<tr> <td colspan="2" align="center">
    <input type="submit" value="Log in"/></td></tr>';
}

do_html_footer();

?>
