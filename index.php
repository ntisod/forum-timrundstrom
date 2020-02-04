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

    $showperpage = 2;
    if (empty($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $offset = ($page-1) * $showperpage;    

    require("./includes/settings.php");
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Find existing user
        $sql = "SELECT postID, title, user, date FROM posts ORDER BY date DESC LIMIT ".$showperpage." OFFSET ".$offset;
        $stmt = $conn->query($sql);

        while ($post = $stmt->fetch()) {
            $id = $post['postID'];
            $title = $post['title'];
            $user = $post['user'];
            $date = $post['date']; // TODO: show time since rather than date

            echo <<<HTML
                <div class="post">
                    <a href="./html/post.php?id={$id}">
                        <h3> {$title}</h3>
                        <p> {$user} - {$date} </p>
                    </a>
                </div>
            HTML;

        }

    } catch(PDOException $e) {
    }
    $conn = null;

    $backpage = $page-1;
    if ($backpage <= 0){
        $backpage = 1;
    }
    $forwardpage = $page+1;
    
    echo <<<HTML
        <div class="w3-center pagebtns">
            <a href=".?page={$backpage}" class="pagebtn previous round">&#8249;</a>
            <a href=".?page={$forwardpage}" class="pagebtn next round">&#8250;</a>
        </div>
    HTML;

    include './templates/footer.php'; 
    
    ?>

</body>
</html>