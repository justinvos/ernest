<?php
  include('../backend.php');
  $output = array(
    'error' => false,
    'status_code' => 'OK'
  );
  if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_REQUEST['account']) and isset($_REQUEST['passport']) and authenticate($_REQUEST['account'], $_REQUEST['passport'])) {
      if(isset($_REQUEST['course']) and isset($_REQUEST['filter']) and strtoupper($_REQUEST['filter']) == 'ANSWERED') {
        // Gets all questions answered by the current user in a course.
        $db = connect();
        $query = $db->prepare("SELECT questions.id `id`, questions.content `content`, questions.likes `likes`, questions.dislikes `dislikes`, questions.author `author`, questions.course `course` FROM questions INNER JOIN answers ON questions.id=answers.question INNER JOIN attempts ON answers.id=attempts.answer WHERE questions.course=:course AND questions.author!=:account1 AND attempts.author=:account2;");
        $params = array(
          'course' => $_REQUEST['course'],
          'account1' => $_REQUEST['account'],
          'account2' => $_REQUEST['account']
        );
        $query->execute($params);
        $dataset = $query->fetchAll();
        $output['questions'] = array();
        for($i = 0; $i < sizeof($dataset); $i++) {
          array_push($output['questions'], $dataset[$i]);
        }
      } else if(isset($_REQUEST['course']) and isset($_REQUEST['filter']) and strtoupper($_REQUEST['filter']) == 'UNANSWERED') {
        // Gets all questions unanswered by the current user in a course.
        $db = connect();
        $query = $db->prepare("SELECT questions.id, questions.content, attempts.id,attempts.author FROM questions LEFT JOIN answers ON questions.id=answers.question LEFT JOIN attempts ON answers.id=attempts.id WHERE questions.course=:course AND questions.author!=:account1 AND (attempts.author=:account2 OR attempts.author IS NULL) GROUP BY questions.id HAVING COUNT(attempts.id)=0;");
        $params = array(
          'course' => $_REQUEST['course'],
          'account1' => $_REQUEST['account'],
          'account2' => $_REQUEST['account'],
        );
        $query->execute($params);
        $dataset = $query->fetchAll();
        $output['questions'] = array();
        for($i = 0; $i < sizeof($dataset); $i++) {
          array_push($output['questions'], $dataset[$i]);
        }
      } else if(isset($_REQUEST['filter']) and strtoupper($_REQUEST['filter']) == 'AUTHORED') {
        // Gets all questions authored by the current user in a course.
        $db = connect();
        $query = $db->prepare("SELECT questions.id `id`, questions.content `content`, questions.likes `likes`, questions.dislikes `dislikes`, questions.author `author`, questions.course `course` FROM questions WHERE questions.course=:course AND questions.author=:account;");
        $params = array(
          'course' => $_REQUEST['course'],
          'account' => $_REQUEST['account']
        );
        $query->execute($params);
        $dataset = $query->fetchAll();
        $output['questions'] = array();
        for($i = 0; $i < sizeof($dataset); $i++) {
          array_push($output['questions'], $dataset[$i]);
        }
      }
    } else if(isset($_REQUEST['course'])) {
      // Gets all questions in a course.
      $db = connect();
      $query = $db->prepare("SELECT questions.id `id`, questions.content `content`, questions.likes `likes`, questions.dislikes `dislikes`, questions.author `author`, questions.course `course` FROM questions WHERE questions.course=:course;");
      $params = array(
        'course' => $_REQUEST['course']
      );
      $query->execute($params);
      $dataset = $query->fetchAll();
      $output['questions'] = array();
      for($i = 0; $i < sizeof($dataset); $i++) {
        array_push($output['questions'], $dataset[$i]);
      }
    } else if(isset($_REQUEST['id'])) {
      // Gets a specific question.
      $db = connect();
      $query = $db->prepare("SELECT questions.id `id`, questions.content `content`, questions.likes `likes`, questions.dislikes `dislikes`, questions.author `author`, questions.course `course` FROM questions WHERE questions.id=:id LIMIT 1;");
      $params = array('id' => $_REQUEST['id']);
      $query->execute($params);
      $dataset = $query->fetchAll();
      $output['question'] = $dataset[0];
    } else {
      $output['error'] = true;
      $output['status_code'] = 'INVALID_REQUEST';
    }
  } else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_REQUEST['account']) and isset($_REQUEST['passport']) and authenticate($_REQUEST['account'], $_REQUEST['passport'])) {
      if(isset($_REQUEST['content']) and isset($_REQUEST['course'])) {
        // Creates a new question.
        $db = connect();
        $query = $db->prepare("INSERT INTO questions (content, author, course) VALUES (:content, :author, :course);");
        $params = array(
          'content' => $_REQUEST['content'],
          'author' => $_REQUEST['author'],
          'course' => $_REQUEST['course']
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
