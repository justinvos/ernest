<?php

  include('backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['account_id']) && isset($_REQUEST['token']))
    {
      $db = connect();

      $query = $db->prepare("SELECT sessions.account, sessions.creation_time FROM sessions WHERE sessions.token=:token;");

      $query->bindParam(":token", $token);
      $token = $_REQUEST['token'];

      $query->execute();
      $dataset = $query->fetchAll();

      if(sizeof($dataset) > 0)
      {
        if($dataset[0]['creation_time'] + (30 * 60) > $_SERVER['REQUEST_TIME'])
        {
          if($dataset[0]['account'] == $_REQUEST['account_id'])
          {
            $query = $db->prepare("SELECT accounts.id, accounts.email, accounts.creation_time FROM accounts WHERE accounts.id=:account_id;");

            $query->bindParam(":account_id", $account_id);
            $account_id = $_REQUEST['account_id'];

            $query->execute();
            $dataset = $query->fetchAll();

            $results['account'] = array(
              'id' => $dataset[0]['id'],
              'email' => $dataset[0]['email'],
              'creation_time' => $dataset[0]['creation_time']
            );
          }
          else
          {
            $results['error'] = true;
            $results['error_msg'] = 'Not authorized';
          }
        }
        else
        {
          $results['error'] = true;
          $results['error_msg'] = 'Not authenticated';
        }
      }
      else
      {
        $results['error'] = true;
        $results['error_msg'] = 'Not authenticated';
      }
    }
    else
    {
      http_response_code(400);

      $results['error'] = true;
      $results['error_msg'] = 'Missing paramater(s)';
    }
  }
  else if($_SERVER['REQUEST_METHOD'] == 'POST')
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
