<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Deleting category");
require_once("category_sidebar.php");

  if (filled_out($_POST)) {
    if(update_category($_POST['catid'], $_POST['catname'])) {
      echo "<p>Category was updated.</p><hr />";
    } else {
      echo "<p>Category could not be updated.</p><hr />";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p><hr />";
  }
do_html_footer();

?>
