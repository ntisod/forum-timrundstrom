<!--HTML form for making a post-->
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <fieldset class="w3-container w3-center dark form">

        <input class="title" type="text" name="title" placeholder="Titel" value="<?php echo $title; ?>"><br>
        <?php echo "<p class=\"errortxt\">" . $titleErr . "</p>" ?><br>

        <textarea class="text" name="text" placeholder="..."><?php echo $text; ?></textarea>
        <?php echo "<p class=\"errortxt\">" . $textErr . "</p>" ?><br>
        <input type="submit" value="Lägg upp" class="sumbit">

    </fieldset> 
</form>