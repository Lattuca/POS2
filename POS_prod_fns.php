<?php
function calculate_shipping_cost() {
  // as we are shipping products all over the world
  // via teleportation, shipping is fixed
  return 20.00;
}

function get_categories() {
   // query database for a list of categories
   $conn = db_connect();
   $query = "select catid, catname from categories";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }

   $num_cats = @$result->num_rows;

   if ($num_cats == 0) {
      return false;
   }
   $result = db_result_to_array($result);
   return $result;
}

function get_category_name($catid) {
   // query database for the name for a category id
   $conn = db_connect();
   $query = "select catname from categories
             where catid = '".$catid."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }
   $num_cats = @$result->num_rows;
   if ($num_cats == 0) {
      return false;
   }
   $row = $result->fetch_object();
   return $row->catname;
}


function get_products($catid) {
   // query database for the products in a category
   if ((!$catid) || ($catid == '')) {
     return false;
   }
   # load products that are available and quantity > 0
   $conn = db_connect();
   $query = "select * from products where catid = '".$catid."' AND available = '1' AND quantity > '0'";
   #echo "load product array $query <br />";

   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }

   $num_products = @$result->num_rows;

   if ($num_products == 0) {
      return false;
   }

   $result = db_result_to_array($result);
   return $result;
}

function get_product_details($product_upc) {
  // query database for all details for a particular product
  if ((!$product_upc) || ($product_upc=='')) {
     return false;
  }
  $conn = db_connect();
  $query = "select * from products where product_upc='".$product_upc."'";
  $result = @$conn->query($query);
  if (!$result) {
     return false;
  }
  $result = @$result->fetch_assoc();
  return $result;
}

function calculate_price($cart) {
  // sum total price for all items in shopping cart
  $price = 0.0;
  if(is_array($cart)) {
    $conn = db_connect();
    foreach($cart as $product_upc => $qty) {
      $query = "select price from products where product_upc='".$product_upc."'";
      $result = $conn->query($query);
      if ($result) {
        $item = $result->fetch_object();
        $item_price = $item->price;
        $price +=$item_price*$qty;
      }
    }
  }
  return $price;
}

function calculate_items($cart) {
  // sum total items in shopping cart
  $items = 0;
  if(is_array($cart))   {
    foreach($cart as $product_upc => $qty) {
      $items += $qty;
    }
  }
  return $items;
}

function cvt_yes_no($input)
{ if ($input==1){
  return "Yes";
  }
else {
  return  "No";
  }
}

function cvt_boolean($input)
  { if ($input =="Yes") {
    return "1";
  }else{
    return "0";
  }
}

function validate_product($oldproduct_upc, $product_upc, $product_desc, $quantity, $price, $cost){

  $error_messages = array(); # Create empty error_messages array.

  if (is_empty_field(trim($product_upc))){
    array_push($error_messages, "Product UPC was not entered.");
    return $error_messages; # stop now
  }

  # Check for duplicates

  Try {

    // check product does not already exist
    if ($oldproduct_upc != $product_upc){
      $conn = db_connect();
      $query = "select *
              from products
              where product_upc='".$product_upc."'";

      $result = $conn->query($query);
      if ((!$result) || ($result->num_rows!=0)) {
        array_push($error_messages, "Product UPC is not unique. Product UPC must be unique.");;
      }
    }
    if (is_empty_field($product_desc)){
      array_push($error_messages, "Product description was not entered.");
    }
    if (!is_numeric($quantity)){
      array_push($error_messages, "Quantity must be numeric.");
    }
    if ( $quantity <0 ) {
      array_push($error_messages, "Qunatity field cannot be negative.");
    }
    if (!is_numeric($price)){
      array_push($error_messages, "Price must be numeric.");
    }
    if ( $price < 0 ) {
      array_push($error_messages, "Price field cannot be negative.");
    }
    if (!is_numeric($cost)){
      array_push($error_messages, "Cost must be numeric.");
    }
    if ( $cost < 0 ) {
      array_push($error_messages, "Cost field cannot be negative.");
    }
  }
  catch(Exception $e){
    do_html_header('Problem:');
    echo $e->getMessage();
    do_html_footer();
  exit;
  }
  return $error_messages;
}

function update_product_quantity($product_upc, $quantity_purchased) {

// Function to updated product quanity

try {

  # get current product quantity for update

  $conn = db_connect();
  $query = "select * from products where product_upc = $product_upc";
  $result = @$conn->query($query);
  if (!$result) {
    echo "error in fetching $product_upc <br />";
    return false;
  }
  $num_prods = @$result->num_rows;
  if ($num_prods == 0) {
     return false;
  }
  $row = $result->fetch_object();
  $product_qty = $row->quantity;
  #echo "product qty for $product_upc is".$product_qty."<br/>";
  $product_qty = $product_qty - $quantity_purchased;
  #echo "new product qty for $product_upc is".$product_qty."<br/>";

  # now we update the database with the new quantity

  $query = "update products set quantity = '".$product_qty."' where product_upc = $product_upc";
  #echo "update qty query is $query";
  # update product table
  $result = @$conn->query($query);
  if (!$result) {
    echo "error updated product qty <br />";
    return false;
  } else {
    #echo "successfully updated product qty <br />";
    return true;
  }
}
catch(Exception $e){
  do_html_header('Problem:');
  echo $e->getMessage();
  do_html_footer();
exit;
}

}
?>
