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

  if(!isset($_GET['course']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20the%20course.');
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
      <h2>Ask</h2>

      <form action='' method='POST'>
        <input id='question_box' name='question' type='text' placeholder='What question do you want to ask?'>

        <div id='answer_box_wrap'>
          <input name='answer_1' type='text' class='answer_box' placeholder='Answer'>
        </div>

        <a id='answer_button' class='rect' onclick="anotherAnswerClick();">Add another answer</a>


        <a id='ask_button' class='rect' onclick="askClick(<?php echo $_SESSION['account_id']; ?>,'<?php echo $_SESSION['token']; ?>', <?php echo $_GET['course']; ?>);">Ask</a>
      </form>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="script/ask.js"></script>
  </body>


</html>
