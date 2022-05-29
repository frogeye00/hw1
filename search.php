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
        <link rel='stylesheet' href='./styles/search.css?ts=<?=time()?>&quot'>
        <script src='./scripts/search.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <!-- <link rel="icon" type="image/png" href="favicon.png"> -->
        <meta charset="utf-8">

        <title>7thArt-Cerca</title>
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
            <h1 id="welcome">Ciao <?php echo $_SESSION["7thArt_username"]; ?>, cerca un film attraverso il titolo per conoscerne il rating IMDb!</h1>
            <form name='search' method='post'>
                <input type="text" name="title" placeholder="Inserisci il titolo di un film" id="title_search">
                <input type='submit' value='Cerca'>
            </form>
            
            <section id="filmview">
                <article id="film">
                    <div id="button"></div>
                    <h2 id="film_title"></h2>
                    <span id="rating"></span>
                    <img id="image">
                     
                </article>
            </section>
        </main>
    </body>
</html>

