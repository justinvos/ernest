<?php

  session_start();

  if(!isset($_SESSION['account']) || !isset($_SESSION['token']))
  {
    header('Location: error.php?type=nosession');
  }

  $curl = curl_init("localhost/ernest/api/session.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $session = json_decode(curl_exec($curl), true);

  if(!isset($session) || sizeof($session) == 0 || !$session['authenticated'])
  {
    header('Location: error.php?type=nosession');
  }

?>
