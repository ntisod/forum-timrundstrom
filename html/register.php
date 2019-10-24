<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>NTI Forum</title>
</head>
<body>
    
    <header class="w3-container">
        <h1>NTI Forum</h1>
    </header>
    <?php include '../templates/navbar.php'; ?>


    <?php
        // Declare empty variables.
        $emailErr = $passwordErr = $confpasswordErr = $genderErr = "";
        $email = $password = $confpassword = $website = $gender = "";
        $err = false;
        
        // Controll values, set error if faulty inputs
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
                $err = true;
            } else {
                $email = test_input($_POST["email"]);
            }

            if (empty($_POST["password"])) {
                $passwordErr = "Password is required";
                $err = true;
            } else {
                $password = test_input($_POST["password"]);
            }

            if ($_POST["password"] == $_POST["confpassword"]) {
                $confpassword = test_input($_POST["confpassword"]);
            } else {
                $confpasswordErr = "Password does not match";
                $err = true;
            }

            if (isset($_POST["gender"])){
                $gender = $_POST["gender"];
            } else{
                $genderErr = "Gender is required";
                $err = true;
            }

            $website = test_input($_POST["website"]);

            if (!$err){
                // No errors, display welcome and save account

                date_default_timezone_set("Europe/Stockholm"); // Set timezone
                $file = fopen("../textfiles/accounts.txt", "a+"); // open file
                fwrite($file, date("Y-m-d H:i:s") . ",{$email},{$password},{$gender},{$website}\n"); // Save information
                fclose($file); // close file

                // Display welcome
                echo "<h2 class=\"w3-center\">Welcome {$email}!</h2>"; 
                // Display time of account creation
                echo "<p>You created your account on " . date("Y-m-d") . " at " . date("H:i") . "</p>"; 
            } else {
                // error occured, create an account, show error messages
                echo "<h2 class=\"w3-center\">Create Account</h2>";
                require '../templates/userdata.php';
            }

        } else {
            // First time visiting, create an account
            echo "<h2 class=\"w3-center\">Create Account</h2>";
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