<form action="<?php 
    
    //echo $_SERVER["PHP_SELF"];
    if (isset($_GET["id"]) && is_numeric($_GET["id"])){
        echo "../html/post.php?id=" . $_GET["id"];
    } else {
        echo "../html/post.php";
    }

    ?>" method="post">
    <fieldset class="w3-container w3-center dark form">

        <?php
            if (isset($_GET["id"]) && is_numeric($_GET["id"])){
                $getID = $_GET["id"];
                echo "<input type=\"hidden\" name=\"id\" value=\"$getID\"></input>";
            }
        ?>

        <textarea class="text" name="text" placeholder="..."><?php echo $commenttext; ?></textarea>
        <?php echo "<p class=\"errortxt\">" . $commenttextErr . "</p>" ?><br>
        <input type="submit" value="Kommentera" class="sumbit">
    </fieldset> 
</form>