<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['id']) && isset($_REQUEST['account']) && isset($_REQUEST['token']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        $query = $db->prepare("SELECT questions.id,courses.id AS `course_id`, courses.name AS `course`,questions.account,questions.question,questions.creation_time, COUNT(votes.id) > 0 AS `answered` FROM questions INNER JOIN courses ON questions.course=courses.id INNER JOIN memberships ON questions.course=memberships.course INNER JOIN answers ON questions.id=answers.question LEFT JOIN votes ON answers.id=votes.answer WHERE questions.id=:id AND (votes.account=:account OR votes.account IS NULL) GROUP BY questions.id LIMIT 1;");

        $query->bindParam(":id", $id);
        $id = $_REQUEST['id'];

        $query->bindParam(":account", $account);
        $account = $_REQUEST['account'];

        $query->execute();
        $dataset = $query->fetchAll();

        if(sizeof($dataset) > 0)
        {
          $results['question'] = array(
            'id' => $dataset[0]['id'],
            'course_id' => $dataset[0]['course_id'],
            'course' => $dataset[0]['course'],
            'account' => $dataset[0]['account'],
            'question' => $dataset[0]['question'],
            'creation_time' => $dataset[0]['creation_time'],
            'answered' => $dataset[0]['answered']
          );
        }
        else
        {
          http_response_code(404);

          $results['error'] = true;
          $results['error_msg'] = 'Not Found';
        }
      }
    }
    else
    {
      http_response_code(400);

      $results['error'] = true;
      $results['error_msg'] = 'Missing paramater(s)';
    }
  }
  else if($_SERVER['REQUEST_METHOD'] == "PUT")
  {
    parse_str(file_get_contents('php://input'), $_ARGS);


    if(isset($_ARGS['id']) && isset($_ARGS['question']) && isset($_ARGS['account']) && isset($_ARGS['token']))
    {
      $db = connect();

      if(authenticate($db, $_ARGS['account'], $_ARGS['token']))
      {
        $query = $db->prepare("UPDATE questions SET question=:question WHERE id=:id;");

        $id = $_ARGS['id'];
        $question = $_ARGS['question'];

        $query->bindParam(":id", $id);
        $query->bindParam(":question", $question);

        $query->execute();
      }
    }
  }
  else if($_SERVER['REQUEST_METHOD'] == "DELETE")
  {
    parse_str(file_get_contents('php://input'), $_ARGS);


    if(isset($_ARGS['id']) && isset($_ARGS['account']) && isset($_ARGS['token']))
    {
      $db = connect();

      if(authenticate($db, $_ARGS['account'], $_ARGS['token']))
      {
        $query = $db->prepare("DELETE FROM questions WHERE id=:id;");

        $id = $_ARGS['id'];

        $query->bindParam(":id", $id);

        $query->execute();
      }
    }
  }
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts GET, PUT and DELETE requests';
  }

  echo json_encode($results);
  return;

?>
