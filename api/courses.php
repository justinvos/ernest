<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'GET')
  {
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        $query = $db->prepare("SELECT courses.id, courses.name, courses.account, courses.creation_time FROM courses WHERE courses.account=:account;");

        $query->bindParam(":account", $account);
        $account = $_REQUEST['account'];

        $query->execute();
        $dataset = $query->fetchAll();

        if(sizeof($dataset) > 0)
        {
          $results['courses'] = array();

          for($i = 0; $i < sizeof($dataset); $i++)
          {
            array_push($results['courses'], array(
              'id' => $dataset[$i]['id'],
              'name' => $dataset[$i]['name'],
              'account' => $dataset[$i]['account'],
              'creation_time' => $dataset[$i]['creation_time']
            ));
          }
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
