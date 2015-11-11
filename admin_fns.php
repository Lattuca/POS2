<?php
// This file contains functions used by the admin interface
// for the product-O-Rama shopping cart.

function display_category_form($category = '') {
// This displays the category form.
// This form can be used for inserting or editing categories.
// To insert, don't pass any parameters.  This will set $edit
// to false, and the form will go to insert_category.php.
// To update, pass an array containing a category.  The
// form will contain the old data and point to update_category.php.
// It will also add a "Delete category" button.

  // if passed an existing category, proceed in "edit mode"
  $edit = is_array($category);

  // most of the form is in plain HTML with some
  // optional PHP bits throughout
?>
  <form method="post"
      action="<?php echo $edit ? 'edit_category.php' : 'insert_category.php'; ?>">
  <table border="0">
  <tr>
    <td>Category Name:</td>
    <td><input type="text" name="catname" size="40" maxlength="40"
          value="<?php echo $edit ? $category['catname'] : ''; ?>" /></td>
   </tr>
  <tr>
    <td <?php if (!$edit) { echo "colspan=2";} ?> align="center">
      <?php
         if ($edit) {
            echo "<input type=\"hidden\" name=\"catid\" value=\"".$category['catid']."\" />";
         }
      ?>
      <input type="submit"
       value="<?php echo $edit ? 'Update' : 'Add'; ?> Category" /></form>
     </td>
     <?php
        if ($edit) {
          //allow deletion of existing categories
          echo "<td>
                <form method=\"post\" action=\"delete_category.php\">
                <input type=\"hidden\" name=\"catid\" value=\"".$category['catid']."\" />
                <input type=\"submit\" value=\"Delete category\" />
                </form></td>";
       }
     ?>
  </tr>
  </table>
<?php
}

function display_product_form($product = '') {
// This displays the product form.
// It is very similar to the category form.
// This form can be used for inserting or editing products.
// To insert, don't pass any parameters.  This will set $edit
// to false, and the form will go to insert_product.php.
// To update, pass an array containing a product.  The
// form will be displayed with the old data and point to update_product.php.
// It will also add a "Delete product" button.


  // if passed an existing product, proceed in "edit mode"
  $edit = is_array($product);

?>
  <form method="post"
        action="<?php echo $edit ? 'edit_product.php' : 'insert_product.php';?>">
  <table border="0">
  <tr>
    <td>Product UPC:</td>
    <td><input type="text" name="product_upc"
         value="<?php echo $edit ? $product['product_upc'] : ''; ?>" /></td>
  </tr>
  <tr>
    <td>Product Description:</td>
    <td><input type="text" name="product_desc" size = "40"
         value="<?php echo $edit ? $product['product_desc'] : ''; ?>" /></td>
  </tr>
  <tr>
    <td>Product Quantity:</td>
    <td><input type="integer" name="quantity"
         value="<?php echo $edit ? $product['quantity'] : ''; ?>" /></td>
   </tr>
   <tr>
    <td>Product Price:</td>
    <td><input type="text" name="price"
         value="<?php echo $edit ? $product['price'] : ''; ?>" /></td>
   </tr>
   <tr>
    <td>Product Cost:</td>
    <td><input type="text" name="cost"
         value="<?php echo $edit ? $product['cost'] : ''; ?>" /></td>
   </tr>
   <tr>
      <td>Category:</td>
      <td><select name="catid">
      <?php
          // list of possible categories comes from database
          $cat_array=get_categories();
          foreach ($cat_array as $thiscat) {
               echo "<option value=\"".$thiscat['catid']."\"";
               // if existing product, put in current catgory
               if (($edit) && ($thiscat['catid'] == $product['catid'])) {
                   echo " selected";
               }
               echo ">".$thiscat['catname']."</option>";
          }
          ?>
          </select>
        </td>
   </tr>

   <tr>
    <td>Available:</td>
     <?php
         if ($edit){
           if ($product['available'] ==1){
             echo '<td><input type="checkbox" id="available" name="available" value ="'.$product['available'].'" checked = "checked" > </td>';
            }else{
              echo '<td><input type="checkbox" id="available" name="available" value ="'.$product['available'].'">  </td>';
            }
          }else{
            echo '<td align="left"><input type="checkbox" name="available" value = "1" checked> </td>';
         }
      ?>
   <tr>
     <td>Notes:</td>
        <td><textarea rows="3" cols="50"
           name="product_notes"><?php echo $edit ? $product['product_notes'] : ''; ?></textarea>
       </td>
    </tr>

    <tr>
      <td <?php if (!$edit) { echo "colspan=2"; }?> align="center">
         <?php
            if ($edit)
             // we need the old product_upc to find product in database
             // if the product_upc is being updated
             echo "<input type=\"hidden\" name=\"oldproduct_upc\"
                    value=\"".$product['product_upc']."\" />";
         ?>
        <input type="submit"
               value="<?php echo $edit ? 'Update' : 'Add'; ?> product" />
        </form></td>
        <?php
           if ($edit) {
             echo "<td>
                   <form method=\"post\" action=\"delete_product.php\">
                   <input type=\"hidden\" name=\"product_upc\"
                    value=\"".$product['product_upc']."\" />
                   <input type=\"submit\" value=\"Delete product\"/>
                   </form></td>";
            }
          ?>
         </td>
      </tr>
  </table>
  </form>
<?php
}

function display_password_form() {
// displays html change password form
?>
   <br />
   <form action="change_password.php" method="post">
   <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Old password:</td>
       <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>New password:</td>
       <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>Repeat new password:</td>
       <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
   </tr>
   <tr><td colspan=2 align="center"><input type="submit" value="Change password">
   </td></tr>
   </table>
   <br />
<?php
}

function insert_category($catname) {
// inserts a new category into the database

   $conn = db_connect();

   // check category does not already exist
   $query = "select *
             from categories
             where catname='".$catname."'";
   $result = $conn->query($query);
   if ((!$result) || ($result->num_rows!=0)) {
     return false;
   }

   // insert new category
   $query = "insert into categories (catname)
             values
            ('".$catname."')";
   $result = $conn->query($query);

   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function insert_product($product_upc, $product_desc, $quantity, $price, $cost, $catid, $available, $product_notes) {
// insert a new product into the database
//



   // insert new product
   $conn = db_connect();
   $query = "insert into products (product_upc, product_desc, quantity,
                           price, cost, catid, available, product_notes)
             values
            ('".$product_upc."', '".$product_desc."', '".$quantity."',
              '".$price."', '".$cost."',
             '".$catid."', '".$available."', '".$product_notes."')";

   $result = $conn->query($query);
   if (!$result) {
     #die($result->error);
     return false;
   } else {
     return true;
   }
}

function update_category($catid, $catname) {
// change the name of category with catid in the database

   $conn = db_connect();

   $query = "update categories
             set catname='".$catname."'
             where catid='".$catid."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function update_product($oldproduct_upc, $product_upc, $product_desc,
                         $quantity, $price, $cost, $catid, $available, $product_notes) {
// change details of product stored under $oldproduct_upc in
// the database to new details in arguments

   $conn = db_connect();

   $query = "update products
             set product_upc= '".$product_upc."',
             product_desc = '".$product_desc."',
             quantity= '".$quantity."',
             catid = '".$catid."',
             price = '".$price."',
             cost = '".$cost."',
             available = '".$available."',
             product_notes = '".$product_notes."'
             where product_upc = '".$oldproduct_upc."'";

   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function delete_category($catid) {
// Remove the category identified by catid from the db
// If there are products in the category, it will not
// be removed and the function will return false.

   $conn = db_connect();

   // check if there are any products in category
   // to avoid deletion anomalies
   $query = "select *
             from products
             where catid='".$catid."'";

   $result = @$conn->query($query);
   if ((!$result) || (@$result->num_rows > 0)) {
     return false;
   }

   $query = "delete from categories
             where catid='".$catid."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}


function delete_product($product_upc) {
// Deletes the product identified by $product_upc from the database.

   $conn = db_connect();

   $query = "delete from products
             where product_upc='".$product_upc."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

?>
