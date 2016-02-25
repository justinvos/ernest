<?php

  include("frontend.php");

?>


<html>

  <?php print_head("Error"); ?>

  <body>

    <?php print_header(); ?>

    <div id='body_outer'>
      <div id='body_inner'>
        <h2>Something happened, sorry.</h2>

        <?php

          if(isset($_REQUEST['type']))
          {
            if($_REQUEST['type'] == 'nosession')
            {
              echo '<p>We could not find your session.</p>';
              if(isset($_REQUEST['go']))
              {
                echo '<p>Try logging in again <a href="login.php?go=' . $_REQUEST['go'] . '">here</a></p>';
              }
              else
              {
                echo '<p>Try logging in again <a href="login.php">here</a></p>';
              }
            }
            else if($_REQUEST['type'] == 'nocourse')
            {
              echo '<p>We could not find that course.</p>';
              echo '<p>Click <a href="courses.php">here</a> to return to the courses page.</p>';
            }
            else if($_REQUEST['type'] == 'noquestion')
            {
              echo '<p>We could not find that question.<br />';
              echo 'You might not be a member of the course you are trying to access.</p>';
              echo '<p>Click <a href="courses.php">here</a> to return to the courses page.</p>';
            }
            else
            {
              echo '<p>An unknown error has occured (' . $_REQUEST['type'] . ').</p>';
              echo '<p>' . $_REQUEST['msg'] . '</p>';
            }
          }
          else
          {
            echo '<p>An unknown error has occured.</p>';
            echo '<p>' . $_REQUEST['msg'] . '</p>';
          }

        ?>

      </div>
    </div>

  </body>


</html>
