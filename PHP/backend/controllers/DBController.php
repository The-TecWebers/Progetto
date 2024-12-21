<?php

class DBController
{
  private static $host = "localhost";
  private static $username = "root";
  private static $password = "root";

  private static $DbName = "EdilScavi";

  private static $conn;


  public static function connect($host = "localhost", $username = "root", $password = "root", $DbName = "EdilScavi")
  {
    self::$host = $host;
    self::$username = $username;
    self::$password = $password;
    self::$DbName = $DbName;

    $conn = new mysqli($host, $username, $password, database: $DbName);
    if ($conn->connect_errno) {
      die('Connessione al DB fallita: ' . $conn->connect_error);
    }

    self::$conn = $conn;
    return $conn;

  }

  public static function runQuery($query, ...$parameters)
  {
    $conn = self::connect();
    $q = $conn->prepare($query);

    if ($q === false) {
      die('MySQL prepare error: ' . $conn->error);
    }

    if (count($parameters) > 0) {
      $q->bind_param(str_repeat("s", count($parameters)), ...$parameters);
    }

    if (!$q->execute()) {
      die('Execute error: ' . $q->error);
    }

    $result = $q->get_result();

    if ($result == false || ($result->num_rows) <= 0) {
      return false;
    }
    $result_data = $result->fetch_assoc();


    $q->close();
    $conn->close();

    return $result_data;
  }
}

?>