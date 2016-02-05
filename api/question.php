<?php

  include('backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['question_id']))
    {
      $db = connect();

      $query = $db->prepare("SELECT questions.id,questions.account,questions.question,questions.creation_time FROM questions WHERE questions.id=:question_id;");

      $query->bindParam(":question_id", $question_id);
      $question_id = $_REQUEST['question_id'];

      $query->execute();
      return $query->fetchAll();
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
    if(isset($_REQUEST['account']) && isset($_REQUEST['question']))
    {
      $db = connect();

      $query = $db->prepare("INSERT INTO questions (account, question, creation_time) VALUES (:account, :question, :creation_time);");

      $query->bindParam(":account", $account);
      $query->bindParam(":question", $question);
      $query->bindParam(":creation_time", $creation_time);
      $account = $_REQUEST['account'];
      $question = $_REQUEST['question'];
      $creation_time = $_SERVER['REQUEST_TIME'];

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
