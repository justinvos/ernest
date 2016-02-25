<?php

  session_start();

  include('frontend.php');

  if(!isset($_REQUEST['id']))
  {
    header('Location: error.php?type=nocourse');
  }
  else if(isset($_SESSION['account']) && isset($_SESSION['token']))
  {

    $is_authenticated = authenticate(connect(), $_SESSION['account'], $_SESSION['token']);

    if($is_authenticated)
    {
      $curl = curl_init("localhost/ernest/api/membership.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token'] . "&course=" . $_REQUEST['id']);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $membership = json_decode(curl_exec($curl), true);
    }
  }


  $curl = curl_init("localhost/ernest/api/course.php?id=" . $_REQUEST['id']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $course = json_decode(curl_exec($curl), true);

  if($course['error'])
  {
    header('Location: error.php?type=nocourse');
  }
?>


<html>

  <?php print_head($course["course"]["name"]); ?>

  <body>

    <?php
      print_header();

      print_bar(array(array("label" => "Courses", "url" => "courses.php"), array("label" => $course["course"]["name"])));
    ?>



    <div id='body_outer'>
      <div id='body_inner'>
        <h3><?php echo $course['course']['name']; ?></h3>


        <?php

          if($is_authenticated)
          {
            if($membership['member'])
            {
              echo '<p><a href="questions.php?course=' . $_REQUEST['id'] . '&owned=1">Your questions</a></p>';
              echo '<p><a href="questions.php?course=' . $_REQUEST['id'] . '">Unanswered questions</a></p>';
              echo '<p><a href="questions.php?course=' . $_REQUEST['id'] . '&answered=1">Answered questions</a></p>';
              echo '<a href="ask.php?course=' . $_REQUEST['id'] . '" class="rect">Ask a question</a>';
            }
            else
            {
              ?>
                <a class='rect' onclick='joinClick(<?php echo $_SESSION['account']; ?>,"<?php echo $_SESSION['token']; ?>", <?php echo $_REQUEST['course']; ?>)'>Join</a>
              <?php
            }
          }
          else
          {
            ?>
              <a class='rect' onclick='window.location = "login.php?go=" + window.location;'>Join</a>
            <?php
          }
        ?>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="script/base.js"></script>
    <script src="script/course.js"></script>
  </body>


</html>
