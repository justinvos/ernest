<?php

  include('backend.php');

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
        $query = $db->prepare("SELECT memberships.id,courses.name,memberships.moderator FROM memberships INNER JOIN courses ON memberships.course=courses.id WHERE memberships.account=:account;");

        $query->bindParam(":account", $account);
        $account = $_REQUEST['account'];

        $query->execute();
        $dataset = $query->fetchAll();

        $results['memberships'] = array();

        for($i = 0; $i < sizeof($dataset); $i++)
        {
          array_push($results['memberships'], array(
            'id' => $dataset[$i]['id'],
            'course' => $dataset[$i]['name'],
            'moderator' => $dataset[$i]['moderator']
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
    if(isset($_REQUEST['account']) && isset($_REQUEST['token']) && isset($_REQUEST['course']) && isset($_REQUEST['moderator']))
    {
      $db = connect();

      if(authenticate($db, $_REQUEST['account'], $_REQUEST['token']))
      {
        $query = $db->prepare("INSERT INTO memberships (account, course, moderator) VALUES (:account, :course, :moderator);");

        $query->bindParam(":account", $account);
        $query->bindParam(":course", $course);
        $query->bindParam(":moderator", $moderator);

        $account = $_REQUEST['account'];
        $course = $_REQUEST['course'];
        $moderator = $_REQUEST['moderator'];

        $query->execute();
      }
      else
      {
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
