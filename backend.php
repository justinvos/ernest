<?php
  function connect() {
    $config = json_decode(file_get_contents('http://localhost/ernest/config.json'), true);
    $db = new PDO('mysql:host=' . $config['db_address'] . ';dbname=' . $config['db_name'] . ';charset=utf8', $config['db_username'], $config['db_password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
  }
  function authenticate($account, $key, $output) {
    $db = connect();
    $query = $db->prepare("SELECT sessions.timestamp `timestamp` FROM sessions WHERE sessions.owner=:account AND sessions.key=:key LIMIT 1;");
    $params = array('account' => $account, 'key' => $key);
    $query->execute($params);
    $dataset = $query->fetchAll();
    if(sizeof($dataset) > 0) {
      if($dataset[0]['timestamp'] + (5 * 60 * 60) > time()) {
        return true;
      }
    }
    return false;
  }
?>
