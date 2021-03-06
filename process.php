<?php
  include ('POS_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  if (we_are_not_logged_in()){
    exit;
  }

  header("Cache-Control: max-age=300, must-revalidate");
  do_html_header('Checkout');

  $card_type = $_POST['card_type'];
  $card_number = $_POST['card_number'];
  $amex_code =$_POST['amex_code'];
  $card_month = $_POST['card_month'];
  $card_year = $_POST['card_year'];
  $card_name = $_POST['card_name'];

  // check if credit card is numeric

  if (!is_numeric($card_number) && $card_number<>"") {
    try_again("<p> Credit Card number is not numeric, please try again</p><hr />");
  }

  if($card_type =="American Express" && !is_numeric($amex_code)){
    try_again("<p> Amex code number is not numeric, please try again</p><hr />");
  }


  if(($_SESSION['cart']) && ($card_type) && ($card_number) &&
     ($card_month) && ($card_year) && ($card_name)) {


    //display cart, not allowing changes and without pictures

    display_cart($_SESSION['cart'], false, 0);

    display_shipping(calculate_shipping_cost());

    if(process_card($_POST)) {
      //empty shopping cart but keep the username
      $username = $_SESSION['username'];
      session_destroy();
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['logged_in'] = 1;

      echo "<p>Order has been completed.</p><hr />";
      display_button("index.php", "continue-shopping", "Continue Shopping");
    } else {
      echo "<p>Could not process your card. Please contact the card issuer or try again.</p><hr />";
      display_button("purchase.php", "back", "Back");
    }
  } else {
    #echo "<p>You did not fill in all the fields, please try again.</p><hr />";
    #display_button("purchase.php", "back", "Back");
    try_again("<p>You did not fill in all the fields, please try again.</p><hr />");
  }

  do_html_footer();
?>
