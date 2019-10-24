
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <fieldset class="w3-container dark form">
        
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