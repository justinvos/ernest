<?php


  $curl = curl_init("localhost/ernest/api/question.php?question_id=" . $_REQUEST['question_id']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $question = json_decode(curl_exec($curl), true);

  $curl = curl_init("localhost/ernest/api/answer.php?question_id=" . $_REQUEST['question_id']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $answers = json_decode(curl_exec($curl), true);
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
      <h3>COMPSCI 280</h3>
      <h2><?php echo $question['question']['question']; ?></h2>
      <ul>
        <?php

          for($i = 0; $i < sizeof($answers['answers']); $i++)
          {
            echo "<li id='answer_" . $answers['answers'][$i]['id'] . "' class='answer box' onclick='answerClick(" . $answers['answers'][$i]['id'] . ");'>" . $answers['answers'][$i]['answer'] . "</li>\n";
          }

        ?>

      </ul>

      <a id='submit_button' class='box' onclick='submitClick(1,"60abb7eb18c10cf0745ee5f492ecf221")'>Submit</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src='question.js'></script>
  </body>


</html>
