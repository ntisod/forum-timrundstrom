<nav class="w3-bar dark">
        <a class="w3-bar-item white" href="..">Hem</a>
        <a class="w3-bar-item white">Nytt inlägg</a>
        <a class="w3-bar-item white" href="../html/profile.php">Konto</a>
        <input type="search" name="" id="" placeholder="..." class="w3-bar-item w3-gray">
        <a class="w3-bar-item white go">Sök</a>
        <?php
        if (!isset($_SESSION["account"])){
                echo "<a class=\"w3-bar-item w3-right white\" href=\"../html/login.php\">Logga in</a>";
        } else {
                echo "<a class=\"w3-bar-item w3-right white\" href=\"../templates/logout.php\">Logga ut</a>";
        }
        ?>
</nav>