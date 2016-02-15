<?php


?>


<html>

  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">

    <title>Error - ernest</title>

    <link rel="shortcut icon" href="e.ico">

    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='base.css'>

  </head>

  <body>

    <div id='header_outer'>
      <h1>ernest</h1>
    </div>

    <div id='body_outer'>
      <h2>Something happened, sorry.</h2>
      <p><?php echo $_REQUEST['error_msg']; ?></p>
    </div>

  </body>


</html>
