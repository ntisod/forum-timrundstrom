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

        //set empty variables
        $id = $commenttext = $commenttextErr = "";
        $commentErr = false;
        $err = false;

        //get the post id (its in GET if you just view the post, in POST if you make a comment)
        if (isset($_GET["id"]) && is_numeric($_GET["id"])){
            $id = $_GET["id"];
        } else if (isset($_POST["id"]) && is_numeric($_POST["id"])){
            $id = $_POST["id"];
        } else {
            $err = true;
        }

        require("../includes/settings.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            // You've made a comment, upload it to DB

            if (isset($_SESSION["account"])){ //Check if logged in
                $user = $_SESSION["account"];

                //get comment text
                if (empty($_POST["text"])){
                    $commenttextErr = "Text krävs";
                    $commentErr = true;
                } else {
                    $commenttext = test_input($_POST["text"]);
                }

                if (!$commentErr){
                    try{
                        // Upload comment to DB
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
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
            //Reload page, now with a new comment
            header('Location: ../html/post.php?id='.$id);
            
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET"){
            
            //set empty variables
            $title = $text = $author = $date = "";

            if(!$err){
                try{
                    // Get post from DB
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Find existing post

                    $sql = "SELECT posts.title, posts.text, posts.author, posts.date, users.beskrivning 
                    FROM posts INNER JOIN users ON posts.author=users.username WHERE posts.postID='$id' LIMIT 1";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();

                    if (!empty($result)){
                        $title = $result['title'];
                        $text = $result['text'];
                        $author = $result['author'];
                        $date = $result['date'];
                        $beskrivning = $result['beskrivning'];
                    } else {
                        $err = true;
                    }
                } catch(PDOException $e){
                    echo $e;
                }
            } else {
                //error, show error message
                echo "<h2 class=\"w3-center\">Oops!</h2>";
                echo "<p class=\"w3-center\">Inget inlägg hittades</p>";
            }
            
            if (!$err){
                //dispaly the post and author profile
                echo <<<HTML
                <div class="flex-container">
                    <div class="w3-center post-container post-post">
                        <div class="post-view">
                            <h2 class="w3-border-bottom">$title</h2>
                            <p class="post-text">$text</p>
                            <br><br>
                            <p>av: <a href="../html/profile.php?user={$author}">$author</a></p>
                            <p>$date</p>
                        </div>
                    </div>
                    <div>
                    <div class="w3-center post-container profile">
                        <div class="post-view">
                            <div class="w3-center profileContainer">
                                <img class="profilePic" id="profileimg" src="../pictures/profile-pictures/{$author}.jpg" />
                            </div> 
                            <h3 class="w3-center"><a id="profile" href="../html/profile.php?user={$author}">$author</a></h3>
                            <p>$beskrivning</p>
                        </div>
                    </div>
                    </div>
                </div>
                HTML;

                include '../templates/commentdata.php';

                try {
                    // Get comments from DB
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    // Find comments
                    $sql = "SELECT user, text, date FROM comments WHERE postID='$id' ORDER BY date DESC LIMIT 5";
                    $stmt = $conn->query($sql);
            
                    // Loop through all returned posts and display them on page
                    while ($comment = $stmt->fetch()) {
                        // Get post values
                        $user = $comment['user'];
                        $text = $comment['text'];
                        $date = $comment['date'];
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

    <script>
    
    function refreshImage(imgElement, imgURL){
        //doesn't refresh on its own since the picture has the same url, thus saving in it the browsers cache
        //this forces the browser to refresh the picture by giving the url a query string, making the url different

        // create a new timestamp     
        var timestamp = new Date().getTime();        
        var el = document.getElementById(imgElement);        
        var queryString = "?t=" + timestamp;           
        el.src = imgURL + queryString;    
    }
    
    var usr = document.getElementById("profile").innerHTML;
    //refresh the profile pic whenever the page is loaded/reloaded
    refreshImage("profileimg", "../pictures/profile-pictures/"+ usr +".jpg"); 

    </script>

</body>
</html>