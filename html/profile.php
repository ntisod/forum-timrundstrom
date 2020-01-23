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
        header('Location: ../templates/logout.php');
    }


    if (isset($_SESSION["account"])){

        require("../includes/settings.php");

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Find existing user
            $email = $_SESSION["account"];
            $stmt = $conn->prepare("SELECT email, regdate FROM users WHERE email='$email' LIMIT 1");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();

            // HOW DO I GET EMAIL AND PASSWORD VALUES? TODO:
            if (!empty($result)){

                $now = time(); // or your date as well
                $your_date = strtotime($result['regdate']);
                $datediff = $now - $your_date;
                $age = $datediff / (60 * 60 * 24);
                $age = round($age, 0);

            }
        } catch(PDOException $e) {
        }
        $conn = null;

        if ($age > 365){
            $years = round($age / 365, 0);
            $months = round($age / 30, 0);
            $months = $months - (12 * $years);
            $days = $age - (365 * $years) - (30 * $months);

            $age_message = "Ditt konto är $years år, $months månader och $days dagar gammalt";
        } else if ($age > 30){
            $age = round($age / 30, 0);
            $age_message = "Ditt konto är $age månader gammalt";
        } else {
            $age_message = "Ditt konto är $age dagar gammalt";
        }
        
        echo <<<HTML
        <div class="w3-center"><img class="profilePic" src="../pictures/profile-pictures/{$_SESSION['account']}.jpg" /></div> 
        <p class="w3-center">Välkommen {$_SESSION["account"]}!</p>
        
        <p class="w3-center">$age_message</p>

        <form action="{$_SERVER['PHP_SELF']}" method="post" class="w3-center">
        <input type="submit" value="Logga ut" class="submit">
        </form>
HTML;

    } else {
        header('Location: ./login.php');
    }
    
    include '../templates/footer.php'; ?>

</body>
</html>