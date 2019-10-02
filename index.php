<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="./styles/flex.css">
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <link rel="stylesheet" type="text/css" href="./styles/media.css">
    <title>NTI Forum</title>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <h2>Posts</h2>
    <div class="flex-container">
        <form action="" method="get" class="center">
            <input type="search" name="searchpost" placeholder="Search" class="search">
            <select name="sortBy" id="sortBy">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
            </select>
            <div>Following: <input type="checkbox" name="following"></div>
        </form>
    </div>

    <div class="buttons">
        <a class="previous button">&#8249;</a>
        <a class="number button selected">1</a>
        <a class="number button">2</a>
        <a class="number button">3</a>
        <p> . . . </p>
        <a class="number button">5</a>
        <a class="next button">&#8250;</a>
    </div>

    <section class="wrapper">
        <article class="main">
            <?php 
                for ($x = 0; $x < 7; $x++) {
                    include 'templates/post-flow.php';
                }
            ?> 
        </article>
        <aside class="aside side-left">
            <img src="./pictures/college-students-purple-hue.jpg" alt="">
            <img src="./pictures/college-students-purple-hue.jpg" alt="">
        </aside>
        <aside class="aside side-right">
            <img src="./pictures/student-purple-hue.jpg" alt="">
            <img src="./pictures/student-purple-hue.jpg" alt="">
        </aside>
    </section>

    <div class="buttons">
        <a class="previous button">&#8249;</a>
        <a class="number button selected">1</a>
        <a class="number button">2</a>
        <a class="number button">3</a>
        <p> . . . </p>
        <a class="number button">5</a>
        <a class="next button">&#8250;</a>
    </div>

    <?php include 'templates/footer.php'; ?>

</body>
</html>