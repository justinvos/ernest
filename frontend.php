<?php

  include("backend.php");

  function validate_session()
  {
    if(!isset($_SESSION['account']) || !isset($_SESSION['token']))
    {
      header('Location: error.php?type=nosession');
    }

    if(!authenticate(connect(), $_SESSION['account'], $_SESSION['token']))
    {
      header('Location: error.php?type=nosession');
    }

    return true;
  }

  function print_head($page_title)
  {
    ?>

    <head>
      <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
      <meta content="utf-8" http-equiv="encoding">

      <title><?php echo $page_title; ?> - ernest</title>

      <link rel="shortcut icon" href="e.ico">


      <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
      <link rel='stylesheet' href='base.css'>

    </head>

    <?php
  }

  function print_header()
  {
    ?>
      <div id='header_outer'>
        <div id='header_inner'>
          <h1>ernest</h1>
        </div>
      </div>
    <?php
  }

  function print_bar($levels)
  {
    ?>
      <div id='bar_outer'>
        <div id='bar_inner'>
          <ul id='breadcrumbs'>
            <?php

              for($i = 0; $i < (sizeof($levels) - 1); $i++)
              {
                echo "<li><a href='" . $levels[$i]['url'] . "'>" . $levels[$i]['label'] . "</a></li>";
              }
              echo "<li>" . $levels[$i]['label'] . "</li>";

            ?>
          </ul>
        </div>
      </div>
    <?php
  }
?>
