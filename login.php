<?php

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

    header('Location: courses.php');
  }

?>


<html>

  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">

    <title>ernest</title>

    <link rel="shortcut icon" href="e.ico">


    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='base.css'>

  </head>

  <body>

    <div id='header_outer'>
      <h1>ernest</h1>
    </div>

    <div id='body_outer'>
      <h2>Login</h2>

      <form action='' method='POST'>
        <input name='email' type='email' placeholder='Email'>

        <input name='password' type='password' placeholder='Password'>

        <input type='submit' id='submit_button' class='box' value='Login'>
      </form>

    </div>
  </body>


</html>
