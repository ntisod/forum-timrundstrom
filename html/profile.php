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
        <!--img src="./pictures/nti-logo-black.png" alt="Svart NTI logga"-->
        <h1>NTI Forum</h1>
    </header>

    <?php include '../templates/navbar.php'; 

    echo "<h2 class=\"w3-center\">Konto</h2>";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_unset();
        session_destroy();
    }


    if (isset($_SESSION["account"])){

        echo <<<HTML
        <div class="w3-center"><img class="profilePic" src="../pictures/profile-pictures/{$_SESSION['account']}.jpg" /></div> 
        <p class="w3-center">Välkommen {$_SESSION["account"]}!</p>
        
        <form action="{$_SERVER['PHP_SELF']}" method="post" class="w3-center">
        <input type="submit" value="Logga ut" class="submit">
        </form>
HTML;

    } else {
        echo <<<HTML
        <p class="w3-center"> Vänligen logga in </p>
        <form action="./login.php" method="get" class="w3-center">
        <input type="submit" value="Logga in" class="submit">
        </form>
HTML;
    }
    
    include '../templates/footer.php'; ?>

</body>
</html>