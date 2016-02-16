<?php

  include('frontend.php');

  if(!isset($_REQUEST['course']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20the%20course.');
  }
  else
  {
    $curl = curl_init("localhost/ernest/api/course.php?id=" . $_REQUEST['course']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $course = json_decode(curl_exec($curl), true);

    $curl = curl_init("localhost/ernest/api/questions.php?course=" . $_REQUEST['course']);
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

          echo '<a class="question_label" href="question.php?id=' . $questions['questions'][$i]['id'] . '">';

          echo $questions['questions'][$i]['question'];

          echo '</a>';

          echo '</div>';
        }

      ?>

    </div>

  </body>


</html>
