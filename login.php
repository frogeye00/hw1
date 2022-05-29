<?php
    require_once 'dbconfig.php';
    session_start();
    
    //Verifica l'accesso
    if(isset($_SESSION["7thArt_user_id"]))
    {
        // Vai alla home
        header("Location: homepage.php");
        exit;
    }
    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
        {
            // Se username e password sono stati inviati
            // Connessione al DB
            $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
            // Preparazione 
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            // Permette l'accesso tramite email o username in modo intercambiabile
            $searchField = filter_var($username, FILTER_VALIDATE_EMAIL) ? "email" : "username";
            // ID e Username per sessione, password per controllo
            $query = "SELECT id, username, password FROM users WHERE $searchField = '$username'";
            // Esecuzione
            $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
            if (mysqli_num_rows($res) > 0) {
                // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
                $entry = mysqli_fetch_assoc($res);
                if (password_verify($_POST['password'], $entry['password'])) {
    
    
                    // Imposto una sessione dell'utente
                    $_SESSION["7thArt_username"] = $entry['username'];
                    $_SESSION["7thArt_user_id"] = $entry['id'];
                    header("Location: homepage.php");
                    mysqli_free_result($res);
                    mysqli_close($conn);
                    exit;
                }
            }
            // Se l'utente non è stato trovato o la password non ha passato la verifica
            $error = "Username e/o password errati.";
            mysqli_close($conn);
        }
        else if (isset($_POST["username"]) || isset($_POST["password"])) {
            // Se solo uno dei due è impostato
            $error = "Inserisci username e password.";
        }
    


?>

<html>
    <head>
        <link rel='stylesheet' href='./styles/signup.css?ts=<?=time()?>&quot'>
        <script src='./scripts/login.js' defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <title>7thArt-Accedi!</title>
    </head>
    <body>
        <div id="regdiv">
            <main id="login">
                <img src="./images/SeventhArt.png" id="title">
                <h3>Accedi!</h3>
                <?php
                // Verifica la presenza di errori
                if (isset($error)) {
                    echo "<span class='errore'>$error</span>";
                }
                
                ?>
                <form name='login' method='post' >
                    <p class="username">
                        <label>Username <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?> ></label>
                    </p>

                    <p class="password">
                        <label>Password <input type='password' name='password' id="password"<?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                          
                        </label>
                        <label>&nbsp;<input type="button" value="Mostra/nascondi password" id="password_show"></label>
                    </p>
                    <p>
                        <label>&nbsp;<input type='submit' value='Accedi'></label>
                    </p>
                </form>
                <div class="accedi">Non hai ancora un account?<a class="accedi" href='signup.php'>Registrati</a></div>
            </main>
        </div>
       
    </body>
</html>