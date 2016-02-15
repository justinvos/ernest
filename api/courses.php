<?php

  include('backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['course_id']))
    {
      $db = connect();

      $query = $db->prepare("SELECT courses.id, courses.name, courses.account, courses.creation_time FROM courses WHERE courses.id=:course_id;");

      $query->bindParam(":course_id", $course_id);
      $course_id = $_REQUEST['course_id'];

      $query->execute();
      $dataset = $query->fetchAll();

      $results['course'] = array(
        'id' => $dataset[0]['id'],
        'name' => $dataset[0]['name'],
        'account' => $dataset[0]['account'],
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
    if(isset($_REQUEST['name']) && isset($_REQUEST['account']))
    {
      $db = connect();

      $query = $db->prepare("INSERT INTO courses (name, account, creation_time) VALUES (:name, :account, :creation_time);");

      $query->bindParam(":name", $name);
      $query->bindParam(":account", $account);
      $query->bindParam(":creation_time", $creation_time);
      $name = $_REQUEST['name'];
      $account = $_REQUEST['account'];
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
    $results['error_msg'] = 'The resource being accessed only accepts GET and POST requests';
  }

  echo json_encode($results);
  return;

?>
