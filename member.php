<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');

session_start();
if (we_are_not_logged_in()){
  exit;
}
//create short variable names

$username = $_POST['username'];
$passwd = $_POST['passwd'];

if ($username && $passwd) {
// they have just tried logging in
  try  {
    login($username, $passwd);
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $username;
  }
  catch(Exception $e)  {
    // unsuccessful login
    do_html_header('Problem:');
    echo 'You could not be logged in.
          You must be logged in to view this page.';
    do_html_url('login.php', 'Login');
    do_html_footer();
    exit;
  }
}

do_html_header('Home');
check_valid_user();
// get the bookmarks this user has saved
#if ($url_array = get_user_urls($_SESSION['valid_user'])) {
#  display_user_urls($url_array);
#}

// give menu of options
display_user_menu();

do_html_footer();
?>
