<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../styles/flex.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <link rel="stylesheet" type="text/css" href="../styles/media.css">
    <title>NTI Forum</title>
</head>
<body>

    <?php include '../templates/header.php'; ?>

    <h2>Login</h2>
    <!--
    <div class="flex-container">
        <form action="" method="get" class="center loginfield flex-container">
            <div class="center">Username: <input type="text" name="" id=""></div>
            <div class="center">Password: <input type="password" name="" id=""></div>
            <input type="submit" value="Login" class="center">
        </form>
    </div>
    -->

    <section class="wrapper">
        <article class="main">
            <div class="flex-container">
                <form action="" method="get" class="center loginfield flex-container">
                    <div class="search">Username: </div>
                    <input type="text" name="" id="">
                    <div class="search">Password: </div>
                    <input type="password" name="" id="">
                    <div class="checkbox"><input type="checkbox" name="" id=""> Keep me logged in.</div>
                    <input type="submit" value="Login" class="loginBtn">
                    <div class="tinyLink"><a href="">Forgot Password?</a><a href="">Create Account</a></div>
                </form>
            </div>
        </article>
        <aside class="aside side-left">
            <img src="../pictures/college-students-purple-hue.jpg" alt="">
        </aside>
        <aside class="aside side-right">
            <img src="../pictures/student-purple-hue.jpg" alt="">
        </aside>
    </section>



    <div class="freeze-footer">
    <?php include '../templates/footer.php'; ?>
    </div>

</body>
</html>