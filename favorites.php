<?php
     session_start();
     if(!isset($_SESSION['7thArt_user_id']))
     {
         header("Location: login.php");
         exit;
     }


?>

<!DOCTYPE html>
<html>

    <head>
        <link rel='stylesheet' href='./styles/favorites.css?ts=<?=time()?>&quot'>
        <script src='./scripts/favorites.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta charset="utf-8">

        <title>7thArt-Preferiti</title>
    </head>
    <body>
        <nav>
        <a href="homepage.php">Home</a>
        <a href="search.php">Cerca</a>
        <a href="create_post.php">Nuovo post</a>
        <a href="favorites.php">Preferiti</a>
        <a href="logout.php">Logout </a>
        </nav>
        <header>
            <div id ="overlay"></div>
            <div class ='flex-container'>
            <img id="title" src="./images/SeventhArt.png">
            </div>
        </header>
        
        <main>
            <h1 id="welcome">Ciao <?php echo $_SESSION["7thArt_username"]; ?>, ecco i tuoi film preferiti :</h1>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Rating</th>
                    <th></th>
                </tr>
            </table>
        </main>
    </body>
</html>