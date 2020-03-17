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

    // Get page number and page offset (for second page skip first $showperpage posts)
    $showperpage = 5;
    if (empty($_GET['page']) || !is_numeric($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $offset = ($page-1) * $showperpage;    

    // Get posts
    require("./includes/settings.php");
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Find posts
        $sql = "SELECT postID, title, text, date, author FROM posts ORDER BY date DESC LIMIT ".$showperpage." OFFSET ".$offset;
        $stmt = $conn->query($sql);

        // Loop through all returned posts and display them on page
        while ($post = $stmt->fetch()) {
            // Get post values
            $id = $post['postID'];
            $title = $post['title'];
            $text = $post['text'];
            $user = $post['author'];
            $date = $post['date']; // TODO: show time since rather than date

            // Shorten the text if its too long, only show preview
            if(strlen($text) > 90){
                $text = substr($text, 0, 90);
                $text = $text . "...";
            }

            // Display the post
            echo <<<HTML
                <div class="boxOuterContainer post">
                    <a href="./html/post.php?id={$id}" class="noDecoration">
                        <div class="boxContainer">
                            <h3> {$title}</h3>
                            <p style="word-wrap: break-word;"> {$text} </p>
                            <p> av: {$user}<br>{$date} </p>
                        </div>
                    </a>
                </div>
            HTML;

        }

    } catch(PDOException $e) {
    }
    $conn = null; // Close connection

    // Page button values
    $backpage = $page-1; // Backpage is the page before the current page
    if ($backpage <= 0){ // It cant be lower than 1
        $backpage = 1;
    }
    $forwardpage = $page+1; // Set next page (TODO: don't allow over limit)
    
    // Display buttons
    echo <<<HTML
        <div class="w3-center pagebtns">
            <a href=".?page={$backpage}" class="pagebtn previous round">&#8249;</a>
            <a href=".?page={$forwardpage}" class="pagebtn next round">&#8250;</a>
        </div>
    HTML;

    // Set the footer
    include './templates/footer.php'; 
    ?>

</body>
</html>