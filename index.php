<?php
  include ('POS_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  if (we_are_not_logged_in()){
    display_button("POS_login.php","log-in","Log In");
    exit;
  }

  do_html_header("Welcome Carmelo's POS");

  if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
  }
  show_user_details($_SESSION['username']);

  echo "<h3>Please choose a category from list below:</h3>";

  // get categories out of database
  $cat_array = get_categories();

  // display as links to cat pages
  display_categories($cat_array);

  // if logged in as admin, show add, delete, edit cat links
  /*if(isset($_SESSION['admin_user'])) {
  display_button("admin.php", "admin-menu", "Admin Menu");
}*/
  display_button("admin.php", "admin-menu", "Admin Menu");
  do_html_footer();
?>
