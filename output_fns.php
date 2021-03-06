<?php

function do_html_header($title = '') {
  // print an HTML header
  #session_start();
  #echo " before session varaibles.......................";
  // declare the session variables we want access to inside the function

  $items = isset($_SESSION['items']) ? $_SESSION['items'] : NULL;
  $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : NULL;
  if (!$items) {
    $items = '0';
  }
  if (!$total_price) {
    $total_price = '0.00';
  }
?>
  <html>
  <head>
    <title><?php echo $title; ?></title>


    <style>
      h2 { font-family: Arial, Helvetica, sans-serif; font-size: 22px; color: red; margin: 6px }
      body { font-family: Arial, Helvetica, sans-serif; font-size: 16px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 16px }
      hr { color: #FF0000; width=70%; text-align=center}
      a { color: #000000 }
    </style>
    <link rel="stylesheet" href="pos.css">
  </head>
  <body>
  <table width="100%" border="0" cellspacing="0" bgcolor="#cccccc">
  <tr>
  <td rowspan="2">
  <a href="index.php"><img src="images/Carmelos-POS.gif" alt="CarmeloPos" border="0"
       align="left" valign="bottom" height="55" width="325"/></a>
  </td>
  <td align="right" valign="bottom">
  <?php
     $admin_user = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : NULL;
     $items = isset($_SESSION['items']) ? $_SESSION['items'] : 0;
     if($admin_user) {
       echo "&nbsp;";
     } else {
       echo "Total Items = ".$items;
     }
  ?>
  </td>
  <td align="right" rowspan="2" width="135">
  <?php
     if(isset($_SESSION['admin_user'])) {
       display_button('logout.php', 'log-out', 'Log Out');
     } else {
       display_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
     }
  ?>
  </tr>
  <tr>
  <td align="right" valign="top">
  <?php
     $admin_user = isset($_SESSION['admin_user']) ? $_SESSION['admin_user'] : NULL;
     $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : NULL;
     if($admin_user) {
       echo "&nbsp;";
     } else {
       echo "Total Price = $".number_format($total_price,2);
     }
  ?>
  </td>
  </tr>
  </table>
  <?php
  if($title) {
    do_html_heading($title);
  }
}

function do_html_footer() {
  // print an HTML footer
?>
  </body>
  </html>
<?php
}

function do_html_heading($heading) {
  // print heading
?>
  <h2><?php echo $heading; ?></h2>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
}

function display_categories($cat_array) {
  if (!is_array($cat_array)) {
     echo "<p>No categories currently available</p>";
     return;
  }
  echo "<ul>";
  foreach ($cat_array as $row)  {
    $url = "show_cat.php?catid=".$row['catid'];
    $title = $row['catname'];
    echo "<li>";
    do_html_url($url, $title);
    echo "</li>";
  }
  echo "</ul>";
  echo "<hr />";
}

function display_products($product_array) {
  //display all products in the array passed in
  if (!is_array($product_array)) {
    echo "<p>No products currently available in this category</p>";
  } else {
    //create table
    echo "<table width=\"100%\" border=\"0\">";
    echo "<h3> Select Product to Purchase from List</h3>";
    //create a table row for each product
    foreach ($product_array as $row) {
      $url = "show_product.php?product_upc=".$row['product_upc'];
      echo "<tr><td>";
      if (@file_exists("images/".$row['product_upc'].".jpg")) {
        $title = "<img src=\"images/".$row['product_upc'].".jpg\"
                  style=\"border: 1px solid black\"/>";
        do_html_url($url, $title);
      } else {
        echo "&nbsp;";
      }
      echo "</td><td>";
      $title = $row['product_upc']." - ".$row['product_desc'];
      echo "<li>";
      do_html_url($url, $title);
      echo "</li></td></tr>";
    }

    echo "</table>";
  }

  echo "<hr />";
}

function display_product_details($product) {
  // display all details about this product
  if (is_array($product)) {
    echo "<table><tr>";
    //display the picture if there is one
    if (@file_exists("images/".$product['product_upc'].".jpg"))  {
      $size = GetImageSize("images/".$product['product_upc'].".jpg");
      if(($size[0] > 0) && ($size[1] > 0)) {
        echo "<td><img src=\"images/".$product['product_upc'].".jpg\"
              style=\"border: 1px solid black\"/></td>";
      }
    }
    echo "<td><ul>";

    echo "</li><li><strong>Product UPC:</strong> ";
    echo $product['product_upc'];
    echo "</li><li><strong>Quantity:</strong> ";
    echo $product['quantity'];
    echo "</li><li><strong>Our Price:</strong> ";
    echo number_format($product['price'], 2);
    echo "</li><li><strong>Product Available:</strong> ";
    $available_yn = cvt_yes_no($product['available']);
    echo "$available_yn";
    echo "</li><li><strong>Product Notes:</strong> ";
    echo $product['product_notes'];
    echo "</li></ul></td></tr></table>";
  } else {
    echo "<p>The details of this product cannot be displayed at this time.</p>";
  }
  echo "<hr />";
}

function display_checkout_form() {
  //display the form that asks for name and address
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
  <form action="purchase.php" method="post">
  <tr><th colspan="2" bgcolor="#cccccc">Customer Details</th></tr>
  <tr>
    <td>Name</td>
    <td><input type="text" name="name" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input type="text" name="address" value="" maxlength="40" size="40"/></td>
  </tr>
  <tr>
    <td>City/Suburb</td>
    <td><input type="text" name="city" value="" maxlength="20" size="40"/></td>
  </tr>
  <tr>
    <td>State/Prov</td>
    <td><select name="state"> <?php echo StateDropdown('CA', 'abbrev'); ?></select></td>
  </tr>
  <tr>
    <td>Zip/Postal Code</td>
    <td><input type="text" name="zip" value="" maxlength="10" size="40"/></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><input type="text" name="country" value="USA" maxlength="20" size="40"/></td>
  </tr>

    <td colspan="2" align="center"><p><strong>Please press Purchase to confirm
         your purchase, or Continue Shopping to add or remove items.</strong></p>
     <?php display_form_button("purchase", "Purchase These Items"); ?>
    </td>
  </tr>
  </form>
  </table><hr />
<?php
}

function display_shipping($shipping) {
  // display table row with shipping cost and total price including shipping
?>
  <table border="0" width="100%" cellspacing="0">
  <tr><td align="left">Shipping</td>
      <td align="right"> <?php echo number_format($shipping, 2); ?></td></tr>
  <tr><th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
      <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping+$_SESSION['total_price'], 2); ?></th>
  </tr>
  </table><br />
<?php
}

function display_card_form($name) {
  //display form asking for credit card details
?>
  <table border="0" width="100%" cellspacing="0">
  <form action="process.php" method="post">
  <tr><th colspan="2" bgcolor="#cccccc">Credit Card Details</th></tr>
  <tr>
    <td>Type</td>
    <td><select name="card_type">
        <option value="VISA">VISA</option>
        <option value="MasterCard">MasterCard</option>
        <option value="American Express">American Express</option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Number</td>
    <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
  </tr>
  <tr>
    <td>AMEX code (if required)</td>
    <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
  </tr>
  <tr>
    <td>Expiry Date</td>
    <td>Month
       <select name="card_month">
       <option value="01">01</option>
       <option value="02">02</option>
       <option value="03">03</option>
       <option value="04">04</option>
       <option value="05">05</option>
       <option value="06">06</option>
       <option value="07">07</option>
       <option value="08">08</option>
       <option value="09">09</option>
       <option value="10">10</option>
       <option value="11">11</option>
       <option value="12">12</option>
       </select>
       Year
       <select name="card_year">
       <?php
       for ($y = date("Y"); $y < date("Y") + 10; $y++) {
         echo "<option value=\"".$y."\">".$y."</option>";
       }
       ?>
       </select>
  </tr>
  <tr>
    <td>Name on Card</td>
    <td><input type="text" name="card_name" value = "<?php echo $name; ?>" maxlength="40" size="40"></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
      add or remove items</strong></p>
     <?php display_form_button('purchase', 'Purchase These Items'); ?>
    </td>
  </tr>
  </table>
<?php
}

function display_cart($cart, $change = true, $images = 1) {
  // display items in shopping cart
  // optionally allow changes (true or false)
  // optionally include images (1 - yes, 0 - no)

   echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
         <th bgcolor=\"#cccccc\">Price</th>
         <th bgcolor=\"#cccccc\">Quantity</th>
         <th bgcolor=\"#cccccc\">Total</th>
         </tr>";

  //display each item as a table row
  foreach ($cart as $product_upc => $qty)  {
    $product = get_product_details($product_upc);
    echo "<tr>";
    if($images == true) {
      echo "<td align=\"left\">";
      if (file_exists("images/".$product_upc.".jpg")) {
         $size = GetImageSize("images/".$product_upc.".jpg");
         if(($size[0] > 0) && ($size[1] > 0)) {
           echo "<img src=\"images/".$product_upc.".jpg\"
                  style=\"border: 1px solid black\"
                  width=\"".($size[0]/3)."\"
                  height=\"".($size[1]/3)."\"/>";
         }
      } else {
         echo "&nbsp;";
      }
      echo "</td>";
    }
    echo "<td align=\"left\">
          <a href=\"show_product.php?product_upc=".$product_upc."\">".$product['product_upc']."</a>
          - ".$product['product_desc']."</td>
          <td align=\"center\">\$".number_format($product['price'], 2)."</td>
          <td align=\"center\">";

    // if we allow changes, quantities are in text boxes
    if ($change == true) {
      echo "<input type=\"text\" name=\"".$product_upc."\" value=\"".$qty."\" size=\"3\">";
    } else {
      echo $qty;
    }
    echo "</td><td align=\"center\">\$".number_format($product['price']*$qty,2)."</td></tr>\n";
  }
  // display total row
  echo "<tr>
        <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</td>
        <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            \$".number_format($_SESSION['total_price'], 2)."
        </th>
        </tr>";

  // display save change button
  if($change == true) {
    echo "<tr>
          <td colspan=\"".(2+$images)."\">&nbsp;</td>
          <td align=\"center\">
             <input type=\"hidden\" name=\"save\" value=\"true\"/>
             <input type=\"image\" src=\"images/save-changes.gif\"
                    border=\"0\" alt=\"Save Changes\"/>
          </td>
          <td>&nbsp;</td>
          </tr>";
  }
  echo "</form></table>";
}

function display_login_form() {
  // dispaly form asking for name and password
?>

 <br/><br/>
 <form method="post" action="admin.php">
 <table bgcolor="#cccccc">
  <tr>
    <td colspan="2">POS2 Users log in:</td>
  <tr>
    <td>Username:</td>
    <td><input type="text" name="username"/></td></tr>
  <tr>
    <td>Password:</td>
    <td><input type="password" name="passwd"/></td></tr>
  <tr>
    <td colspan="2" align="center">
    <input type="submit" value="Log in"/></td></tr>
</table></form>
<?php
}

function display_registration_form($mode) {
    ?>
 <form method="post" action='register_new.php'>

 <table bgcolor="#cccccc">
   <tr>
     <td>Email address:</td>
     <td><input type="text" name="email" size="30"/></td></tr>
   <tr>
     <td>Preferred username <br />(max 16 chars):</td>
     <td valign="top"><input type="text" name="username"
         size="16" maxlength="16"/</td></tr>
   <tr>
     <tr>
       <td>First name:</td>
       <td valign="top"><input type="text" name="first" size="25"></td></tr>
     <tr>
    <tr>
        <td>Last name:</td>
        <td valign="top"><input type="text" name="last" size="25"></td></tr>
    <tr>
     <td>Password <br />(between 6 and 16 chars):</td>
     <td valign="top"><input type="password" name="passwd"
         size="16" maxlength="16"/></td></tr>
   <tr>
     <td>Confirm password:</td>
     <td><input type="password" name="passwd2" size="16" maxlength="16"/></td></tr>
   <tr>
     <td colspan=2 align="center">
     <input type="submit" value="Add"></td></tr>
     <tr>
       <td><input type ="hidden" name=mode value="<?php echo "$mode"; ?>"</td>
     </tr>
 </table></form>

<?php

}
function display_admin_menu() {
?>
<br />
<hr />
<ul>
<h4> Select Admin Menu Options </h4>

<li><a href="index.php">Go to POS</a><br /></li><br />
<li><a href="display_orders.php">Display orders</a><br /></li><br />
<li><a href="manage_categories.php">Manage categories</a><br /></li><br />
<li><a href="manage_customers.php">Manage customers</a><br /></li><br />
<li><a href="manage_products.php">Manage product inventory</a><br /></li><br />
<li><a href="manage_users.php">Manage user profiles</a><br /></li><br />


<br /><br /><br /><hr />

<?php display_button("logout.php", "log-out", "Log Out"); ?>


</ul>
<?php
}

function display_button($target, $image, $alt) {
  echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
}

function display_form_button($image, $alt) {
  echo "<div align=\"center\"><input type=\"image\"
           src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></div>";
}

function try_again($str) {
  echo $str;
  echo "<br/>";
  //the following emulates pressing the back button on a browser
  echo '<a href="#" onclick="history.back(); return false;">Try Again</a>';
exit;
}
?>

<?php
function display_user_menu() {
  // display the menu options on this page
?>
<hr />
<!-- <a href="member.php">Home</a> &nbsp;|&nbsp;
<a href="add_bm_form.php">Add BM</a> &nbsp;|&nbsp; -->
<?php
  /*
  // only offer the delete option if bookmark table is on this page
   global $bm_table;
  if ($bm_table == true) {
    echo "<a href=\"#\" onClick=\"bm_table.submit();\">Delete BM</a> &nbsp;|&nbsp;";
  } else {
    echo "<span style=\"color: #cccccc\">Delete BM</span> &nbsp;|&nbsp;";
  }*/
?>
<a href="change_passwd_form.php">Change password</a>
<br />
<!-- <a href="recommend.php">Recommend URLs to me</a> &nbsp;|&nbsp; -->
<a href="logout.php">Logout</a>
<hr />

<?php
}

function display_user_update_form($username, $first, $last, $email, $password  ) {
?>
 <form method="post" action="pos_usr_db_update.php">
 <table bgcolor="#cccccc">
   <tr>
     <td>Email address:</td>
     <td><input type="text" name="email" value = "<?php print $email;?>" size="30"/></td>
   </tr>
   <tr>
     <td>Preferred username <br />(max 16 chars):</td>
     <td valign="top"><input type="text" readonly name="username" value="<?php print $username;?>"
         size="16" maxlength="16"/</td>
  </tr>
   <tr>
     <tr>
       <td>First name:</td>
       <td valign="top"><input type="text" name="first" value="<?php print $first; ?>" </td></tr>
     <tr>
    <tr>
        <td>Last name:</td>
        <td valign="top"><input type="text" name="last" value="<?php print $last; ?>"</td></tr>
    <tr>
     <td>Password <br />(between 6 and 16 chars):</td>
     <td valign="top"><input type="password" name="passwd"
         size="16" maxlength="16"/></td></tr>
   <tr>
     <td>Confirm password:</td>
     <td><input type="password" name="passwd2" size="16" maxlength="16"/></td></tr>
   <tr>
     <td colspan=2 align="center">
     <input type="submit" value="Update"></td></tr>
 </table></form>
<?php

}

function display_user_form($username, $first, $last, $email) {


// Display the data to confirm

  //now output the data from the insert to a simple html table...
  print "<table border=4  CELLSPACING=4 CELLPADDING=4>";
  print "<tr>";
  print '<td BGCOLOR="#C0C0C0", align="center">User Name</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">First</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Last</td>';
  print '<td BGCOLOR="#C0C0C0", align="center">Email</td>';
  print "</tr>";


  print "<tr>";
  print '<td align="center">'.$username."</td>";
  print '<td align="left">'.$first."</td>";
  print '<td align="left">'.$last."</td>";
  print '<td align="center">'.$email."</td>";
    print "</tr>";
  print "</table>";


  print "<br/><br/><br/><br/><br/><br/>";
  echo'<td class="style2"><a href="pos_usr_del_db.php?id='.$username.'"onclick="javascript:return confirm(\'Are you sure you want to delete this User?\')">Confirm Delete</a>';"</td></tr>";

}
function display_product_delete_form($product_upc, $product_desc, $quantity, $price, $cost, $catid, $available, $product_notes) {


// Display the data to confirm

  echo "<table border=4  CELLSPACING=4 CELLPADDING=4>";
  echo "<tr>";
  echo '<td BGCOLOR="#C0C0C0", align="center">Product Code</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Description</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Quantity</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Price</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Cost</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Category</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Available</td>';
  echo '<td BGCOLOR="#C0C0C0", align="center">Notes</td>';

  echo "</tr>";

  $available_yn = cvt_yes_no($available);


  echo "<tr>";
  echo '<td align="center"> '.$product_upc.'</td>';
  echo '<td align="left"> '.$product_desc.'</td>';
  echo '<td align="center">'.$quantity."</td>";
  echo '<td align="right">'.$price."</td>";
  echo '<td align="right">'.$cost."</td>";
  echo '<td align="center">'.$catid."</td>";
  echo '<td align="center"> '.$available_yn.' </td>';
  #echo '<td><textarea readonly rows="4" cols="40">'.$product_notes.'</textarea></td>';
  echo '<td align="left">'.$product_notes.'</textarea></td>';
  echo "</tr>";
  echo "</table>";


  echo "<br/><br/><br/><br/><br/><br/>";

  echo'<td class="style2"><a href="pos_prod_del_db.php?id='.$product_upc.'"onclick="javascript:return confirm(\'Are you sure you want to delete this product?\')">Confirm Delete</a>';"</td></tr>";

}
function html_head($title) {
  echo '<html lang="en">';
  echo '<head>';
  echo '<meta charset="utf-8">';
  echo "<title>$title</title>";
  echo '<link rel="stylesheet" href="pos.css">';
  echo '</head>';
  echo '<body>';
}

function show_login_button(){
echo '<form method="post" action="POS_login.php">';
echo '<tr> <td colspan="2" align="center">
  <input type="submit" value="Log in"/></td></tr>';
}

function show_user_details($username){
  $now = date("F j, Y, g:i a");
  echo "<br /> <strong> User:</strong> $username <strong> Date: </strong> $now </h4>";
}
function get_customer_name($customerid){

  // Function to obtain customer name

  $conn = db_connect();

  $query = "select * from customers where customerid = $customerid";

  $result = @$conn->query($query);
  if (!$result) {
    return false;
  }
  $num_custs = @$result->num_rows;
  if ($num_custs == 0) {
     return false;
  }
  $row = $result->fetch_object();
  return $row->name;
  }

function display_customer_update_form($customerid, $name, $address, $city, $state, $zip, $country){


  ?>

<form method="post" action="pos_cust_db_update.php">
<table bgcolor="#cccccc">

<tr><th colspan="2" bgcolor="#cccccc">Customer Details</th></tr>
<tr>
  <td>Name</td>
  <td><input type="text" name="name" value="<?php print $name; ?>" maxlength="40" size="40"/></td>
</tr>
<tr>
  <td>Address</td>
  <td><input type="text" name="address" value="<?php print $address; ?>" maxlength="40" size="40"/></td>
</tr>
<tr>
  <td>City/Suburb</td>
  <td><input type="text" name="city" value="<?php print $city; ?>" maxlength="20" size="40"/></td>
</tr>
<tr>
  <td>State</td>
  <td><select name="state"> <?php echo StateDropdown($state, 'abbrev'); ?></select></td>
</tr>
<tr>
  <td>Zip Code</td>
  <td><input type="text" name="zip" value="<?php print $zip; ?>" maxlength="10" size="40"/></td>
</tr>
<tr>
  <td>Country</td>
  <td><input type="text" name="country" value="<?php print $country; ?>" maxlength="20" size="40"/></td>
</tr>

<tr>
  <td colspan=2 align="center">
  <input type="submit" value="Update"></td></tr>
  <tr>
    <td><input type ="hidden" name=customerid value="<?php echo "$customerid"; ?>"</td>
  </tr>
</table></form>
<?php
}

function display_customer_delete_form($customerid, $name, $address, $city, $state, $zip, $country) {

  // Display the data to confirm

    echo "<table border=4  CELLSPACING=4 CELLPADDING=4>";
    echo "<tr>";
    echo '<td BGCOLOR="#C0C0C0", align="center">Customer Id</td>';
    echo '<td BGCOLOR="#C0C0C0", align="center">Name</td>';
    echo '<td BGCOLOR="#C0C0C0", align="center">Address</td>';
    echo '<td BGCOLOR="#C0C0C0", align="center">City</td>';
    echo '<td BGCOLOR="#C0C0C0", align="center">State</td>';
    echo '<td BGCOLOR="#C0C0C0", align="center">ZIP</td>';
    echo '<td BGCOLOR="#C0C0C0", align="center">Country</td>';


    echo "</tr>";

    echo "<tr>";
    echo '<td align="center"> '.$customerid.'</td>';
    echo '<td align="left"> '.$name.'</td>';
    echo '<td align="center">'.$address."</td>";
    echo '<td align="right">'.$city."</td>";
    echo '<td align="center">'.$state."</td>";
    echo '<td align="center"> '.$zip.' </td>';
    echo '<td align="center"> '.$country.' </td>';
    echo "</tr>";
    echo "</table>";


    echo "<br/><br/><br/><br/><br/><br/>";

    echo'<td class="style2"><a href="pos_cust_del_db.php?id='.$customerid.'"onclick="javascript:return confirm(\'Are you sure you want to delete this customer?\')">Confirm Delete</a>';"</td></tr>";
}
?>
