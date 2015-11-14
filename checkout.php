<?php
  //include our function set
  include ('POS_fns.php');
  require_once('state_drop_down.php');

  // The shopping cart needs sessions, so start one
  session_start();
  if (we_are_not_logged_in()){
      exit;
  }
  do_html_header("Checkout");

  if(($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
    display_cart($_SESSION['cart'], false, 0);
    display_checkout_form();
  } else {
    echo "<p>There are no items in your cart</p>";
  }

  #display_checkout_form();
  display_button("show_cart.php", "continue-shopping", "Continue Shopping");

  do_html_footer();
?>
