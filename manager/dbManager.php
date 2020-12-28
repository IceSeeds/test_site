<?php

function getDb( $dbname )
{
    $servername = "localhost";
    $username   = "admin";
    $password   = "admin";

    $conn = new PDO( "mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password );

    return $conn;
}
?>
