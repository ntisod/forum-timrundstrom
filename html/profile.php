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

    //set empty variables for editing editing your account
    $edit_account = false;
    $emailErr = $email = $desc = $psw = $pswErr = $confpswErr = $gender = $pictureError = "";
    $target_dir = "../pictures/profile-pictures/";
        
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        //check if logged in
        if (isset($_SESSION["account"])){

            //check if you're editing the account
            if (isset($_POST["edit"]) && $_POST["edit"] == "true"){
                $edit_account = true;

                //check if you pressed cancel while editing
            } else if (isset($_POST["cancel"])){
                header('Location: profile.php');

                //check if you've edited the account
            } else if (isset($_POST["update"]) && $_POST["update"] == "true"){
                $err = false;
                
                //check inputs
                if (empty($_POST["email"])) {
                    $emailErr = "E-post krävs";
                    $err = true;
                } else {
                    $email = test_input($_POST["email"]);
                }
                $desc = test_input($_POST["beskrivning"]);
                
                //check whether to update the password or not (if left empty then don't update it)
                $changepassword = true;
                if(!empty($_POST["password"]) && empty($_POST["confpassword"]) || empty($_POST["password"]) && !empty($_POST["confpassword"])){
                    $err = true;
                    $pswErr = $confpswErr = "Lösenorden matchar inte";

                } else if(!empty($_POST["password"]) && !empty($_POST["confpassword"])){
                    if ($_POST["password"] == $_POST["confpassword"]){
                        $psw = test_input($_POST["password"]);
                    } else {
                        $err = true;
                        $pswErr = $confpswErr = "Lösenorden matchar inte";
                    }
                } else {
                    $changepassword = false;
                }

                $gender = $_POST["gender"];

                //update profile picture
                if (isset($_FILES["file"])){
                    $target_file = $target_dir . $_SESSION["account"] . ".jpg";
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $image_picked = false;
    
                    if (is_uploaded_file($_FILES["file"]["tmp_name"])){
                        $image_picked = true;
    
                        $check = getimagesize($_FILES["file"]["tmp_name"]);
    
                        // Check if uploaded file is not a picture
                        if ($check == false){
                            $pictureError = "Filen är inte en bild";
                            $err = true;
                        }
                        // Check if filesize is over 50kb
                        if ($_FILES["file"]["size"] > 50000){
                            $pictureError = "Förlåt, men din fil är för stor (max 50kb)";
                            $err = true;
                        }
                        // Check image filetype, only jpg, jpeg, png and gif files are allowed
                        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif"){
                            $pictureError = "Endast JPG, JPEG, PNG and GIF files är tillåtna";
                            $err = true;
                        }
                    }
                }


                if ($err){
                    $edit_account = true;
                } else {

                    // TODO: ange lösenord för att spara info

                    //update account in DB
                    $username_ = $_SESSION["account"];
                    if($changepassword){
                        $hashed = password_hash($psw, PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET email='$email', beskrivning='$desc', password='$hashed', gender='$gender' WHERE username='$username_'";
                    } else {
                        $sql = "UPDATE users SET email='$email', beskrivning='$desc', gender='$gender' WHERE username='$username_'";
                    }
                    require("../includes/settings.php");

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                        // set the PDO error mode to exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        // Prepare statement
                        $stmt = $conn->prepare($sql);

                        // execute the query
                        $stmt->execute();
                        
                    } catch(PDOException $e) {
                    }
                    $conn = null;

                    // Update profile picture
                    if (isset($_FILES["file"]) && $image_picked){

                        // Check if profile picture already exists
                        if (file_exists($target_file)){
                            unlink($target_file); // If so, delete it.
                        }
                        // Upload new file
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
                        } 
                    } 

                    header('Location: profile.php');

                }

            } else {
                no_account_found();
            }
        } else {
            no_account_found();
        }
    }

    if ($edit_account){
        //display account with editable information

        //get account from DB
        $user = $_SESSION["account"];
        $sql = "SELECT username, email, beskrivning, password, gender, regdate FROM users WHERE username='$user' LIMIT 1";
        $result = get_data($sql);

        $username = $result['username'];
        $now = time(); // or your date as well
        $your_date = strtotime($result['regdate']);
        $datediff = $now - $your_date;
        $age = $datediff / (60 * 60 * 24);
        $age = round($age, 0);

        //display account
        echo <<<HTML
        <div class="w3-center profileContainer">
            <img class="profilePic" src="../pictures/profile-pictures/{$username}.jpg" />
        </div> 
        <h2 class="w3-center">{$username}</h2>
        <p class="w3-center">📅 Kontot är {$age} dagar gammalt.</p>
        HTML;
        require '../templates/edituserdata.php';
        echo "<div class=\"filler\"></div>";

    } else {
        //display account as normal
        if ($_SERVER["REQUEST_METHOD"] == "GET") {

            //show logged in account
            if (empty($_GET["user"])){ 

                if (isset($_SESSION["account"])){ // If they're logged in

                    //get account from DB
                    $username = test_input($_SESSION["account"]);
                    $sql = "SELECT username, email, beskrivning, regdate FROM users WHERE username='$username' LIMIT 1";
                    $result = get_data($sql);
                    display_account($result);

                } else { // Else, go to log in page
                    header('Location: ./login.php');
                }


            } else{ // Show account by username

                $user = $_GET["user"];
                // If the chosen username is the logged in user then display their own profile
                if (isset($_SESSION["account"]) && $user == $_SESSION["account"]){
                    header('Location: ./profile.php');
                }
                //get account from DB
                $sql = "SELECT username, email, beskrivning, regdate FROM users WHERE username='$user' LIMIT 1";
                $result = get_data($sql);

                if (!empty($result)){ // If an account is found, display it
                        display_account($result);
                } else { // Otherwise show error message: No account found
                    no_account_found();
                }

            }

        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function no_account_found(){
        //error message if no account is found
        echo "<h2 class=\"w3-center\"> Oops! </h2>";
        echo "<p class=\"w3-center\"> Inget konto hittades </p>";
    }

    function get_data($sql) {
        //function for getting data from DB

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
            $description = $result['beskrivning'];
            $now = time();
            $your_date = strtotime($result['regdate']);
            $datediff = $now - $your_date;
            $age = $datediff / (60 * 60 * 24);
            $age = round($age, 0);

            //not visible, just for JS to get the username
            echo "<div id=\"profile\" style=\"display:none;\">". $username ."</div>"; 

            //display account
            echo <<<HTML
            <div class="w3-center profileContainer">
                <img class="profilePic" id="profileimg" src="../pictures/profile-pictures/{$username}.jpg" />
            </div> 
            <h2 class="w3-center">{$username}</h2>
            
            <p class="w3-center">📅 Kontot är {$age} dagar gammalt.</p>
            <p class="w3-center description">{$description}</p>
            HTML;

            //if logged in and displaying own account, display buttons for editing and logging out
            if (isset($_SESSION["account"])){
                if ($_SESSION["account"] == $result['username']){
                    echo <<<HTML
                        <form action="{$_SERVER['PHP_SELF']}" method="post" class="w3-center" style="margin-bottom:5px;">
                        <input type="hidden" name="edit" value="true">
                        <input type="submit" value="Redigera Konto" class="submit">
                        </form>
                        <form action="../templates/logout.php" method="post" class="w3-center">
                        <input type="submit" value="Logga ut" class="submit">
                        </form>
                        <br>
                     HTML;
                }
            }

            // Show posts

            // How many posts should show?
            if (!empty($_GET["p"])){
                $showperpage = $_GET["p"]; // Get value from p-requests
            } else {
                $showperpage = 8; // Standard value
            }

            try {
                //get posts from DB
                require("../includes/settings.php");
                $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                // Find posts
                $sql = "SELECT postID, title, author, date FROM posts WHERE author='$username' ORDER BY date DESC LIMIT " .$showperpage;
                $stmt = $conn->query($sql);

                // Loop through all returned posts and display them on page
                echo "<h3 class=\"w3-center\">Inlägg</h3>";
                echo "<div class=\"w3-section\" id=\"posts\" style=\"margin-left:35px;\">";
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
                        <button class="button" id="post">
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

            //load more posts button
            echo <<<HTML
            <a onclick="loadPosts()">
                <div class="loadMore w3-center">
                    <p>Ladda mer</p>
                </div>
            </a>
            <p class="errortxt" id="noposts"></p>
            HTML;  

        }
    }

    include '../templates/footer.php'; ?>

    <script>
    function loadPosts() {
        //loads more posts without reloading the page, but using the loadposts.php file
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("posts").innerHTML += this.responseText;
            }
        };

        var offset = document.getElementsByClassName("button").length;
        var username = document.getElementById("profile").innerHTML;

        xmlhttp.open("GET", "../templates/loadposts.php?offset=" + offset + "&username=" + username, true);
        xmlhttp.send();
    }

    function refreshImage(imgElement, imgURL) {
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
    refreshImage("profileimg", "../pictures/profile-pictures/" + usr + ".jpg");
    </script>
</body>
</html>