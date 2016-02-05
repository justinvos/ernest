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

      $query = $db->prepare("SELECT answers.id,answers.question_id,answers.answer FROM answers WHERE answers.question_id=:question_id;");

      $query->bindParam(":question_id", $question_id);
      $question_id = $_REQUEST['question_id'];

      $query->execute();
      $dataset = $query->fetchAll();

      $results['answers'] = array();

      for($i = 0; $i < sizeof($dataset); $i++)
      {
        array_push($results['answers'], array(
          'id' => $dataset['id'],
          'question_id' => $dataset['question_id'],
          'answer' => $dataset['answer']
        ));
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
    if(isset($_REQUEST['question_id']) && isset($_REQUEST['answers']))
    {
      $db = connect();

      $query = $db->prepare("INSERT INTO answers (question_id, answer) VALUES (:question_id, :answer);");

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
