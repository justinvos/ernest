<?php
  function connect()
  {
    $config = json_decode(file_get_contents('../config.json'), true);

    $db = new PDO('mysql:host=' . $config['db_address'] . ';dbname=' . $config['db_name'] . ';charset=utf8', $config['db_username'], $config['db_password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $db;
  }

  function init()
  {
    $db = connect();

    $query = $db->prepare("DROP TABLE IF EXISTS votes;");
    $query->execute();

    $query = $db->prepare("DROP TABLE IF EXISTS answers;");
    $query->execute();

    $query = $db->prepare("DROP TABLE IF EXISTS questions;");
    $query->execute();


    $query = $db->prepare("DROP TABLE IF EXISTS sessions;");
    $query->execute();

    $query = $db->prepare("DROP TABLE IF EXISTS accounts;");
    $query->execute();


    $query = $db->prepare("CREATE TABLE votes (id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, account INT(10) UNSIGNED, answer INT(10) UNSIGNED, vote_time INT(10) UNSIGNED);");
    $query->execute();

    $query = $db->prepare("CREATE TABLE answers (id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, question INT(10) UNSIGNED, answer VARCHAR(140));");
    $query->execute();

    $query = $db->prepare("CREATE TABLE questions (id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, account INT(10) UNSIGNED, question VARCHAR(140), creation_time INT(10) UNSIGNED);");
    $query->execute();


    $query = $db->prepare("CREATE TABLE sessions (id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, account INT(10) UNSIGNED, creation_time INT(10) UNSIGNED);");
    $query->execute();

    $query = $db->prepare("CREATE TABLE accounts (id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, email VARCHAR(254), password VARCHAR(32), creation_time INT(10) UNSIGNED);");
    $query->execute();
  }
?>
