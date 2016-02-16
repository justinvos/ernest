<?php

  session_start();

  include('backend.php');

  if(!isset($_REQUEST['id']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20the%20course.');
  }
  else if(isset($_SESSION['account']) && isset($_SESSION['token']))
  {
    $is_authenticated = authenticate(connect(), $_SESSION['account'], $_SESSION['token']);

    if($is_authenticated)
    {
      $curl = curl_init("localhost/ernest/api/membership.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token'] . "&course=" . $_REQUEST['id']);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $membership = json_decode(curl_exec($curl), true);

      if($membership['member'])
      {
        $curl = curl_init("localhost/ernest/api/questions.php?course=" . $_REQUEST['id']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $questions = json_decode(curl_exec($curl), true);
      }
    }
  }

  $curl = curl_init("localhost/ernest/api/course.php?id=" . $_REQUEST['id']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $course = json_decode(curl_exec($curl), true);

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
      <h3><?php echo $course['course']['name']; ?></h3>


      <?php
        if(isset($questions))
        {
          echo '<h2>Questions</h2>';

          for($i = 0; $i < sizeof($questions['questions']); $i++)
          {
            echo '<div class="row">';

            echo '<a class="question_label" href="question.php?id=' . $questions['questions'][$i]['id'] . '">';

            echo $questions['questions'][$i]['question'];

            echo '</a>';

            echo '</div>';
          }
        }
        else
        {
          echo '<h2>Course Overview</h2>';

          if($is_authenticated)
          {
            ?>
              <a class='rect' onclick='joinClick(<?php echo $_SESSION['account_id']; ?>,"<?php echo $_SESSION['token']; ?>", 1)'>Join</a>
            <?php
          }
          else
          {
            ?>
              <a class='rect' onclick='window.location = "login.php?go=" + window.location;'>Join</a>
            <?php
          }


        }


      ?>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="script/course.js"></script>
  </body>


</html>
