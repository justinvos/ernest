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

      <?php

        if(isset($_REQUEST['type']))
        {
          if($_REQUEST['type'] == 'nosession')
          {
            echo '<p>We could not find your session.</p>';
            if(isset($_REQUEST['go']))
            {
              echo '<p>Try logging in again <a href="login.php?go=' . $_REQUEST['go'] . '">here</a></p>';
            }
            else
            {
              echo '<p>Try logging in again <a href="login.php">here</a></p>';
            }
          }
          else if($_REQUEST['type'] == 'nocourse')
          {
            echo '<p>We could not find that course.</p>';
            echo '<p>Click <a href="courses.php">here</a> to return to the courses page.</p>';
          }
          else if($_REQUEST['type'] == 'noquestion')
          {
            echo '<p>We could not find that question.<br />';
            echo 'You might not be a member of the course you are trying to access.</p>';
            echo '<p>Click <a href="courses.php">here</a> to return to the courses page.</p>';
          }
          else
          {
            echo '<p>An unknown error has occured (' . $_REQUEST['type'] . ').</p>';
            echo '<p>' . $_REQUEST['msg'] . '</p>';
          }
        }
        else
        {
          echo '<p>An unknown error has occured.</p>';
          echo '<p>' . $_REQUEST['msg'] . '</p>';
        }

      ?>


    </div>

  </body>


</html>
