<?php
    
    session_start();
    // Verifica se l'utente è loggato
    if(!isset($_SESSION['7thArt_user_id']))
    {
        // Vai alla login
        header("Location: login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html>

    <head>
        <link rel='stylesheet' href='./styles/homepage.css?ts=<?=time()?>&quot'>
        <script src='./scripts/homepage.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta charset="utf-8">

        <title>7thArt-Home</title>
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
            <h1 id="welcome">Ciao <?php echo $_SESSION["7thArt_username"]; ?>,benvenuto nel nostro forum di discussione su cinema, serie Tv e tanto altro!</h1>
            
            <section id="feed">
                <template id="post_template">
                    <article class="post">
                        <div class="remove_button"></div>
                        <div class="userinfo">
                            
                            <div class="names">
                            
                                <div class="username"></div>
                                
                            </div>
                            <div class="time"></div>
                        </div>
                        <div class="title"></div>
                        <div class="content"></div>
                        <div class="actions">
                            <div class="like"><span></span></div>
                            <div class="comment"><span></span></div> 
                        </div>
                        <div class="comments">
                            <div class="past_messages"></div>
                            <div class="comment_form">
                                <form autocomplete="off">
                                    <input type="text" name="comment" maxlength="254" placeholder="Scrivi un commento..." required="required">
                                    <input type="submit">
                                    <input type="hidden" name="postid">
                                </form>
                            </div>
                        </div>
                    </article>
                </template>
                
            </section>
        </main>
        <footer>
            <p>
                <div class ='flex-container'>
                <p id="footer">Matteo Celia <br> N°Matricola:1000001836</p>
                </div>
            </p>
        </footer>
    </body>
</html>

