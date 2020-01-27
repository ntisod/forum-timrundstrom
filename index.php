<?php session_start(); ?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="shortcut icon" href="./pictures/favicon.ico"/>
    <title>NTI Forum</title>
</head>
<body>
    <header class="w3-container">
        <h1>NTI Forum</h1>
    </header>
    <?php include './templates/navbar.php';

    echo "<h2 class=\"w3-center\">Inlägg</h2>";
    
    // TODO: Visa senaste X antal inlägg

    require("./includes/settings.php");
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Find existing user
        $sql = "SELECT postID, title, text, user, date FROM posts ORDER BY date DESC LIMIT 10";
        $stmt = $conn->query($sql);
        while ($post = $stmt->fetch()) {

            // TODO: Display each post e.g.:
            echo $post['title']." - ".$post['date']."<br><br>";

        }

    } catch(PDOException $e) {
    }
    $conn = null;

    include './templates/footer.php'; 
    
    ?>
</body>
</html>