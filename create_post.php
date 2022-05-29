<?php 

    session_start();

    if(!isset($_SESSION['7thArt_user_id']))
    {
        header("Location: login.php");
        exit;
    }



?>


<html>
    <head>
        <link rel='stylesheet' href='./styles/create_post.css?ts=<?=time()?>&quot'>
        <script src='./scripts/create_post.js' defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <title>7thArt-Crea un nuovo post!</title>
    </head>
    <body>
    <nav>
        <a href="homepage.php">Home</a>
        <a href="search.php">Cerca</a>
        <a href="create_post.php">Nuovo post</a>
        <a href="favorites.php">Preferiti</a>
        <a href="logout.php">Logout </a>
        </nav>  
        <div id="regdiv">
            <main id="new_post">
                <img src="./images/SeventhArt.png" id="title">
                <h3>Ciao <?php echo $_SESSION["7thArt_username"]; ?>,crea un nuovo post!</h3>
                <form name='newpost' method='post' >
                    <p class="title">
                        <label>Titolo <textarea rows="3" cols="65" name='title' maxlength="31" placeholder="Inserisci un titolo..." required="required" <?php if(isset($_POST["title"])){echo "value=".$_POST["title"];} ?> ></textarea></label>
                    </p>

                    <p class="content">
                        <label>Contenuto <textarea rows="20" cols="65" name='content' maxlength="500" placeholder="Inserisci del testo..." required="required"<?php if(isset($_POST["content"])){echo "value=".$_POST["content"];} ?>></textarea></label>
                    </p>
                    <p>
                        <label>&nbsp;<input type='submit' value='Crea post'></label>
                    </p>
                </form>
            </main>
        </div>
       
    </body>
</html>