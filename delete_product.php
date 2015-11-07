<?php

// include function files for this application
require_once('POS_fns.php');
session_start();
do_html_header("Delete Product");
require_once('product_sidebar.php');

# Get the Users by user id (username)
if (!isset($_POST['submit']))
{
  $product_upc =$_GET['id'];
  echo "record id is: $product_upc</br>";
try
  {
    //open the database and find product
    $db = db_connect();

    #get user to delete

    $query = "SELECT * from products WHERE products.product_upc = '$product_upc'";
    #$result = $db->query($query)->fetch(PDO::FETCH_ASSOC);
    $result = $db->query($query);
    if (!$result) {
         die($result->error);
    }
    $product = $result->fetch_assoc();

    display_product_delete_form($product['product_upc'], $product['product_desc'],
                               $product['quantity'], $product['price'], $product['cost'],
                               $product['catid'], $product['available'], $product['product_notes']);

    }
    catch(PDOException $e)
    {
      echo 'Exception : '.$e->getMessage();
      echo "<br/>";
      $db = NULL;
    }
  }



do_html_footer();
/* if (check_admin_user()) {
  if (isset($_POST['product_upc'])) {
    $product_upc = $_POST['product_upc'];
    if(delete_product($product_upc)) {
      echo "<p>Product ".$product_upc." was deleted.</p>";
    } else {
      echo "<p>Product ".$product_upc." could not be deleted.</p>";
    }
  } else {
    echo "<p>We need an Product UPC to delete a Product.  Please try again.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}
*/
?>
