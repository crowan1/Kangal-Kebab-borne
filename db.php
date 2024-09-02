<?php
  $host_name = 'db5016280946.hosting-data.io';
  $database = 'dbs13246623';
  $user_name = 'dbu2522742';
  $password = 'Azerty.54700';
  $dbh = null;

  try {
    $pdo = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Erreur!:" . $e->getMessage() . "<br/>";
    die();
  }
