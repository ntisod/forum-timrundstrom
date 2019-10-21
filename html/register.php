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
        // Declare empty variables.
        $nameErr = $emailErr = $passwordErr = $confpasswordErr = $genderErr = "";
        $name = $email = $password = $confpassword = $website = $comment = $gender = "";
        $err = false;
        $target = "";
        
        // Controll values, set error if faulty inputs
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["username"])) {
                $nameErr = "Username is required";
                $err = true;
            } else {
                $name = test_input($_POST["username"]);
            }

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
            $comment = test_input($_POST["comment"]);
            

        }

        // Test inputs, trim, strip slashes and htmlspecialchars
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Set target value
        if ($err){
            $target = $_SERVER["PHP_SELF"]; //Stay on page, display errors
        } else {
            $target = "welcome.php"; //Go to welcome.php
        }

    ?>

    <form action="<?php echo $target;?>" method="post">
        <fieldset class="w3-container dark form">

            <label for="username">*Username:</label><br>
            <input type="text" name="username" placeholder="Username" value="<?php echo $name ?>"><br>
            <?php echo "<p class=\"errortxt\">" . $nameErr . "</p>" ?><br>

            <label for="email">*Email:</label><br>
            <input type="email" name="email" placeholder="E-mail" value="<?php echo $email ?>"><br>
            <?php echo "<p class=\"errortxt\">" . $emailErr . "</p>" ?><br>

            <label for="password">*Password:</label><br>
            <input type="password" name="password" placeholder="Password"><br>
            <?php echo "<p class=\"errortxt\">" . $passwordErr . "</p>" ?><br>

            <label for="confpassword">*Confirm Password:</label><br>
            <input type="password" name="confpassword" placeholder="Confirm Password"><br>
            <?php echo "<p class=\"errortxt\">" . $confpasswordErr . "</p>" ?><br>

            <label for="website">Website:</label><br>
            <input type="url" name="website" placeholder="Website" value="<?php echo $website ?>"><br>

            <label for="comment">Comment:</label><br>
            <textarea name="comment" rows="5" cols="40" placeholder="Comment"><?php echo $comment ?></textarea><br>

            <label for="gender">*Gender:</label><br>
            <?php echo "<p class=\"errortxt\">" . $genderErr . "</p>" ?><br>
            <input type="radio" name="gender" value="male" 
            <?php if (isset($gender) && $gender == "male") echo "checked" ?>>Male<br>
            <input type="radio" name="gender" value="female" 
            <?php if (isset($gender) && $gender == "female") echo "checked" ?>>Female<br>
            <input type="radio" name="gender" value="other" 
            <?php if (isset($gender) && $gender == "other") echo "checked" ?>>Other<br>

            <input type="submit" value="Sign Up" class="sumbit">

        </fieldset> 
    </form>

    <?php include '../templates/footer.php'; ?>
</body>
</html>