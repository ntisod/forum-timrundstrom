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
        <!--img src="./pictures/nti-logo-black.png" alt="Svart NTI logga"-->
        <h1>NTI Forum</h1>
    </header>
    <?php include '../templates/navbar.php'; ?>

    <h2 class="w3-center">Welcome! <?php if(isset($_POST["username"])) echo $_POST["username"]; ?></h2>
    <?php
        if (isset($_POST["email"])){
            echo "Your mail is: " . $_POST["email"] . "<br>";
        }
        if (isset($_POST["password"])){
            echo "Your mail is: " . $_POST["password"] . "<br>";
        }
        if (isset($_POST["website"])){
            echo "Your mail is: " . $_POST["website"] . "<br>";
        }
        if (isset($_POST["comment"])){
            echo "Your mail is: " . $_POST["comment"] . "<br>";
        }
        if (isset($_POST["gender"])){
            echo "Your mail is: " . $_POST["gender"] . "<br>";
        }
    ?>

    <?php include '../templates/footer.php'; ?>
</body>
</html>