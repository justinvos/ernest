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

      $query = $db->prepare("SELECT courses.id, courses.name, courses.account, courses.creation_time FROM courses WHERE courses.id=:id LIMIT 1;");

      $query->bindParam(":id", $id);
      $id = $_REQUEST['id'];

      $query->execute();
      $dataset = $query->fetchAll();

      if(sizeof($dataset) > 0)
      {
        $results['course'] = array(
          'id' => $dataset[0]['id'],
          'name' => $dataset[0]['name'],
          'account' => $dataset[0]['account'],
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
