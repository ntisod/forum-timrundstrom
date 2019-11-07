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
                $emailErr = "Email is required";
                $err = true;
            } else {
                $email = test_input($_POST["email"]);
                $cookie_value = test_input($_POST["email"]);
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

            // Set variables for file upload
            $target_file = $target_dir . $email . ".jpg";
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            // Check if uploaded file is a picture
            if ($check == false){
                $pictureError = "File is not a picture";
                $err = true;
            }
            // Check if filesize is over 50kb
            if ($_FILES["file"]["size"] > 50000){
                $pictureError = "Sorry, your file is too large";
                $err = true;
            }
            // Check image filetype, only jpg, jpeg, png and gif files are allowed
            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif"){
                $pictureError = "Only JPG, JPEG, PNG and GIF files are allowed";
                $err = true;
            }

            $website = test_input($_POST["website"]);

            if (!$err){
                // No errors, display welcome and save account

                // Check if profile picture already exists
                if (file_exists($target_file)){
                    unlink($target_file); // If so, delete it.
                }
                // Upload new file
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
                    echo "<p>The file " . basename($_FILES["file"]["name"]) . " has been uploaded</p>";
                }

                // Create a cookie
                setcookie($cookie_name, $cookie_value, time() + 86400 * 30, "/");

                date_default_timezone_set("Europe/Stockholm"); // Set timezone
                $file = fopen("../textfiles/accounts.txt", "a+"); // open file
                $txt = date("Y-m-d H:i:s") . ",{$email},{$password},{$gender},{$website}\n";
                fwrite($file, $txt); // Save information
                fclose($file); // close file

                // Display welcome
                echo "<h2 class=\"w3-center\">Welcome {$email}!</h2>";
                if (isset($_COOKIE[$cookie_name])){
                    echo "<p>Cookie " . $cookie_name . " is set!</p>";
                }
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