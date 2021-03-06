<?php

// include function files for this application
require_once('POS_fns.php');
require_once('POS_admin_header.php');
do_html_heading("Adding a category");
require_once("category_sidebar.php");
session_start();
if (we_are_not_logged_in()){
  exit;
}
if (check_admin_user()) {
  if (filled_out($_POST))   {
    $catname = $_POST['catname'];
    if(insert_category($catname)) {
      echo "<p>Category \"".$catname."\" was added to the database.</p><hr />";
    } else {
      echo "<p>Category \"".$catname."\" could not be added to the database.</p><hr />";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p><hr />";
  }
  #do_html_url('admin.php', 'Back to administration menu');
} else {
  echo "<p>You are not authorised to view this page.</p><hr />";
}

do_html_footer();

?>
