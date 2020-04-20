
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
    <fieldset class="w3-container dark form">
        
        <label for="file">Profil Bild:</label><br>
        <input type="file" name="file">
        <?php echo "<p class=\"errortxt\">" . $pictureError ."</p>" ?><br>

        <label for="email">E-post:</label><br>
        <input type="email" name="email" placeholder="E-mail" value="<?php
        if(isset($result['email'])) echo $result['email'];?>"><br>
        <?php echo "<p class=\"errortxt\">" . $emailErr . "</p>" ?><br>

        <label for="beskrivning">Beskrivning:</label><br>
        <input type="text" name="beskrivning" value="<?php
        if(isset($result['beskrivning'])) echo $result['beskrivning'];?>"><br>

        <label for="gender">Kön:</label><br>
        <input type="radio" name="gender" value="male" 
        <?php if (isset($result['gender']) && $result['gender'] == "male") echo "checked" ?>>Man<br>
        <input type="radio" name="gender" value="female" 
        <?php if (isset($result['gender']) && $result['gender'] == "female") echo "checked" ?>>Kvinna<br>
        <input type="radio" name="gender" value="other" 
        <?php if (isset($result['gender']) && $result['gender'] == "other") echo "checked" ?>>Annat<br>


        <label for="password">Nytt Lösenord:</label><br>
        <input type="password" name="password" placeholder="Password"><br>
        <?php echo "<p class=\"errortxt\">" . $pswErr . "</p>" ?><br>

        <label for="confpassword">Bekräfta Nytt Lösenord:</label><br>
        <input type="password" name="confpassword" placeholder="Confirm Password"><br>
        <?php echo "<p class=\"errortxt\">" . $confpswErr . "</p>" ?><br>

        <input type="hidden" value="false" name="edit">
        <input type="hidden" value="true" name="update"> 

        <input type="submit" value="Spara" class="sumbit">
        <input type="submit" name="cancel" value="Avbryt" class="submit">
    </fieldset> 
</form>