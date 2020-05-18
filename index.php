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
    
    //Title
    echo "<h2 class=\"w3-center\">Inlägg</h2>";

    // Get page number and post offset
    $showperpage = 5; //standard: 5 
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
        $sql = "SELECT postID, title, date, author FROM posts ORDER BY date DESC LIMIT ".$showperpage." OFFSET ".$offset;
        $stmt = $conn->query($sql);

        // Loop through all returned posts and display them on page
        while ($post = $stmt->fetch()) {
            // Get post values
            $id = $post['postID'];
            $title = $post['title'];
            $user = $post['author'];
            $date = $post['date']; // TODO: show time since rather than date

            // Display the post
            echo <<<HTML
                <div class="boxOuterContainer post">
                    <a href="./html/post.php?id={$id}" class="noDecoration">
                        <div class="boxContainer">
                            <h3> {$title}</h3>
                            <p> av: {$user}<br>{$date} </p>
                        </div>
                    </a>
                </div>
            HTML;
        }
        // Page button values
        $backpage = $page-1; // Backpage is the page before the current page
        if ($backpage <= 0){ // It cant be lower than 1
            $backpage = 1;
        }
        $num_of_posts = $conn->query("SELECT count(*) FROM posts")->fetchColumn();
        $num_of_pages = ceil($num_of_posts / $showperpage);
        $forwardpage = $page+1; // Set next page
        if ($forwardpage > $num_of_pages){
            $forwardpage = $num_of_pages;
        }

        // Display buttons
        echo "<div class=\"w3-center pagebtns\">";
        echo "<a href=\".?page={$backpage}\" class=\"pagebtn previous round\">&#8249;</a>";

        if($page > 4){
            //display nr. 1
            echo "<a href=\".?page=1\" class=\"pagebtn previous round\">1</a>";
            echo ". . .";

            //display pages around current page ($page)
            for($i = $page-3; $i < $num_of_pages; $i++){
                if($i == $page+2){
                    break;
                }
                $page_nr = $i+1;
                $classes = "pagebtn previous round";
                if($page_nr > 9){
                    $classes .= " doubledigits";
                }
                if($page_nr == $page){
                    echo "<a href=\".?page={$page_nr}\" class=\"$classes activepage\">$page_nr</a>";
                } else {
                    echo "<a href=\".?page={$page_nr}\" class=\"$classes\">$page_nr</a>";
                }
            }
        } else {

            for($i = 0; $i < $num_of_pages; $i++){
                if($i == 5){
                    break;
                }
                $page_nr = $i+1;
                if($page_nr == $page){
                    echo "<a href=\".?page={$page_nr}\" class=\"pagebtn previous activepage round\">$page_nr</a>";
                } else {
                    echo "<a href=\".?page={$page_nr}\" class=\"pagebtn previous round\">$page_nr</a>";
                }
            }

        }

        echo "<a href=\".?page={$forwardpage}\" class=\"pagebtn next round\">&#8250;</a>";
        echo "</div>";

    } catch(PDOException $e) {
    }
    $conn = null; // Close connection

    // Set the footer
    include './templates/footer.php'; 
    ?>

</body>
</html>