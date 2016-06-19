<?php
  include('../backend.php');
  $output = array(
    'error' => false,
    'status_code' => 'OK'
  );
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_REQUEST['account']) and isset($_REQUEST['passport']) and authenticate($_REQUEST['account'], $_REQUEST['passport'])) {
      if(isset($_REQUEST['question'])) {
        // Gets all answers associated with a specific question.
        $db = connect();
        $query = $db->prepare("SELECT answers.id `id`, answers.content `content`, answers.question `question`, answers.correct `correct` FROM answers WHERE answers.question=:question;");
        $params = array('question' => $_REQUEST['question']);
        $query->execute($params);
        $dataset = $query->fetchAll();
        $output['answers'] = array();
        for($i = 0; $i < sizeof($dataset); $i++) {
          array_push($output['answers'], $dataset[$i]);
        }
      }
    } else {
      $output['error'] = true;
      $output['status_code'] = 'INVALID_REQUEST';
    }
  } else {
    $output['error'] = true;
    $output['status_code'] = 'INVALID_METHOD';
  }
  echo json_encode($output);
  return;
?>
