<?php

require_once("php/backend/auth.php");

class DBAccess {
/*
* Classe che si occupa di gestire la connessione al database
* e di eseguire le query
*/

	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "edilscavi";
	private const USERNAME = "root";
	private const PASSWORD = "root";

    private static function connect($host = "db", $username = "root", $password = "q", $dbname = "onoranze")
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $mysqli = new mysqli(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);
            if ($mysqli->connect_errno) {
                die('Connect failed: ' . $mysqli->connect_error);
            }
            return $mysqli;
        } catch (mysqli_sql_exception $e) {
            server_error();
        }
    }

    public static function run_query($query, ...$params)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $mysqli = self::connect();
            $stmt = $mysqli->prepare($query);
            if (count($params) > 0) {
                $stmt->bind_param(str_repeat("s", count($params)), ...$params);
            }
            foreach ($params as $param) {
                $param = mysqli_real_escape_string($mysqli, $param);
            }
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result == false || ($result->num_rows) <= 0) {
                return false;
            }
    
    
            $result = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            $mysqli->close();
            return $result;
        }
        catch (mysqli_sql_exception $e) {
            server_error();
        }
    }
}

?>
