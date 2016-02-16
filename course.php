<?php

  session_start();


  if(!isset($_REQUEST['course']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20the%20course.');
  }
  else
  {
    $curl = curl_init("localhost/ernest/api/course.php?id=" . $_REQUEST['course']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $course = json_decode(curl_exec($curl), true);
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
      <h3>COURSE</h3>
      <h2><?php echo $course['course']['name']; ?></h2>
      <a class='rect' onclick='joinClick(<?php echo $_SESSION['account_id']; ?>,"<?php echo $_SESSION['token']; ?>", 1)'>Join</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="script/course.js"></script>
  </body>


</html>
