<?php
function showingIndex() 
{
    if (!isset($_COOKIE['loggedInUser'])) {
        throw new Exception("U bent niet ingelogd, u wordt nu doorgestuurd naar de login pagina.");
    }
    $dsn = "mysql:host=localhost;dbname=netland";
    $user = "root";
    $passwd = "";

    $pdo = new PDO($dsn, $user, $passwd);
    $result_series = "";
    $result_films = "";
    $hi1 = "";
    $hi2 = "";
    $hi3 = "";
    $hi4 = "";
    if(isset($_GET['series_title'])) {
        if($_GET['series_title'] == 'ASC') {
            $result_series = $pdo->query("SELECT id, title, rating FROM media WHERE media_type = 'serie' ORDER BY title ASC");
            $hi1 = '<i id="hi" class="fas fa-sort-up">';
        } else {
            $result_series = $pdo->query("SELECT id, title, rating FROM media WHERE media_type = 'serie' ORDER BY title DESC");
            $hi1 = '<i id="hi" class="fas fa-sort-down">';
        }
    }
    if(isset($_GET['series_rating'])) {
        if($_GET['series_rating'] == 'ASC') {
            $result_series = $pdo->query("SELECT id, title, rating FROM media WHERE media_type = 'serie' ORDER BY rating ASC");
            $hi2 = '<i id="hi" class="fas fa-sort-up">';
        } else {
            $result_series = $pdo->query("SELECT id, title, rating FROM media WHERE media_type = 'serie' ORDER BY rating DESC");
            $hi2 = '<i id="hi" class="fas fa-sort-down">';
        }
    }
    if(isset($_GET['films_title'])) {
        if($_GET['films_title'] == 'ASC') {
            $result_films = $pdo->query("SELECT id, title, duration FROM media WHERE media_type = 'movie' ORDER BY title ASC");
            $hi3 = '<i id="hi" class="fas fa-sort-up">';
        } else {
            $result_films = $pdo->query("SELECT id, title, duration FROM media WHERE media_type = 'movie' ORDER BY title DESC");
            $hi3 = '<i id="hi" class="fas fa-sort-down">';
        }
    }
    if(isset($_GET['films_duration'])) {
        if($_GET['films_duration'] == 'ASC') {
            $result_films = $pdo->query("SELECT id, title, duration FROM media WHERE media_type = 'movie' ORDER BY duration ASC");
            $hi4 = '<i id="hi" class="fas fa-sort-up">';
        } else {
            $result_films = $pdo->query("SELECT id, title, duration FROM media WHERE media_type = 'movie' ORDER BY duration DESC");
            $hi4 = '<i id="hi" class="fas fa-sort-down">';
        }
    }
    if($result_series == "") {
        $result_series = $pdo->query("SELECT id, title, rating FROM media WHERE media_type = 'serie'");
    }
    if($result_films == "") {
        $result_films = $pdo->query("SELECT id, title, duration FROM media WHERE media_type = 'movie'");
    }
    $remember_sort = "";
    $remember_sort2 = "";
    if(array_key_exists('series_title', $_GET)) {
        $remember_sort = "&series_title=".$_GET['series_title'];
    }
    if(array_key_exists('series_rating', $_GET)) {
        $remember_sort = "&series_rating=".$_GET['series_rating'];
    }
    if(array_key_exists('films_title', $_GET)) {
        $remember_sort2 = "&films_title=".$_GET['films_title'];
    }
    if(array_key_exists('films_duration', $_GET)) {
         $remember_sort2 = "&films_duration=".$_GET['films_duration'];
    }

    $series_title = "index.php?series_title=";
    if(isset($_GET['series_title'])) {
        $series_title .= $_GET['series_title'] === 'DESC' ? 'ASC' : 'DESC';
    } else {
        $series_title .= 'DESC';
    } 
    $series_title .= $remember_sort2;

    $series_rating = "index.php?series_rating=";
    if(isset($_GET['series_rating'])) {
        $series_rating .= $_GET['series_rating'] === 'DESC' ? 'ASC' : 'DESC';
    } else {
        $series_rating .= 'DESC';
    } 
    $series_rating .= $remember_sort2;

    $films_title = "index.php?films_title=";
    if(isset($_GET['films_title'])) {
        $films_title .= $_GET['films_title'] === 'DESC' ? 'ASC' : 'DESC';
    } else {
        $films_title .= 'DESC';
    } 
    $films_title .= $remember_sort;

    $films_duration = "index.php?films_duration=";
    if(isset($_GET['films_duration'])) {
        $films_duration .= $_GET['films_duration'] === 'DESC' ? 'ASC' : 'DESC';
    } else {
        $films_duration .= 'DESC';
    } 
    $films_duration .= $remember_sort;
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="CSS/theme.css">
        <script src="https://kit.fontawesome.com/a9861e1bf8.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <main>
            <div id="saveButton">
                <h1 id="fxw2">Welkom op het netland beheerderspaneel</h1>
                <form action="/PHP/logout.php" method="post">
                    <input type="submit" name="submit" value="logout">
                </form>
            </div>
            <div id="move">
                <div>
                    <div class="shapehead">
                        <h2 class="fl">Series</h2>
                        <div>
                            <button class="bf" onclick="location.href='overlord.php?torun=2'">Add new!</button>
                        </div>
                    </div>
                    <table>
                    <tr><th style='width:150px'><a href=<?php echo $series_title; ?>>Title<?php echo $hi1; ?></i></a></th>
                    <th style='width:150px'><a href=<?php echo $series_rating; ?>>Rating<?php echo $hi2; ?></i></a></th></tr>
                    <?php 
                    while($row_series = $result_series->fetch()) {
                        echo '<tr><td><a href="overlord.php?id='.$row_series['id'].'&torun=1">';
                        echo($row_series['title'] . '</a></td><td style="text-align:center;">' .  $row_series['rating']);
                        echo '</td></tr>';
                    }
                    ?>
                    </table>
                </div>
                <div>
                    <div class="shapehead">
                        <h2 class="fl">Films</h2>
                        <i class="fas fa-sort-up"></i>
                        <div>
                            <button class="bf" onclick="location.href='overlord.php?torun=5'">Add new!</button>
                        </div>
                    </div>
                    <table>
                    <tr><th style='width:150px'><a href=<?php echo $films_title ?> >Title<?php echo $hi3; ?></a></th>
                    <th style='width:150px'><a href=<?php echo $films_duration ?> >Duration<?php echo $hi4; ?></i></a></th></tr>
                    <?php 
                    while($row_films = $result_films->fetch()) {
                        echo '<tr><td><a href="overlord.php?id='.$row_films['id'].'&torun=4">';
                        echo($row_films['title'] . '</td><td style="text-align:center;">' .  $row_films['duration']);
                        echo '</td></tr>';
                    }
                    ?>    
                    </table>
                </div>
            </div>
        </main>
    </body>
    </html>
    <?php
}
try {
    showingIndex();
} catch (Exception $e) {
    echo '<h1>' . $e->getMessage() . '</h1>';
    echo "<script>setTimeout(\"location.href = '/PHP/logout.php';\",1500);</script>";
}
?>
