<?php

// include function files for this application
require_once('POS_fns.php');
require_once('POS_admin_header.php');


session_start();
 $username = $_POST['username'];
 echo "logging in...$username";

if (($_POST['username']) && ($_POST['passwd'])) {
	// they have just tried logging in

    $username = $_POST['username'];
    $passwd = $_POST['passwd'];

    if (login($username, $passwd)) {
      // if they are in the database register the user id

       display_admin_menu();
       do_html_footer();
   } else {
      // unsuccessful login
      echo "<p>Invalid username or password entered.<br/></p>";
      do_html_url('POS_login.php', 'Login');
      do_html_footer();
      exit;
    }
}else{
  # Blank username or password entered
  echo "<p>You must enter a username and password to login.<br/></p>";
  do_html_url('POS_login.php', 'Login');
  do_html_footer();
}
?>
