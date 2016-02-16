<?php

  include('backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']) && isset($_REQUEST['question_id']) && isset($_REQUEST['answers']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        $query = $db->prepare("INSERT INTO answers (question, answer) VALUES (:question_id, :answer);");

        $query->bindParam(":question_id", $question_id);
        $query->bindParam(":answer", $answer);

        $answers = explode(chr(31), $_REQUEST['answers']);

        $question_id = $_REQUEST['question_id'];

        for($i = 0; $i < sizeof($answers); $i++)
        {
          $answer = $answers[$i];

          $query->execute();
        }
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
    $results['error_msg'] = 'The resource being accessed only accepts GET requests';
  }

  echo json_encode($results);
  return;

?>
