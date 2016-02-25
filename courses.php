<?php

  include("frontend.php");

  session_start();
  validate_session();

  $curl = curl_init("localhost/ernest/api/memberships.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $memberships = json_decode(curl_exec($curl), true);

?>


<html>

  <?php print_head("Courses"); ?>

  <body>

    <?php print_header(); ?>

    <div id='body_outer'>
      <?php

        if(isset($memberships))
        {
          echo '<h2>Your Courses</h2>';

          for($i = 0; $i < sizeof($memberships['memberships']); $i++)
          {
            echo '<div class="row">';

            echo '<a class="question_label" href="course.php?id=' . $memberships['memberships'][$i]['course'] . '">';

            echo $memberships['memberships'][$i]['name'];

            echo '</a>';

            echo '</div>';
          }
        }

      ?>
    </div>

  </body>


</html>
