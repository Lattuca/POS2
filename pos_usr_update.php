<?php

// include function files for this application
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
if (we_are_not_logged_in()){
  exit;
}
require_once('POS_admin_header.php');
do_html_heading("Edit User Details");

include "user_sidebar.php";

# Get the Users by user id
if (!isset($_POST['submit']))
{
  $username =$_GET['id'];
  #echo "record id is: $username</br>";
try
  {
    //open the database and find product
    $db = db_connect();

    // get user to update

    $query = "SELECT * from user WHERE user.username = '$username'";
    #$result = $db->query($query)->fetch(PDO::FETCH_ASSOC);
    $result = $db->query($query);
    if (!$result) {
         die($result->error);
    }
    $user = $result->fetch_assoc();
    display_user_update_form($user['username'], $user['first'], $user['last'], $user['email'], $user['passwd'] );
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }
  #display user update form and get updates
}


do_html_footer();

?>
