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

    <h2 class="w3-center">Nytt inlägg</h2>


    <?php

        //check if logged in (can't make a post if not logged in)
        if (isset($_SESSION["account"])){
            //set empty variables
            $title = $text = "";
            $titleErr = $textErr = ""; 
            $err = false;

            if ($_SERVER["REQUEST_METHOD"] == "POST") { 

                //check if inputs are valid
                if (empty($_POST["title"])){
                    $titleErr = "Titel krävs";
                    $err = true;
                } else {
                    $title = test_input($_POST["title"]);
                }
                if (empty($_POST["text"])){
                    $textErr = "Text krävs";
                    $err = true;
                } else {
                    $text = test_input($_POST["text"]);
                }

                if ($err){
                    //error occured, reload page with errors
                    require '../templates/postdata.php';
                } else {
                    //no errors, post it

                    require("../includes/settings.php");
                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                        
                        // set the PDO error mode to exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $user = $_SESSION["account"];

                        // Get userID
                        $stmt = $conn->prepare("SELECT userID FROM users WHERE username='$user' LIMIT 1");
                        $stmt->execute();
                        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $result = $stmt->fetch();
                        $userID = $result['userID'];

                        // Make a new post
                        $sql = "INSERT INTO posts(title, text, userID, date, author) VALUES ('$title', '$text', '$userID', NOW(), '$user')";
                        // use exec() because no results are returned
                        $conn->exec($sql);

                        $last_id = $conn->lastInsertId(); // Get the id of the new post
                        header('Location: ./post.php?id=' . $last_id); // Go to view the new post

                    } catch(PDOException $e) {
                        $err = true;
                        echo $e;
                    }
                    
                    $conn = null;

                    if ($err){
                        //error when uploading the post to DB
                        require '../templates/postdata.php';
                    }

                }

            } else {
                //First time visit, input values
                require '../templates/postdata.php';
            }



        } else {
            //Not logged in, go to login page
            header('Location: ./login.php');
        }

        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <?php include '../templates/footer.php'; ?>
</body>
</html>