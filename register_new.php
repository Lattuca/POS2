<?php
  // include function files for this application
  require_once('POS_fns.php');
  require_once('POS_admin_header.php');
  session_start();
  if (we_are_not_logged_in()){
    display_button("POS_login.php","log-in","Log In");
    exit;
  }

  # get input from user for registration
  //create short variable names


  $email=$_POST['email'];
  $username=$_POST['username'];
  $passwd=$_POST['passwd'];
  $passwd2=$_POST['passwd2'];
  $first=$_POST['first'];
  $last=$_POST['last'];
  $mode =$_POST['mode'];


    // check forms filled in
    #if (!filled_out($_POST)) {
    #    try_again ('You have not filled the form out correctly - please go back and try again.');
    #}

    // email address not valid
    if (!valid_email($email)) {
      try_again ('That is not a valid email address.  Please go back and try again.');
    }

    // user name is entered
    if (is_empty_field($username)) {
      try_again ('You have not filled out username.  Please go back and try again.');
    }

    // first name is entered
    if (is_empty_field($first)) {
      try_again ('You have not filled out first name.  Please go back and try again.');
    }

    // last name is entered
    if (is_empty_field($last)) {
      try_again ('You have not filled out last name.  Please go back and try again.');
    }

    // passwords not the same
    if ($passwd != $passwd2) {
      try_again('The passwords you entered do not match - please go back and try again.');
    }

    // check password length is ok
    // ok if username truncates, but passwords will get
    // munged if they are too long.
    if ((strlen($passwd) < 6) || (strlen($passwd) > 16)) {
      try_again('Your password must be between 6 and 16 characters Please go back and try again.');
    }

    // attempt to register
    // this function can also throw an exception
    register($username, $passwd, $first, $last, $email);

    // register session variable
    $_SESSION['valid_user'] = $username;

    // provide link to members page
    if ($mode=="register"){
       do_html_header('Registration successful');
       echo "Your registration was successful.  Go to the new user page! <br><hr />";
       do_html_url('member.php', 'Go to Users Home Page');
     }else{
       #do_html_header('New user added successfully');
       require_once('user_sidebar.php');
       echo "Your adding of new user was successful. <br><hr />";
       #do_html_url('manage_users.php','Go to Manage Users Page');
     }

   // end page
   do_html_footer();

?>
