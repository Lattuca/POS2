<?php

require_once('db_fns.php');

function login($username, $password) {
// check username and password with db
// if yes, return true
// else return false

  // connect to db

    $conn = db_connect();
    if (!$conn) {
      echo "could not connect to database";
      return 0;
    }

    // check if username is unique
    /* $result = $conn->query("select * from user
                         where username='".$username."'
                         and  passwd = sha1('".$password."')");*/

    $query = "select * from user where username='".$username."' and  passwd = sha1('".$password."')";

    $result = $conn->query($query);

    #echo "<h3> User Name: $username </h3>";
    if (!$result) {
       die($result->error);
     return 0;
    }

    $rows = $result->num_rows;
    if ($result->num_rows>0) {
      return 1;
    } else {
      return 0;
    }
}


function register($username, $password, $first, $last, $email) {
// register new person with db
// return true or error message

  // connect to db
  $conn = db_connect();

  // check if username is unique
  $result = $conn->query("select * from user where username='".$username."'");
  if (!$result) {
    try_again('Could not execute query');
  }

  if ($result->num_rows>0) {
    try_again('That username is taken - go back and choose another one.');
  }

    // if ok, put in db
  $query = "insert into user ( username, passwd, first, last, email)
            values
            ('".$username."', sha1('".$password."'), '".$first."','".$last."','".$email."');";
  $result = $conn->query($query);

  if (!$result) {
    throw new Exception('Could not register you in database - please try again later.');
  }

  return true;
}

function user_update($username, $password, $first, $last, $email) {
// register new person with db
// return true or error message

  // connect to db
  $conn = db_connect();

  // check if username is unique
  $result = $conn->query("select * from user where username='".$username."'");
  if (!$result) {
    throw new Exception('Could not execute query');
  }

      // if ok, updatein db
      /* $query = "update categories
                set catname='".$catname."'
                where catid='".$catid."'";
      $result = @$conn->query($query); */



  $query = "update user
                SET passwd = sha1('".$password."'),
                    first = '".$first."',
                    last = '".$last."',
                    email ='".$email."'
                    where username = '".$username."'";


  $result = $conn->query($query);

  if (!$result) {
    throw new Exception('Could not update you in database - please try again later.');
  }

  return true;
}

function check_valid_user() {
// see if somebody is logged in and notify them if not
  if (isset($_SESSION['valid_user']))  {
      echo "Logged in as ".$_SESSION['valid_user'].".<br />";
  } else {
     // they are not logged in
     do_html_heading('Problem:');
     echo 'You are not logged in.<br />';
     do_html_url('POS_login.php', 'Login');
     do_html_footer();
     exit;
  }
}

function check_admin_user() {
// see if somebody is logged in and notify them if not

  if (isset($_SESSION['admin_user'])) {
    return true;
  } else {
    #return false;
    return true;
  }
}

function change_password($username, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else return false
  if (login($username, $old_password)) {

    if (!($conn = db_connect())) {
      return false;
    }

    $result = $conn->query("update user
                            set passwrd = sha1('".$new_password."')
                            where username = '".$username."'");
    if (!$result) {
      return false;  // not changed
    } else {
      return true;  // changed successfully
    }
  } else {
    return false; // old password was wrong
  }
}

// Check to see if we are logged in as an admin
function we_are_not_logged_in()
{
  if (empty($_SESSION['logged_in'])) {
    echo "Only logged in user can execute this function.<br/>";
    do_html_footer();
  	return true;
	}
}
?>
