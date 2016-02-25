<?php

  include("frontend.php");

  if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
  {
    $params = array(
      'email' => $_REQUEST['email'],
      'password' => $_REQUEST['password']
    );

    $curl = curl_init("localhost/ernest/api/session.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl,CURLOPT_POST, sizeof($params));
    curl_setopt($curl,CURLOPT_POSTFIELDS, $params);
    $session = json_decode(curl_exec($curl), true);

    session_start();

    $_SESSION['account'] = $session['account'];
    $_SESSION['token'] = $session['token'];


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
        <h2>Login</h2>

        <form action='' method='POST'>
          <input name='email' type='email' placeholder='Email'>

          <input name='password' type='password' placeholder='Password'>

          <input type='submit' id='submit_button' class='box' value='Login'>
        </form>
      </div>
    </div>
  </body>


</html>
