<?php

class DBController
{
  private static $conn;

  /**
   * Restituisce la configurazione DB dalle variabili d'ambiente.
   * Se le variabili non sono impostate, usa i default per sviluppo locale.
   */
  private static function getConfig(): array
  {
    return [
      'host'     => getenv('DB_HOST')     ?: 'localhost',
      'port'     => getenv('DB_PORT')     ?: '3306',
      'username' => getenv('DB_USER')     ?: 'root',
      'password' => getenv('DB_PASSWORD') ?: '',
      'dbname'   => getenv('DB_NAME')     ?: 'EdilScavi',
    ];
  }

  public static function connect(): mysqli
  {
    $cfg = self::getConfig();
    $host = $cfg['host'] . ':' . $cfg['port'];

    $conn = new mysqli($host, $cfg['username'], $cfg['password'], database: $cfg['dbname']);
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

    if ($result === false || ($result->num_rows) <= 0) {
      return false;
    }
    if ($result->num_rows === 1) {
      $result_data = $result->fetch_assoc();
    } else {
      $result_data = $result->fetch_all(MYSQLI_ASSOC);
    }
    $q->close();
    $conn->close();

    return $result_data;
  }

  public static function getPreventivi($query, ...$parameters)
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

    if ($result === false || ($result->num_rows) <= 0) {
      return false;
    }
    $result_data = $result->fetch_all(MYSQLI_ASSOC);
    $q->close();
    $conn->close();

    return $result_data;
  }
}
