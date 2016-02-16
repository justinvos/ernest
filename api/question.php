<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['id']))
    {
      $db = connect();

      $query = $db->prepare("SELECT questions.id,courses.name AS `course`,questions.account,questions.question,questions.creation_time FROM questions INNER JOIN courses ON questions.course=courses.id WHERE questions.id=:id;");

      $query->bindParam(":id", $id);
      $id = $_REQUEST['id'];

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
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts GET requests';
  }

  echo json_encode($results);
  return;

?>
