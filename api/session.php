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

      $query = $db->prepare("SELECT sessions.token, sessions.creation_time FROM sessions WHERE sessions.account=:account_id;");

      $query->bindParam(":account_id", $account_id);
      $account_id = $_REQUEST['account_id'];

      $query->execute();
      $dataset = $query->fetchAll();

      $results['authenticated'] = false;

      if(sizeof($dataset) > 0)
      {
        if($_REQUEST['token'] == $dataset[0]['token'])
        {
          if($dataset[0]['creation_time'] + (30 * 60) > $_SERVER['REQUEST_TIME'])
          {
            $results['authenticated'] = true;
          }
          else
          {
            $query = $db->prepare("DELETE FROM sessions WHERE sessions.account=:account_id AND sessions.token=:token;");

            $query->bindParam(":account_id", $account_id);
            $account_id = $_REQUEST['account_id'];
            $query->bindParam(":token", $token);
            $token = $_REQUEST['token'];

            $query->execute();

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

      $query = $db->prepare("SELECT accounts.id, accounts.password, accounts.salt FROM accounts WHERE accounts.email=:email;");

      $query->bindParam(":email", $email);
      $email = $_REQUEST['email'];

      $query->execute();
      $dataset = $query->fetchAll();

      if(sizeof($dataset) > 0)
      {
        if(md5($_REQUEST['password'] . $dataset[0]['salt']) == $dataset[0]['password'])
        {
          $query = $db->prepare("INSERT INTO sessions (account, token, creation_time) VALUES (:account, :token, :creation_time);");

          $account = $dataset[0]['id'];
          $token = md5(mt_rand());
          $creation_time = $_SERVER['REQUEST_TIME'];


          $query->bindParam(":account", $account);
          $query->bindParam(":token", $token);
          $query->bindParam(":creation_time", $creation_time);

          $query->execute();

          $results['account_id'] = $account;
          $results['token'] = $token;
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
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts GET requests';
  }

  echo json_encode($results);
  return;

?>
