<?php

  include("frontend.php");

  session_start();
  validate_session();

  if(!isset($_REQUEST['id']))
  {
    header('Location: error.php?type=noquestion');
  }
  else
  {
    $curl = curl_init("localhost/ernest/api/question.php?id=" . $_REQUEST['id'] . "&account=" .  $_SESSION['account'] . "&token=" . $_SESSION['token']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $question = json_decode(curl_exec($curl), true);

    if(!$question['error'])
    {
      $curl = curl_init("localhost/ernest/api/answers.php?question=" . $_REQUEST['id']);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $answers = json_decode(curl_exec($curl), true);
    }
    else
    {
      header('Location: error.php?type=noquestion');
    }
  }

  $page_title = "Unanswered questions";
  $answered = 0;
  $owned = 0;

  if($question['question']["account"] == $_SESSION["account"])
  {
    $page_title = "Your questions";
    $owned = 1;
  }
  else if($question['question']["answered"])
  {
    $page_title = "Answered questions";
    $answered = 1;
  }
?>


<html>

  <?php print_head($question['question']['question']); ?>

  <body>

    <?php
      print_header();

      print_bar(array(
        array("label" => "Courses", "url" => "courses.php"),
        array("label" => $question['question']['course'], "url" => "course.php?id=" . $question['question']['course_id']),
        array("label" => $page_title, "url" => "questions.php?course=" . $question['question']['course_id'] . "&answered=" . $answered . "&owned=" . $owned),
        array("label" => $question["question"]["question"])
      ));
    ?>

    <div id='body_outer'>
      <div id='body_inner'>
        <h3><?php echo $question['question']['course']; ?></h3>




        <?php

          if($question['question']['account'] == $_SESSION['account'])
          {
            echo "<input type='text' placeholder='What question do you want to ask?' value='" . $question['question']['question'] . "'>";

            echo "<a class='box rect' onclick='saveClick(" . $_SESSION['account'] . "," . $_SESSION['token'] . ")'>Save</a>";
          }
          else if($question['question']['answered'] == 1)
          {
            echo "<h2>" . $question['question']['question'] . "</h2>";

            echo "<ul>";

            for($i = 0; $i < sizeof($answers['answers']); $i++)
            {
              $classes = "answer box";

              if($answers['answers'][$i]['correct'])
              {
                $classes .= " correct";
              }

              echo "<li id='answer_" . $answers['answers'][$i]['id'] . "' class='" . $classes . "'> " . $answers['answers'][$i]['answer'] . "</li>\n";
            }

            echo "</ul>";
          }
          else
          {
            echo "<h2>" . $question['question']['question'] . "</h2>";
            echo "<ul>";

            for($i = 0; $i < sizeof($answers['answers']); $i++)
            {
              echo "<li id='answer_" . $answers['answers'][$i]['id'] . "' class='answer box' onclick='answerClick(" . $answers['answers'][$i]['id'] . ");'>" . $answers['answers'][$i]['answer'] . "</li>\n";
            }

            echo "</ul>";

            echo "<a id='submit_button' class='box' onclick='submitClick(" . $_SESSION['account'] . "," . $_SESSION['token'] . ")'>Submit</a>";
          }
        ?>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src='script/question.js'></script>
  </body>


</html>
