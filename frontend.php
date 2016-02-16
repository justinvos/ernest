<?php

  session_start();

  if(!isset($_SESSION['account']) || !isset($_SESSION['token']))
  {
    header('Location: error.php?error_msg=Could%20not%20find%20your%20session.%20Try%20logging%20in%20again.');
  }

  $curl = curl_init("localhost/ernest/api/session.php?account=" . $_SESSION['account'] . "&token=" . $_SESSION['token']);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $session = json_decode(curl_exec($curl), true);

  if(!isset($session) || sizeof($session) == 0 || !$session['authenticated'])
  {
    header('Location: error.php?error_msg=Your%20session%20has%20expired.%20Try%20logging%20in%20again.');
  }

?>
