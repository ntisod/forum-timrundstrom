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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        if (empty($_GET["user"])){ // TODO: Show your account

            if (isset($_SESSION["account"])){

                $email = $_SESSION["account"];
                $sql = "SELECT email, regdate FROM users WHERE email='$email' LIMIT 1";
                $result = get_data($sql);
                display_account($result);

                echo <<<HTML
                    <form action="{$_SERVER['PHP_SELF']}" method="post" class="w3-center">
                    <input type="submit" value="Logga ut" class="submit">
                    </form>
                HTML;

            } else {
                header('Location: ./login.php');
            }


        } else{ // TODO: Show account by id

           $user = $_GET["user"];
           $sql = "SELECT email, regdate FROM users WHERE email='$user' LIMIT 1";
           $result = get_data($sql);
           if (!empty($result)){

                display_account($result);

                if (isset($_SESSION["account"])){
                    if ($_SESSION["account"] == $result['email']){
                        echo <<<HTML
                            <form action="{$_SERVER['PHP_SELF']}" method="post" class="w3-center">
                            <input type="submit" value="Logga ut" class="submit">
                            </form>
                         HTML;
                    }
                }

           } else {
               no_account_found();
           }

        }

    }

    

    function no_account_found(){
        echo "<h2 class=\"w3-center\"> Oops! </h2>";
        echo "<p class=\"w3-center\"> Inget konto hittades </p>";
    }

    function get_data($sql) {

        require("../includes/settings.php");
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $dbpassword);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Find existing user
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetch();

        } catch(PDOException $e) {
            $conn = null;
            return null;
        }
        $conn = null;


        return $result;
    }

    function display_account($result){
        if (!empty($result)){

            $email = $result['email'];

            $now = time(); // or your date as well
            $your_date = strtotime($result['regdate']);
            $datediff = $now - $your_date;
            $age = $datediff / (60 * 60 * 24);
            $age = round($age, 0);

            echo <<<HTML
            <div class="w3-center"><img class="profilePic" src="../pictures/profile-pictures/{$email}.jpg" /></div> 
            <h3 class="w3-center">{$email}!</h3>
            
            <p class="w3-center">Kontot är {$age} dagar gammalt.</p>
    
         HTML;

        }
    }

    include '../templates/footer.php'; ?>

</body>
</html>