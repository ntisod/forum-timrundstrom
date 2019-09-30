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
    <?php include 'templates/header.php'; ?>

    <h2>Posts</h2>
    <div class="flex-container">
        
        <form action="" method="get" class="center">
            <input type="search" name="searchpost" placeholder="Search" id="search">
            <select name="sortBy" id="sortBy">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
            </select>
            Following: <input type="checkbox" name="following">
        </form>
    </div>

    <?php include 'templates/footer.php'; ?>

</body>
</html>