<?php
# include function files for this application
require_once('POS_fns.php');
session_start();
do_html_header("Delete Product from Inventory");
require_once('product_sidebar.php');


# Code for your web page follows
# Point Of Sale Project


if (!isset($_POST['submit']))
{
  $product_upc =$_GET['id'];
  echo "record id: $product_upc <br />";


  try
  {
    //open the database
    $db = db_connect();

    //Load and display

    $query = "DELETE FROM products WHERE products.product_upc = $product_upc";
    $result = $db->query($query);
    if (!$result) {
      throw new Exception('Could not delete you in database - please try again later.');
    }
    print "Product Deleted............................<br/>";
  }
  catch(PDOException $e)
  {
    echo 'Exception : '.$e->getMessage();
    echo "<br/>";
    $db = NULL;
  }

}
?>
