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

    <?php include '../templates/navbar.php'; 

    echo "<h2 class=\"w3-center\">Konto</h2>";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header('Location: ../templates/logout.php');
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        if (empty($_GET["user"])){ // TODO: Show your account

            if (isset($_SESSION["account"])){

                $username = $_SESSION["account"];
                $sql = "SELECT username, email, regdate FROM users WHERE username='$username' LIMIT 1";
                $result = get_data($sql);
                display_account($result);

            } else {
                header('Location: ./login.php');
            }


        } else{ // TODO: Show account by id

           $user = $_GET["user"];
           if (isset($_SESSION["account"]) && $user == $_SESSION["account"]){
               header('Location: ./profile.php');
           }
           $sql = "SELECT username, email, regdate FROM users WHERE username='$user' LIMIT 1";
           $result = get_data($sql);
           if (!empty($result)){
                display_account($result);
           } else {
               no_account_found();
           }

        }

    }
    

    function no_account_found(){
        echo "<h2 class=\"w3-center\"> Oops! </h2>";
        echo "<p class=\"w3-center\"> Inget konto hittades </p>";
    }

    function get_data($sql) {

        require("../includes/settings.php");
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Find existing user
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();

        } catch(PDOException $e) {
            $conn = null;
            return null;
        }
        $conn = null;


        return $result;
    }

    function display_account($result){
        if (!empty($result)){

            $username = $result['username'];

            $now = time(); // or your date as well
            $your_date = strtotime($result['regdate']);
            $datediff = $now - $your_date;
            $age = $datediff / (60 * 60 * 24);
            $age = round($age, 0);

            echo <<<HTML
            <div class="w3-center profileContainer">
                <img class="profilePic" src="../pictures/profile-pictures/{$username}.jpg" />
            </div> 
            <h2 class="w3-center">{$username}</h2>
            
            <p class="w3-center">📅 Kontot är {$age} dagar gammalt.</p>
            HTML;

            if (isset($_SESSION["account"])){
                if ($_SESSION["account"] == $result['username']){
                    echo <<<HTML
                        <form action="{$_SERVER['PHP_SELF']}" method="post" class="w3-center">
                        <input type="submit" value="Logga ut" class="submit">
                        </form>
                        <br><br>
                     HTML;
                }
            }

            // TODO: show posts

            $showperpage = 8;
            $offset = 0;

            try {
                require("../includes/settings.php");
                $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                // Find posts
                $sql = "SELECT postID, title, author, date FROM posts WHERE author='$username' ORDER BY date DESC LIMIT " .$showperpage. " OFFSET " .$offset;
                $stmt = $conn->query($sql);

                // Loop through all returned posts and display them on page
                echo "<div class=\"w3-section\" style=\"margin-left:35px;\">";
                while ($post = $stmt->fetch()) {
                    // Get post values
                    $id = $post['postID'];
                    $title = $post['title'];
                    $user = $post['author'];
                    $date = $post['date']; // TODO: show time since rather than date

                    // Shorten the text if its too long, only show preview
                    if(strlen($title) > 25){
                        $title = substr($title, 0, 25);
                        $title = $title . "...";
                    }

                    // Display the post
                    echo <<<HTML
                        <button class="button">
                            <div class="boxOuterContainer">
                                <a href="../html/post.php?id={$id}" class="noDecoration">
                                    <div class="boxContainer">
                                        <h3> {$title}</h3>
                                        <p> av: {$user}<br>{$date} </p>
                                    </div>
                                </a>
                            </div>
                        </button>
                    HTML;
                }
                echo "</div>";
            } catch(PDOException $e) {
            }
            $conn = null; // Close connection

            // TODO: öka offset med 5
            echo <<<HTML
            <a>
                <div class="loadMore w3-center">
                    <p>Ladda mer</p>
                </div>
            </a>
            HTML;  

        }
    }

    include '../templates/footer.php'; ?>

</body>
</html>