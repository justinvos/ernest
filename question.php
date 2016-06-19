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
    <link rel='stylesheet' href='css/question.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  </head>
  <body>
    <span id='question_arg' class='arg'><?php echo $_GET['id']; ?></span>
    <span id='mode_arg' class='arg'><?php echo $_GET['mode']; ?></span>
    <?php
      printHeader();
    ?>
    <div id='body_wrap'>
      <h2 id='question_title'></h2>
      <ul id='answer_list'>

      </ul>

    </div>
    <script src='js/question.js'></script>
  </body>
</html>
