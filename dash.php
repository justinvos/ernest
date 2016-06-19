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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  </head>
  <body>
    <?php
      printHeader();
    ?>
    <div id='body_wrap'>
      <ul id='options_list'>
        <li id='unanswered_link'>Unanswered questions</li>
        <li id='answered_link'>Answered questions</li>
        <li id='owned_link'>Your questions</li>
        <li id='createQuestion_link' class='bubble'>Create a question</li>
      </ul>
      <h2 id='page_heading'>Unanswered questions</h2>
      <ul id='question_list'>
      </ul>
    </div>
    <script src='js/dash.js'></script>

    </sc>
  </body>
</html>
