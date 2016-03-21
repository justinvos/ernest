<?php

  include('../backend.php');

  $results = array(
    'error' => false,
    'error_msg' => ''
  );

  if($_SERVER['REQUEST_METHOD'] == 'PUT')
  {
    parse_str(file_get_contents('php://input'), $_ARGS);


    if(isset($_ARGS['id']) && isset($_ARGS['answer']) && isset($_ARGS['account']) && isset($_ARGS['token']))
    {
      $db = connect();

      if(authenticate($db, $_ARGS['account'], $_ARGS['token']))
      {
        $query = $db->prepare("UPDATE answers SET answer=:answer WHERE id=:id;");

        $id = $_ARGS['id'];
        $answer = $_ARGS['answer'];

        $query->bindParam(":id", $id);
        $query->bindParam(":answer", $answer);

        $query->execute();
      }
    }
  }
  else
  {
    http_response_code(400);

    $results['error'] = true;
    $results['error_msg'] = 'The resource being accessed only accepts PUT requests';
  }

  echo json_encode($results);
  return;
?>
