<?php

  session_start();

  if(!isset($_SESSION['account']) || !isset($_SESSION['token']))
  {
    header('Location: error.php?type=nosession');
  }

  $curl = curl_init("localhost/ernest/api/session.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $session = json_decode(curl_exec($curl), true);

  if(!isset($session) || sizeof($session) == 0 || !$session['authenticated'])
  {
    header('Location: error.php?type=nosession');
  }

  $curl = curl_init("localhost/ernest/api/memberships.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $memberships = json_decode(curl_exec($curl), true);

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
      <?php

        if(isset($memberships))
        {
          echo '<h2>Your Courses</h2>';

          for($i = 0; $i < sizeof($memberships['memberships']); $i++)
          {
            echo '<div class="row">';

            echo '<a class="question_label" href="course.php?id=' . $memberships['memberships'][$i]['course'] . '">';

            echo $memberships['memberships'][$i]['name'];

            echo '</a>';

            echo '</div>';
          }
        }

      ?>
    </div>

  </body>


</html>
