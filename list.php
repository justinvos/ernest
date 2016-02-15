<?php

  session_start();

  if(!isset($_SESSION['account_id']) || !isset($_SESSION['token']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20your%20session.%20Try%20logging%20in%20again.');
  }

  $curl = curl_init("localhost/ernest/api/session.php?account_id=" . $_SESSION['account_id'] . "&token=" . $_SESSION['token']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $session = json_decode(curl_exec($curl), true);

  if(!isset($session) || sizeof($session) == 0 || !$session['authenticated'])
  {
    header('Location: error.php?error_msg=Your%20session%20has%20expired.%20Try%20logging%20in%20again.');
  }

  if(!isset($_REQUEST['course_id']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20the%20course.');
  }
  else
  {
    $curl = curl_init("localhost/ernest/api/courses.php?course_id=" . $_REQUEST['course_id']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $course = json_decode(curl_exec($curl), true);

    $curl = curl_init("localhost/ernest/api/questions.php?course_id=" . $_REQUEST['course_id']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $questions = json_decode(curl_exec($curl), true);
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

      <h3><?php echo $course['course']['name']; ?></h3>
      <h2>Questions</h2>

      <?php

        for($i = 0; $i < sizeof($questions['questions']); $i++)
        {
          echo '<div class="row">';

          echo '<a class="question_label" href="question.php?question_id=' . $questions['questions'][$i]['id'] . '">';

          echo $questions['questions'][$i]['question'];

          echo '</a>';

          echo '</div>';
        }

      ?>

    </div>

  </body>


</html>
