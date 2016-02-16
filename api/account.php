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

      if(authenticate($db $_REQUEST['account_id'], $_REQUEST['token'];))
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
