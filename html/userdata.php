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

    <form action="_self" method="post">
        <fieldset class="w3-container dark form">
            <label for="username">Username:</label><br>
            <input type="text" name="username"><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email"><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password"><br>
            <label for="confpassword">Confirm Password:</label><br>
            <input type="password" name="confpassword"><br>
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