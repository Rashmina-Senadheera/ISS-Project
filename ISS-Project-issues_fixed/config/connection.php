<?php

// $connection = $_ENV['DB_CONNECTION'];
// $host = $_ENV['DB_HOST'];
// $username = $_ENV['DB_USER'];
// $password = $_ENV['DB_PASSWORD'];
// $dbname = $_ENV['DB_NAME'];
// $encoding = $_ENV['DB_ENCODING'];

define('DB_HOST','localhost');
define('DB_CONNECTION', 'mysql');
define('DB_ENCODING', 'utf8');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','contract_order');

function connect()
{
     try {
          // PDO instance
          $dsn = DB_CONNECTION . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_ENCODING;
          $dbh = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
          // enable errors in the form of exceptions
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // set default fetch mode as object
          $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
          // disable emulation mode
          $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          return $dbh;
     } catch (PDOException $e) {
          return "Connection failed: " . $e->getMessage();
     }
}
