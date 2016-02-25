<?php

  include('frontend.php');

  session_start();
  validate_session();


  if(isset($_REQUEST['course']))
  {
    $curl = curl_init("localhost/ernest/api/membership.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token'] . "&course=" . $_REQUEST['course']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $membership = json_decode(curl_exec($curl), true);

    if($membership['member'])
    {
      if(!isset($_REQUEST['answered']))
      {
        $_REQUEST['answered'] = 0;
      }

      if(!isset($_REQUEST['owned']))
      {
        $_REQUEST['owned'] = 0;
      }

      $curl = curl_init("localhost/ernest/api/questions.php?course=" . $_REQUEST['course'] . "&account=" . $_SESSION['account'] . "&token=" . $_SESSION['token'] . "&answered=" . $_REQUEST['answered'] . "&owned=" . $_REQUEST['owned']);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $questions = json_decode(curl_exec($curl), true);

      $curl = curl_init("localhost/ernest/api/course.php?id=" . $_REQUEST['course']);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $course = json_decode(curl_exec($curl), true);
    }
    else
    {
      header('Location: course.php?id=' . $_REQUEST['course']);
    }
  }
  else
  {
    header('Location: error.php?type=nocourse');
  }

  $page_title = "Unanswered questions";

  if($_REQUEST["owned"] == 1)
  {
    $page_title = "Your questions";
  }
  else if($_REQUEST["answered"] == 1)
  {
    $page_title = "Answered questions";
  }


?>


<html>

  <?php print_head($page_title); ?>

  <body>

    <?php
      print_header();

      print_bar(array(
        array("label" => "Courses", "url" => "courses.php"),
        array("label" => $course["course"]["name"], "url" => "course.php?id=" . $course["course"]["id"]),
        array("label" => $page_title)
      ));
    ?>

    <div id='body_outer'>
      <div id='body_inner'>
        <h3><?php echo $course['course']['name']; ?></h3>


        <?php
          if(isset($questions))
          {
            echo "<h2>" . $page_title . "</h2>";

            for($i = 0; $i < sizeof($questions['questions']); $i++)
            {
              echo '<div class="row">';

              echo '<a class="question_label" href="question.php?id=' . $questions['questions'][$i]['id'] . '">';

              echo $questions['questions'][$i]['question'];

              echo '</a>';

              echo '</div>';
            }
          }
          else
          {
            echo '<h2>Course Overview</h2>';

            if($is_authenticated)
            {
              ?>
                <a class='rect' onclick='joinClick(<?php echo $_SESSION['account']; ?>,"<?php echo $_SESSION['token']; ?>", <?php echo $_REQUEST['course']; ?>)'>Join</a>
              <?php
            }
            else
            {
              ?>
                <a class='rect' onclick='window.location = "login.php?go=" + window.location;'>Join</a>
              <?php
            }


          }


        ?>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="script/base.js"></script>
    <script src="script/course.js"></script>
  </body>


</html>
