
<html>
  <head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <title>ernest</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,300' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='css/base.css'>
    <link rel='stylesheet' href='css/quiz.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  </head>
  <body>
    <span id='course_arg' class='arg'><?php echo $_GET['course']; ?></span>

    <div id='body_wrap'>
      <h2 id='question_title'></h2>
      <ul id='question_list'>
      </ul>

    </div>
    <script src='js/quiz.js'></script>
  </body>
</html>
