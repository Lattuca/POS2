<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}
do_html_header("Edit category");
if (check_admin_user()) {
  if ($catname = get_category_name($_GET['catid'])) {
    $catid = $_GET['catid'];
    $cat = compact('catname', 'catid');
    display_category_form($cat);
  } else {
    echo "<p>Could not retrieve category details.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
