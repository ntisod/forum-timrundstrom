<?php session_start(); ?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="shortcut icon" href="../pictures/favicon.ico"/>
    <title>NTI Forum</title>
</head>
<body>
    <header class="w3-container">
        <h1>NTI Forum</h1>
    </header>
    <?php include '../templates/navbar.php'; ?>

    <?php 
    
    if ($_SERVER["REQUEST_METHOD"] == "GET"){

        $title = $text = $author = $date = "";
        $id = "";
        $err = false;
        if (!empty($_GET["id"]) && is_numeric($_GET["id"])){
            $id = $_GET["id"];
        } else {
            $err = true;
        }

        if (!$err){
            // GET POST BY ID
            require("../includes/settings.php");

            // Look for account in DB TODO:
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Find existing user
                $stmt = $conn->prepare("SELECT postID, title, text, author, date FROM posts WHERE postID='$id' LIMIT 1");
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result = $stmt->fetch();

                if (!empty($result)){
                    $title = $result['title'];
                    $text = $result['text'];
                    $author = $result['author'];
                    $date = $result['date'];
                } else {
                    $err = true;
                }

            } catch(PDOException $e) {
                $err = true;
            }
        }

        if ($err){
            echo "<h2 class=\"w3-center\">Oops!</h2>";
            echo "<p class=\"w3-center\">Inget inlägg hittades</p>";
        } else {
            echo "<h2 class=\"w3-center\">$title</h2>";
            echo "<p class=\"w3-center\">$text <br>av: $author <br> $date</p>";
        }
    }
    
    ?>
    <h2 class="w3-center"></h2>


    <?php include '../templates/footer.php'; ?>
</body>
</html>