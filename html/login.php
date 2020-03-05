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
        $emailErr = $passwordErr = $accountErr = "";
        $username = $email = $password = "";
        $cookie_name = "email";
        $cookie_value = "";
        $err = false;
        
        if (isset($_SESSION["account"])){
            header('Location: ./profile.php');
        }

        // Controll values, set error if faulty inputs
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (empty($_POST["email"])) {
                $emailErr = "E-post krävs";
                $err = true;
            } else {
                $email = test_input($_POST["email"]);
                $cookie_value = test_input($_POST["email"]); // Set cookie value

            }

            if (empty($_POST["password"])) {
                $passwordErr = "Lösenord krävs";
                $err = true;
            } else {
                $password = test_input($_POST["password"]);
            }


            if (!$err){
                $matching_account = false;
                
                require("../includes/settings.php");

                // Look for account in DB TODO:
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $dbusername, $dbpassword);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Find existing user
                    $stmt = $conn->prepare("SELECT username, email, password FROM users WHERE email='$email' LIMIT 1");
                    $stmt->execute();
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $stmt->fetch();

                    // HOW DO I GET EMAIL AND PASSWORD VALUES? TODO:
                    if (!empty($result)){
                        if (password_verify($password, $result['password'])){
                            $matching_account = true;
                            $username = $result['username'];
                        }
                    }
                } catch(PDOException $e) {
                    $err = true;
                }

                $conn = null;

                // Set error to true and display message if there is no matching account
                if (!$matching_account){
                    $accountErr = "E-post eller lösenord matchar inte";
                    $err = true;
                }
            }

            if (!$err){
                // No errors, display welcome site

                // Create a cookie
                setcookie($cookie_name, $cookie_value, time() + 86400 * 30, "/");
                // Set session
                session_regenerate_id();
                $_SESSION["account"] = $username;

                header('Location: ./profile.php');

            } else {
                // error occured, login, show error messages
                echo "<h2 class=\"w3-center\">Logga in</h2>";
                require '../templates/signin.php';
            }

        } else {
            
            // First time visiting, login
            echo "<h2 class=\"w3-center\">Logga in</h2>";
            require '../templates/signin.php';

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