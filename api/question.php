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

      $query = $db->prepare("SELECT questions.id,courses.name AS `course`,questions.account,questions.question,questions.creation_time FROM questions INNER JOIN courses ON questions.course=courses.id WHERE questions.id=:question_id;");

      $query->bindParam(":question_id", $question_id);
      $question_id = $_REQUEST['question_id'];

      $query->execute();
      $dataset = $query->fetchAll();

      $results['question'] = array(
        'id' => $dataset[0]['id'],
        'course' => $dataset[0]['course'],
        'account' => $dataset[0]['account'],
        'question' => $dataset[0]['question'],
        'creation_time' => $dataset[0]['creation_time']
      );
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
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']) && isset($_REQUEST['question']) && isset($_REQUEST['course']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        $query = $db->prepare("INSERT INTO questions (course, account, question, creation_time) VALUES (:course, :account, :question, :creation_time);");

        $query->bindParam(":course", $course);
        $query->bindParam(":account", $account);
        $query->bindParam(":question", $question);
        $query->bindParam(":creation_time", $creation_time);

        $course = $_REQUEST['course'];
        $account = $_REQUEST['account'];
        $question = $_REQUEST['question'];
        $creation_time = $_SERVER['REQUEST_TIME'];

        $query->execute();

        $results['question'] = $db->lastInsertId();
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
