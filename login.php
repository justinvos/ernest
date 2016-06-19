<?php
  include("frontend.php");
?>


<html>
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <title>ernest</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='css/base.css'>
    <link rel='stylesheet' href='css/login.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  </head>
  <body>
    <?php
      printHeader();
    ?>
    <div id='body_wrap'>
      <h2>Login</h2>
      <input type='email' placeholder='Email' required>
      <input type='password' placeholder='Password' required>
      <a id='login_button' class='button'>Login</a>

    </div>
    <script src='js/login.js'></script>
  </body>
</html>
