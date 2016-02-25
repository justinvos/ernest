<?php

  include("frontend.php");

  session_start();
  validate_session();


  if(!isset($_GET['course']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20the%20course.');
  }

  $curl = curl_init("localhost/ernest/api/course.php?id=" . $_REQUEST['course']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $course = json_decode(curl_exec($curl), true);

?>

<html>

  <?php print_head("Ask"); ?>

  <body>

    <?php
      print_header();

      print_bar(array(
        array("label" => "Courses", "url" => "courses.php"),
        array("label" => $course["course"]["name"], "url" => "course.php?id=" . $course["course"]["id"]),
        array("label" => "Ask")
      ));
    ?>

    <div id='body_outer'>
      <div id='body_inner'>
        <h2>Ask</h2>

        <form action='' method='POST'>
          <input id='question_box' name='question' type='text' placeholder='What question do you want to ask?'>

          <div id='answer_box_wrap'>
            <input name='answer_1' type='text' class='answer_box' placeholder='Answer'>
          </div>

          <a id='answer_button' class='rect' onclick="anotherAnswerClick();">Add another answer</a>


          <a id='ask_button' class='rect' onclick="askClick(<?php echo $_SESSION['account']; ?>,'<?php echo $_SESSION['token']; ?>', <?php echo $_GET['course']; ?>);">Ask</a>
        </form>
      </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="script/ask.js"></script>
  </body>


</html>
