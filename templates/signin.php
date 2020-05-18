<!--HTML form for signing in-->
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" >
    <fieldset class="w3-container dark form">

        <?php echo "<p class=\"errortxt\">" . $accountErr . "</p>" ?><br>
        
        <label for="email">E-post:</label><br>
        <input id="email" type="email" name="email" placeholder="E-mail" 
        value="<?php 
        
        if ($email != "" || !isset($_COOKIE["email"])){
            echo $email;
        } else {
            echo $_COOKIE["email"];
        }

        ?>"><br>
        <?php echo "<p class=\"errortxt\">" . $emailErr . "</p>" ?><br>

        <label for="password">Lösenord:</label><br>
        <input id="password" type="password" name="password" placeholder="Password"><br>
        <?php echo "<p class=\"errortxt\">" . $passwordErr . "</p>" ?><br>

        <p><a href="../html/register.php">Skapa konto</a></p>

        <input type="submit" value="Logga in" class="sumbit">

    </fieldset> 
</form>