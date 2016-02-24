<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']) && isset($_REQUEST['answer']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        $query = $db->prepare("INSERT INTO votes (account, answer, vote_time) VALUES (:account, :answer, :vote_time);");

        $query->bindParam(":account", $account);
        $query->bindParam(":answer", $answer);
        $query->bindParam(":vote_time", $vote_time);
        $account = $_REQUEST['account'];
        $answer = $_REQUEST['answer'];
        $vote_time = $_SERVER['REQUEST_TIME'];

        $query->execute();
      }
      else
      {
        http_response_code(401);

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
    $results['error_msg'] = 'The resource being accessed only accepts POST requests';
  }

  echo json_encode($results);
  return;

?>
