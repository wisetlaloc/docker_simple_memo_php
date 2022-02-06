<?php

/**
 * use PDO to access the database
 * @return PDO
 */
function getDatabaseConnection() {
    try
    {
        $database_handler = new PDO('mysql:host=db;dbname=simple_memo;charset=utf8mb4', 'root', 'password');
    }
    catch (PDOException $e)
    {
        echo "database connection error.<br />";
        echo $e->getMessage();
        exit;
    }
    return $database_handler;
}
