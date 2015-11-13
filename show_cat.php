<?php
  include ('POS_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  if (we_are_not_logged_in()){
    display_button("POS_login.php","log-in","Log In");
    exit;
  }

  $catid = $_GET['catid'];

  $name = get_category_name($catid);

  do_html_header($name);

  // get the product info out from db
  $product_array = get_products($catid);



  display_products($product_array);

  #echo "I am here...for back";
  // if logged in as admin, show add, delete product links
  if(isset($_SESSION['admin_user'])) {
    display_button("index.php", "back", "Select Category");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button("edit_category_form.php?catid=".$catid,
                   "edit-category", "Edit Category");
  } else {
    display_button("index.php", "back", "Select Category");
  }

  do_html_footer();
?>
