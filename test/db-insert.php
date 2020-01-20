<?php
require("../includes/settings.php");

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO users (email, password, gender, regdate)
    VALUES ('jöhn@example.com', 'göödpåsswörd', 'male', NOW())";

    // use exec() because no results are returned
    $conn->exec($sql);
    
    echo "New record created successfully";
} catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>