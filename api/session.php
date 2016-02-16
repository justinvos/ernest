<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']))
    {
      $db = connect();

      $results['authenticated'] = authenticate($db, $_REQUEST['account'], $_REQUEST['token']);
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

      $query = $db->prepare("SELECT accounts.id, accounts.password, accounts.salt FROM accounts WHERE accounts.email=:email LIMIT 1;");

      $query->bindParam(":email", $email);
      $email = $_REQUEST['email'];

      $query->execute();
      $dataset = $query->fetchAll();

      if(sizeof($dataset) > 0)
      {
        if(md5($_REQUEST['password'] . $dataset[0]['salt']) == $dataset[0]['password'])
        {
          $query = $db->prepare("DELETE FROM sessions WHERE account=:account;");

          $account = $dataset[0]['id'];

          $query->bindParam(":account", $account);

          $query->execute();

          $query = $db->prepare("INSERT INTO sessions (account, token, creation_time) VALUES (:account, :token, :creation_time);");

          $account = $dataset[0]['id'];
          $token = md5(mt_rand());
          $creation_time = $_SERVER['REQUEST_TIME'];


          $query->bindParam(":account", $account);
          $query->bindParam(":token", $token);
          $query->bindParam(":creation_time", $creation_time);

          $query->execute();



          $results['account'] = $account;
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
  else if($_SERVER['REQUEST_METHOD'] == "DELETE")
  {
    parse_str(file_get_contents('php://input'), $_ARGS);

    if(isset($_ARGS['account']) && isset($_ARGS['token']))
    {
      $db = connect();

      if(authenticate($db, $_ARGS['account'], $_ARGS['token']))
      {
        $query = $db->prepare("DELETE FROM sessions WHERE account=:account AND token=:token;");

        $account = $_ARGS['account'];
        $token = $_ARGS['token'];

        $query->bindParam(":account", $account);
        $query->bindParam(":token", $token);

        $query->execute();
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
