<?php
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  display_button("POS_login.php","log-in","Log In");
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("New Customer");

include "customer_sidebar.php";

echo "<p>New customers are entered at time of purchase.</p><hr />";


do_html_footer();
?>
