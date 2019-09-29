<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./styles/flex.css">
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <title>NTI Forum</title>
</head>
<body>
    <header>
        <div class="flex-container">
            <div class="header-item"><a><img src="./pictures/nti-logo-black.png" alt="Svart NTI logga" class="logo"></a></div>
            <div class="header-item title"><a><h1>NTI Forum</h1></a></div>
            <div class="header-item"></div>
        </div>

        <div class="flex-container">
            <div class="navbar-item"><a>Post</a></div>
            <div class="navbar-item"><a>Profile</a></div>
            <div class="navbar-item"><a>Login</a></div>
        </div>
    </header>

    <section>
        <h2>Inlägg</h2>
        
        <form action="" method="get">
            <input type="search" name="searchpost" placeholder="Sök" id="search">
            <select name="sortBy" id="sortBy">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
            </select>
        </form>
    </section>

    <footer>
        <div class="flex-container">
            <div class="navbar-item"><a>NTI</a></div>
            <div class="navbar-item"><a>Contact</a></div>
            <div class="navbar-item"><a>About</a></div>
        </div>
    </footer>

</body>
</html>