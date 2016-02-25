<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']) && isset($_REQUEST['course']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        if(isset($_REQUEST['answered']) && $_REQUEST['answered'] == 1)
        {
          $query = $db->prepare("SELECT DISTINCT questions.id, questions.question, questions.creation_time FROM questions INNER JOIN answers ON questions.id=answers.question INNER JOIN votes ON answers.id=votes.answer WHERE questions.course=:course AND votes.account=:account;");
        }
        else if(isset($_REQUEST['owned']) && $_REQUEST['owned'] == 1)
        {
          $query = $db->prepare("SELECT DISTINCT questions.id, questions.question, questions.creation_time FROM questions WHERE questions.course=:course AND questions.account=:account;");
        }
        else
        {
          $query = $db->prepare("SELECT questions.id, questions.question, questions.creation_time FROM questions INNER JOIN answers ON questions.id=answers.question LEFT JOIN votes ON answers.id=votes.answer WHERE questions.course=1 AND (votes.account=1 OR votes.account IS NULL) GROUP BY questions.id HAVING COUNT(votes.id)=0;");
        }

        $query->bindParam(":course", $course);
        $course = $_REQUEST['course'];

        $query->bindParam(":account", $account);
        $account = $_REQUEST['account'];

        $query->execute();
        $dataset = $query->fetchAll();

        $results['questions'] = array();

        for($i = 0; $i < sizeof($dataset); $i++)
        {
          array_push($results['questions'], array(
            'id' => $dataset[$i]['id'],
            'question' => $dataset[$i]['question'],
            'creation_time' => $dataset[$i]['creation_time']
          ));
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
    $results['error_msg'] = 'The resource being accessed only accepts GET and POST requests';
  }

  echo json_encode($results);
  return;

?>
