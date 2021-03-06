<?php

// include function files for this application
require_once('POS_fns.php');

session_start();
if (we_are_not_logged_in()){
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Deleting category");
require_once("category_sidebar.php");

$catid = $_GET['id'];
if (isset($_GET['id'])) {
  if(delete_category($_GET['id'])) {
    echo "<p>Category was deleted.</p><hr />";
    } else {
      echo "<p>Category could not be deleted.<br />
            This is usually because it is not empty.</p><hr />";
    }
 } else {
    echo "<p>No category specified.  Please try again.</p><hr />";
  }
do_html_footer();

?>
