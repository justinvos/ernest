<?php

  include("frontend.php");

  if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
  {
    $params = array(
      'email' => $_REQUEST['email'],
      'password' => $_REQUEST['password']
    );

    $curl = curl_init("localhost/ernest/api/accounts.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_POST, sizeof($params));
    curl_setopt($curl,CURLOPT_POSTFIELDS, $params);
    curl_exec($curl);

    header('Location: index.php');
  }

?>


<html>

  <?php print_head("Register"); ?>

  <body>

    <?php print_header(); ?>

    <div id='body_outer'>
      <div id='body_inner'>
        <h2>Register</h2>

        <form action='' method='POST'>
          <input name='email' type='email' placeholder='Email'>

          <input name='password' type='password' placeholder='Password'>

          <input type='submit' id='submit_button' class='box' value='Register'>
        </form>
      </div>
    </div>
  </body>


</html>
