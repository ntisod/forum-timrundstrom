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
        $email = $password = "";
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


            if (!$err){
                $file = fopen("../textfiles/accounts.txt", "r"); // open file
                $matching_account = false;

                // Go through each line in .txt file
                while(!feof($file)) {
                    $account = fgets($file);
                    $account_array = explode(",", $account);
                    // If the saved account matches user inputs, then set matching_account to true
                    if ($account_array[1] == $email && $account_array[2] == $password){
                        $matching_account = true;
                    }
                }

                // Set error to true and display message if there is no matching account
                if (!$matching_account){
                    $accountErr = "E-post eller lösenord matchar inte";
                    $err = true;
                }
                fclose($file); // close file
            }

            if (!$err){
                // No errors, display welcome

                // Create a cookie
                setcookie($cookie_name, $cookie_value, time() + 86400 * 30, "/");

                // Display welcome
                echo "<h2 class=\"w3-center\">Välkommen {$email}!</h2>";
                if (isset($_COOKIE[$cookie_name])){
                    echo "<p>" . $cookie_name . " cookie har skapats!</p>";
                }
                // Display time of account creation

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