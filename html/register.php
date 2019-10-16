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

    <h2 class="w3-center">Create Account</h2>

    <?php
        $nameErr = $emailErr = $passwordErr = $confpasswordErr = $websiteErr = $genderErr = "";
        $name = $email = $password = $confpassword = $website = $gender = "";
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($_POST["username"])) {
                $nameErr = "Username is required";
            } else {
                //$name = test_input($_POST["username"]);
            }

            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } else {
                //$email = test_input($_POST["email"]);
            }

            if (empty($_POST["password"])) {
                $passwordErr = "Password is required";
            } else {
                //$password = test_input($_POST["password"]);
            }

            if ($_POST["password"] == $_POST["confpassword"]) {
                //$confpassword = test_input($_POST["confpassword"]);
            } else {
                $confpasswordErr = "Password does not match";
            }

        }
        
    ?>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset class="w3-container dark form">
            <label for="username">*Username:</label><br>
            <input type="text" name="username"><br>
            <?php echo "<p class=\"errortxt\">" . $nameErr . "</p>" ?><br>
            <label for="email">*Email:</label><br>
            <input type="email" name="email"><br>
            <?php echo "<p class=\"errortxt\">" . $emailErr . "</p>" ?><br>
            <label for="password">*Password:</label><br>
            <input type="password" name="password"><br>
            <?php echo "<p class=\"errortxt\">" . $passwordErr . "</p>" ?><br>
            <label for="confpassword">*Confirm Password:</label><br>
            <input type="password" name="confpassword"><br>
            <?php echo "<p class=\"errortxt\">" . $confpasswordErr . "</p>" ?><br>
            <label for="website">Website:</label><br>
            <input type="url" name="website"><br>
            <label for="comment">Comment:</label><br>
            <input type="text" name="comment"><br>
            <label for="gender">Gender:</label><br>
            <input type="radio" name="gender" value="male">Male<br>
            <input type="radio" name="gender" value="female">Female<br>
            <input type="radio" name="gender" value="other">Other<br>
            <input type="submit" value="Sign Up" class="sumbit">
        </fieldset> 
    </form>

    <?php include '../templates/footer.php'; ?>
</body>
</html>