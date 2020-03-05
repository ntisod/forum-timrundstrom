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

        $id = "";
        $err = false;
        if (isset($_GET["id"]) && is_numeric($_GET["id"])){
            $id = $_GET["id"];
        } else if (isset($_POST["id"]) && is_numeric($_POST["id"])){
            $id = $_POST["id"];
        } else {
            $err = true;
        }

        $commenttext = $commenttextErr = "";
        $commentErr = false;
        require("../includes/settings.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            
            if (isset($_SESSION["account"])){
                $user = $_SESSION["account"];
                if (empty($_POST["text"])){
                    $commenttextErr = "Text krävs";
                    $commentErr = true;
                } else {
                    $commenttext = test_input($_POST["text"]);
                }
                if (!$commentErr){
                    try{
                        // LÄGG UPP KOMMENTAR
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
                        // set the PDO error mode to exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $sql = "INSERT INTO comments(postID, user, text, date) VALUES ('$id', '$user', '$commenttext', NOW())";
                        $conn->exec($sql);


                    } catch(PDOException $e){
                        echo $e;
                        echo "Kunde inte lägga upp kommentar, försök igen senare...";
                    }
                }
            } else {
                $commenttextErr = "Logga in för att skriva kommentarer";
            }
            header('Location: ../html/post.php?id='.$id);
            
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET"){
            
            $title = $text = $author = $date = "";

            if(!$err){
                try{
                    // HÄMTA INLÄGG
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Find existing post
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
                } catch(PDOException $e){
                    echo $e;
                }
            } else {
                echo "<h2 class=\"w3-center\">Oops!</h2>";
                echo "<p class=\"w3-center\">Inget inlägg hittades</p>";
            }
            
            if (!$err){
                echo "<h2 class=\"w3-center\">$title</h2>";
                echo "<p class=\"w3-center\">$text <br>av: <a href=\"../html/profile.php?user=$author\">$author</a> <br> $date</p>";
                echo "<br><br>";
                
                include '../templates/commentdata.php';

                // TODO: display comments

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    // Find comments
                    $sql = "SELECT postID, user, text, date FROM comments WHERE postID='$id' ORDER BY date DESC LIMIT 5";
                    $stmt = $conn->query($sql);
            
                    // Loop through all returned posts and display them on page
                    while ($comment = $stmt->fetch()) {
                        // Get post values
                        $user = $comment['user'];
                        $text = $comment['text'];
                        $date = $comment['date']; // TODO: show time since rather than date
                        // Display the comment
                        echo <<<HTML
                            <div class="comment">
                                <p>$text<br><span><a href="../html/profile.php?user=$user">$user</a> - $date</span></p>
                            </div>
                        HTML;
            
                    }
            
                } catch(PDOException $e) {
                }
                $conn = null; // Close connection            
            }
        }
        
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    ?>    



    <h2 class="w3-center filler"></h2>
<?php include '../templates/footer.php'; ?>
</body>
</html>