!doctype html>
<?php
require_once('POS_fns.php');
require_once('output_fns.php');
session_start();
do_html_header("POS Delete User from DB");


# Code for your web page follows
# Point Of Sale Project

if (!isset($_POST['submit']))
{
  $user_id =$_GET['id'];

  try
  {
    //open the database

    $db = db_connect();

    $query = "DELETE FROM users WHERE user.username = $user_id";
    $result = $db->query($query);
    print "User Deleted............................<br/>";
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }

}
?>
