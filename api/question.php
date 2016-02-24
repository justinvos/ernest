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
        $query = $db->prepare("SELECT questions.id,courses.name AS `course`,questions.account,questions.question,questions.creation_time FROM questions INNER JOIN courses ON questions.course=courses.id INNER JOIN memberships ON questions.course=memberships.course WHERE questions.id=:id LIMIT 1;");

        $query->bindParam(":id", $id);
        $id = $_REQUEST['id'];

        $query->execute();
        $dataset = $query->fetchAll();

        if(sizeof($dataset) > 0)
        {
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
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts GET requests';
  }

  echo json_encode($results);
  return;

?>
