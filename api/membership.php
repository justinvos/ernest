<?php

  include('backend.php');

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
        $query = $db->prepare("SELECT memberships.id FROM memberships INNER JOIN courses ON memberships.course=courses.id WHERE memberships.account=:account AND memberships.course=:course LIMIT 1;");

        $query->bindParam(":account", $account);
        $query->bindParam(":course", $course);
        $account = $_REQUEST['account'];
        $course = $_REQUEST['course'];

        $query->execute();
        $dataset = $query->fetchAll();

        if(sizeof($dataset) > 0)
        {
          $results['member'] = true;
        }
        else
        {
          $results['member'] = false;
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
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts GET requests';
  }

  echo json_encode($results);
  return;

?>
