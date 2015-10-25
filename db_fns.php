<?php

define("DB_PATH","mysql:host=localhost;dbname=book_sc");
define("DB_LOGIN","carmelo");
define("DB_PW","cl201812");

function db_connect() {
   $result = new mysqli('localhost', DB_LOGIN, DB_PW, 'book_sc');
   #$result = new PDO(DB_PATH, DB_LOGIN, DB_PW);
   if (!$result) {
      return false;
   }
   $result->autocommit(TRUE);
   return $result;
}

function db_result_to_array($result) {
   $res_array = array();

   for ($count=0; $row = $result->fetch_assoc(); $count++) {
     $res_array[$count] = $row;
   }

   return $res_array;
}

?>
