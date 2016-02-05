<?php

  $curl = curl_init("localhost/ernest/api/question.php?question_id=" . $_REQUEST['question_id']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $question = json_decode(curl_exec($curl), true);

?>


<html>

  <head>

    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='base.css'>

  </head>

  <body>

    <div id='header_outer'>
      <h1>ernest</h1>
    </div>

    <div id='body_outer'>
      <h2><?php echo $question['question']['question']; ?></h2>
    </div>

  </body>


</html>
