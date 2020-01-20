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
        // Declare empty variables.
        $emailErr = $passwordErr = $confpasswordErr = $genderErr = $pictureError = "";
        $email = $password = $confpassword = $website = $gender = "";
        $target_dir = "../pictures/profile-pictures/";
        $cookie_name = "email";
        $cookie_value = "";
        $err = false;
        
        // Controll values, set error if faulty inputs
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (empty($_POST["email"])) {
                $emailErr = "E-post krävs";
                $err = true;
            } else {
                $email = test_input($_POST["email"]);
                $cookie_value = test_input($_POST["email"]);
            }

            if (empty($_POST["password"])) {
                $passwordErr = "Lösenord krävs";
                $err = true;
            } else {
                $password = test_input($_POST["password"]);
            }

            if ($_POST["password"] == $_POST["confpassword"]) {
                $confpassword = test_input($_POST["confpassword"]);
            } else {
                $confpasswordErr = "Lösenord matchar inte";
                $err = true;
            }

            if (isset($_POST["gender"])){
                $gender = $_POST["gender"];
            } else{
                $genderErr = "Kön krävs";
                $err = true;
            }

            if (isset($_FILES["file"])){
                $target_file = $target_dir . $email . ".jpg";
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

            if (!$err){
                 require("../includes/settings.php");

                 try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    $sql = "SELECT email from users WHERE email='$email'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();
                    
                    if (empty($result)){
                        //Encrypt password
                        $hashed = password_hash($password, PASSWORD_DEFAULT);

                        // Set new user
                        $sql = "INSERT INTO users (email, password, gender, regdate)
                        VALUES ('$email', '$hashed', '$gender', NOW())";
                        // use exec() because no results are returned
                        $conn->exec($sql);
                    } else {
                        $err = true;
                    }
                 } catch(PDOException $e) {
                    $err = true;
                    echo $e;
                 }
                 
                 $conn = null;
            }

            if (!$err){
                // No errors, display welcome and save account

                // If a picture was chosen
                if (isset($_FILES["file"]) && $image_picked){

                    // Check if profile picture already exists
                    if (file_exists($target_file)){
                        unlink($target_file); // If so, delete it.
                    }
                    // Upload new file
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
                        echo "<p>Filen " . basename($_FILES["file"]["name"]) . " har laddats upp</p>";
                    }
                } else {

                    // Set default picture
                    $file = "../pictures/profile.png";
                    $newfile = "../pictures/profile-pictures/" . $email . ".jpg";

                    if (!copy($file, $newfile)) {
                        echo "failed to copy";
                    }
                }

                // Create a cookie
                setcookie($cookie_name, $cookie_value, time() + 86400 * 30, "/");

                // Set session
                session_regenerate_id();
                $_SESSION["account"] = $email;

                date_default_timezone_set("Europe/Stockholm"); // Set timezone

                /*
                // Save account
                $file = fopen("../textfiles/accounts.txt", "a+"); // open file
                $txt = "\n" . date("Y-m-d H:i:s") . ",{$email},{$password},{$gender},{$website}";
                fwrite($file, $txt); // Save information
                fclose($file); // close file
                */

                // Display welcome
                echo "<h2 class=\"w3-center\">Välkommen {$email}!</h2>";
                if (isset($_COOKIE[$cookie_name])){
                    echo "<p class=\"w3-center\">" . $cookie_name . " cookie har skapats!</p>";
                }
                // Display time of account creation
                echo "<p class=\"w3-center\">Du skapade ditt konto den " . date("Y-m-d") . ", klockan " . date("H:i") . "</p>"; 
            } else {
                // error occured, create an account, show error messages
                echo "<h2 class=\"w3-center\">Registrera</h2>";
                require '../templates/userdata.php';
            }

        } else {
            
            // First time visiting, create an account
            echo "<h2 class=\"w3-center\">Registrera</h2>";
            require '../templates/userdata.php';
        }

        // Test inputs, trim, strip slashes and htmlspecialchars
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