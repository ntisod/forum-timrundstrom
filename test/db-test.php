<?php
$servername = "localhost";
$username = "phpuser";
$password = "oCEFYkel4eRuns8l";

try {
    $conn = new PDO("mysql:host=$servername;dbname=nti-forum-db", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    $conn = null;
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>