
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
    <fieldset class="w3-container dark form">
        
        <label for="file">Profil Bild:</label><br>
        <input type="file" name="file">
        <?php echo "<p class=\"errortxt\">" . $pictureError . "</p>" ?><br>

        <label for="username">*Användarnamn:</label><br>
        <input type="text" name="username" placeholder="Username" value="<?php
        if ($username != "" || !isset($_COOKIE["username"])){
            echo $email;
        } else {
            echo $_COOKIE["username"];
        }
        ?>"><br>
        <?php echo "<p class=\"errortxt\">" . $usernameErr . "</p>" ?><br>

        <label for="email">*E-post:</label><br>
        <input type="email" name="email" placeholder="E-mail" 
        value="<?php 
        if ($email != "" || !isset($_COOKIE["email"])){
            echo $email;
        } else {
            echo $_COOKIE["email"];
        }
        ?>"><br>
        <?php echo "<p class=\"errortxt\">" . $emailErr . "</p>" ?><br>

        <label for="password">*Lösenord:</label><br>
        <input type="password" name="password" placeholder="Password"><br>
        <?php echo "<p class=\"errortxt\">" . $passwordErr . "</p>" ?><br>

        <label for="confpassword">*Bekräfta Lösenord:</label><br>
        <input type="password" name="confpassword" placeholder="Confirm Password"><br>
        <?php echo "<p class=\"errortxt\">" . $confpasswordErr . "</p>" ?><br>

        <label for="gender">*Kön:</label><br>
        <?php echo "<p class=\"errortxt\">" . $genderErr . "</p>" ?><br>
        <input type="radio" name="gender" value="male" 
        <?php if (isset($gender) && $gender == "male") echo "checked" ?>>Man<br>
        <input type="radio" name="gender" value="female" 
        <?php if (isset($gender) && $gender == "female") echo "checked" ?>>Kvinna<br>
        <input type="radio" name="gender" value="other" 
        <?php if (isset($gender) && $gender == "other") echo "checked" ?>>Annat<br>

        <input type="submit" value="Registrera" class="sumbit">

    </fieldset> 
</form>