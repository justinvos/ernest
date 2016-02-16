<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
    {
      $db = connect();

      $query = $db->prepare("INSERT INTO accounts (email, password, salt, creation_time) VALUES (:email, :password, :salt, :creation_time);");


      $email = $_REQUEST['email'];
      $salt = mt_rand();
      $password = md5($_REQUEST['password'] . $salt);
      $creation_time = $_SERVER['REQUEST_TIME'];

      $query->bindParam(":email", $email);
      $query->bindParam(":password", $password);
      $query->bindParam(":salt", $salt);
      $query->bindParam(":creation_time", $creation_time);

      $query->execute();
    }
    else
    {
      http_response_code(400);

      $results['error'] = true;
      $results['error_msg'] = 'Missing paramater(s)';
    }
  }
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts GET requests';
  }

  echo json_encode($results);
  return;

?>
