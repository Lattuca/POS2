<?php
  include ('POS_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  if (we_are_not_logged_in()){
    display_button("POS_login.php","log-in","Log In");
    exit;
  }
  $product_upc = $_GET['product_upc'];

  // get this product out of database
  $product = get_product_details($product_upc);
  do_html_header($product['product_desc']);
  display_product_details($product);

  // set url for "continue button"
  $target = "index.php";
  if($product['catid']) {
    $target = "show_cat.php?catid=".$product['catid'];
  }

  // if logged in as admin, show edit product links
  /*if(check_admin_user()) {
    display_button("edit_product_form.php?product_upc=".$product_upc, "edit-item", "Edit Item");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button($target, "continue", "Continue");
  }*/

  display_button("show_cart.php?new=".$product_upc, "add-to-cart",
                   "Add".$product['product_desc']." To My Shopping Cart");
  #display_button($target, "continue-shopping", "Continue Shopping");
  display_button($target, "back", "Select Category");

  do_html_footer();
?>
