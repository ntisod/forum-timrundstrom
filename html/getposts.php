<?php

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    if (!empty($_GET["offset"]) && !empty($_GET["username"])){

        $offset = $_GET["offset"];
        $username = $_GET["username"];
        try {
            require("../includes/settings.php");
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Find posts
            $sql = "SELECT postID, title, author, date FROM posts WHERE author='$username' ORDER BY date DESC LIMIT 8 OFFSET ". $offset;
            $stmt = $conn->query($sql);

            // Loop through all returned posts and display them on page
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
        } catch(PDOException $e) {
        }
        $conn = null; // Close connection

    }
}
