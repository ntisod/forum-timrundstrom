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
            echo "<p>Your mail is: " . $_POST["email"] . "<br>";
        }
        if (isset($_POST["password"])){
            echo "Your password is: " . $_POST["password"] . "<br>";
        }
        if (isset($_POST["website"])){
            echo "Your website is: " . $_POST["website"] . "<br>";
        }
        if (isset($_POST["comment"])){
            echo "Your comment is: " . $_POST["comment"] . "<br>";
        }
        if (isset($_POST["gender"])){
            echo "Your gender is: " . $_POST["gender"] . "</p>";
        }

        echo "<p>You created your account on " . date("Y-m-d") . " at " . date("H:i") . "</p>";
        $d=mktime(14, 00, 00, 8, 21, 2019);
        echo "<p>This website started on " . date("Y-m-d", $d) . " at " . date("H:i", $d) . "</p>"
    ?>

    <?php include '../templates/footer.php'; ?>
</body>
</html>