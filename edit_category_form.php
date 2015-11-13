<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}

#do_html_header("Edit category");
require_once('POS_admin_header.php');
do_html_heading("Currrent Category List");
include('category_sidebar.php');

if ($catname = get_category_name($_GET['id'])) {
    $catid = $_GET['id'];
    $cat = compact('catname', 'catid');
    display_category_form($cat);
  } else {
    echo "<p>Could not retrieve category details.</p>";
  }
do_html_footer();

?>
