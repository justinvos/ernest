<?php
  include('../backend.php');
  $output = array(
    'error' => false,
    'status_code' => 'OK'
  );
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_REQUEST['account']) and isset($_REQUEST['passport']) and authenticate($_REQUEST['account'], $_REQUEST['passport'])) {
      if(isset($_REQUEST['question'])) {
        // Checks whether a user has attempted the specified question.
        $db = connect();
        $query = $db->prepare("SELECT attempts.id `id`, attempts.answer `answer` FROM answers LEFT JOIN attempts ON answers.id=attempts.answer WHERE answers.question=:question AND attempts.author=:author;");
        $params = array(
          'question' => $_REQUEST['question'],
          'author' => $_REQUEST['account']
        );
        $query->execute($params);
        $dataset = $query->fetchAll();
        $output['attempts'] = $dataset;
      }
    }
  } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST['account']) and isset($_REQUEST['passport']) and authenticate($_REQUEST['account'], $_REQUEST['passport'])) {
      if(isset($_REQUEST['answer'])) {
        // Submit a new attempt.
        $db = connect();
        $query = $db->prepare("INSERT INTO attempts (author, answer) VALUES (:author, :answer);");
        $params = array(
          'author' => $_REQUEST['account'],
          'answer' => $_REQUEST['answer']
        );
        $query->execute($params);
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
