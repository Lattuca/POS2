<?php

// include function files for this application
require_once('POS_fns.php');
require_once('POS_admin_header.php');


session_start();

  if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
  }
  show_user_details($_SESSION['username']);

  #echo "<h3> User: $username;

 if ($_SESSION['logged_in'] == 1){
  display_admin_menu();
  do_html_footer();
}else{
  if (($_POST['username']) && ($_POST['passwd'])) {
	// they have just tried logging in

    $username = $_POST['username'];
    $passwd = $_POST['passwd'];

    if (login($username, $passwd)) {
      // if they are in the database register the user id
       $_SESSION['logged_in'] = 1;
       display_admin_menu();
       do_html_footer();
   } else {
      // unsuccessful login
      echo "<p>Invalid username or password entered.<br/></p>";
      #do_html_url('POS_login.php', 'Login');
      show_login_button();
      do_html_footer();
      exit;
    }
  }else{
  # Blank username or password entered
    echo "<p>You must enter a username and password to login.<br/></p>";
    show_login_button();
    #do_html_url('POS_login.php', 'Login');
    do_html_footer();
 }
}

?>
