<?php
  function connect()
  {
    $config = json_decode(file_get_contents('../config.json'), true);

    $db = new PDO('mysql:host=' . $config['db_address'] . ';dbname=' . $config['db_name'] . ';charset=utf8', $config['db_username'], $config['db_password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $db;
  }
?>
