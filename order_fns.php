<?php
function process_card($card_details) {
  // connect to payment gateway or
  // use gpg to encrypt and mail or
  // store in DB if you really want to

  return true;
}

function insert_order($order_details) {
  // extract order_details out as variables

  extract($order_details);

  // set shipping address same as address
  /*if((!$ship_name) && (!$ship_address) && (!$ship_city) && (!$ship_state) && (!$ship_zip) && (!$ship_country)) {
    $ship_name = $name;
    $ship_address = $address;
    $ship_city = $city;
    $ship_state = $state;
    $ship_zip = $zip;
    $ship_country = $country;
  }
  */

  $conn = db_connect();

  // we want to insert the order as a transaction
  // start one by turning off autocommit
  $conn->autocommit(FALSE);

  // insert customer address
  $query = "select customerid from customers where
            name = '".$name."' and address = '".$address."'
            and city = '".$city."' and state = '".$state."'
            and zip = '".$zip."' and country = '".$country."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    #echo "<br> we are now in INSERT Order rows <> 0";
    $customer = $result->fetch_object();
    $customerid = $customer->customerid;
  } else {
    #$query = "insert into customers  values
    #        ('', '".$name."','".$address."','".$city."','".$state."','".$zip."','".$country.",'NOW()')";
    $query = "insert into customers (name, address, city, state, zip, country) values
            ('$name','$address','$city','$state','$zip','$country')";
    $result = $conn->query($query);
   #echo "<br> we are now insert after customers query result $query";
    if (!$result) {
       return false;

    }
   #echo "<br> we are now insert after after customers insert query result $query";
  }

  $customerid = $conn->insert_id;
  #echo "customer id is $customerid";

  $date = date("Y-m-d");
/*
orderid int unsigned not null auto_increment primary key,
  customerid int unsigned not null,
  amount float(6,2),
  date date not null,
  order_status char(10), */

  #$query = "insert into orders values
  #           ('', '".$customerid."', '".$_SESSION['total_price']."', '".$date."', 'PARTIAL')";

  $total_price = $_SESSION['total_price'];
  $query = "insert into orders (customerid, amount, date, order_status ) values
            ('$customerid', '$total_price', '$date', 'PARTIAL')";

  $result = $conn->query($query);
  #echo "<br> we are now insert after orders query result $query";
  if (!$result) {
    return false;
  }

  $query = "select orderid from orders where
               customerid = '".$customerid."' and
               amount > (".$_SESSION['total_price']."-.001) and
               amount < (".$_SESSION['total_price']."+.001) and
               date = '".$date."' and
               order_status = 'PARTIAL';";

  #echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxx $query";
  $result = $conn->query($query);

  if($result->num_rows>0) {
    $order = $result->fetch_object();
    $orderid = $order->orderid;
  } else {
    return false;
  }

  // insert each product
  foreach($_SESSION['cart'] as $product_upc => $quantity) {
    $detail = get_product_details($product_upc);
    $query = "delete from order_items where
              orderid = '".$orderid."' and product_upc = '".$product_upc."'";
    $result = $conn->query($query);
    $query = "insert into order_items values
              ('".$orderid."', '".$product_upc."', ".$detail['price'].", $quantity)";
    $result = $conn->query($query);
    if(!$result) {
      return false;
    }
  }

  // end transaction
  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}

?>
