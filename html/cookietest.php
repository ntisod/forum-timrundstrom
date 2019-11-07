<!DOCTYPE html>
<html>
<body>
    
    <?php

    $cookie_name = "user";
    $cookie_value = "John Doe";

    //setcookie($cookie_name, $cookie_value, time() + 86400 * 30, "/"); // 86400 * 30 = 1 day
    setcookie($cookie_name, $cookie_value, time()-5, "/");

    if (isset($_COOKIE[$cookie_name])){
        echo "Cookie " . $cookie_name . " is set!<br>";
        echo "Value is: " . $_COOKIE[$cookie_name];
    } else {
        echo "Cookie " . $cookie_name . " is not set.";
    }
    ?>

</body>
</html>
