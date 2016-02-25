<?php

  include("frontend.php");

  if(isset($_REQUEST['email']))
  {
    // Code to send password reset email.

    if(isset($_REQUEST['go']))
    {
      header('Location: ' . $_REQUEST['go']);
    }
    else {
      header('Location: courses.php');
    }
  }

?>


<html>

  <?php print_head("Login"); ?>

  <body>

    <?php print_header(); ?>

    <div id='body_outer'>
      <div id='body_inner'>
        <h2>Forgot your password?</h2>

        <form action='' method='POST'>
          <input name='email' type='email' placeholder='Email'>

          <input type='submit' id='submit_button' class='box' value='Login'>
        </form>

      </div>
    </div>
  </body>


</html>
