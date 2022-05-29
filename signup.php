<?php
require_once 'dbconfig.php';
session_start();

// Verifica l'accesso
if(isset($_SESSION["7thArt_user_id"]))
{
    // Vai alla home
    header("Location: homepage.php");
    exit;
}

if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["name"]) && 
    !empty($_POST["surname"]) && !empty($_POST["confirm_password"])){
        $error=array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
        $pattern="/^[a-zA-Z0-9_]{1,16}$/";

        # USERNAME
        if(!preg_match($pattern, $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
         # PASSWORD
         if (!preg_match("/^[A-Za-z0-9_!%&?]{8,20}$/",$_POST["password"])) {
            $error[] = "Caratteri password insufficienti";
        } 
        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
        # EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata";
            }
        }

        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, password, name, surname, email) VALUES('$username', '$password', '$name', '$surname', '$email')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["7thArt_username"] = $_POST["username"];
                $_SESSION["7thArt_user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: homepage.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }
        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }
        

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel='stylesheet' href='./styles/signup.css?ts=<?=time()?>&quot'>
        <script src='./scripts/signup.js' defer></script>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 

        <title>7thArt-Registrati!</title>
    </head>
    <body>
        <div id="regdiv">
            <main>
                <img src="./images/SeventhArt.png" id="title">
                <h3>Registrati!</h3>
                <form name='registration' method='post' autocomplete='off'>
                    <p class="name">
                        <label>Nome <input type='text' name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> ></label>
                        <span>Inserire solo lettere e spazi</span>
                    </p>
                    <p class="surname">
                        <label>Cognome <input type='text' name='surname' <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?>></label>
                        <span>Inserire solo lettere e spazi</span>
                    </p>
                    <p class="username">
                        <label>Username <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?> ></label>
                        <span>Sono ammessi solo lettere, numeri e underscore.Max:16</span>
                    </p>
                    <p class="email">
                        <label>E-mail <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>></label>
                        <span>Email non valida</span>
                    </p>
                    <p class="password">
                        <label>Password <input class="psw" type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>></label>
                        <label>&nbsp;<input type="button" value="Mostra/nascondi password" class="password_show"></label>
                        <span>Password non valida.Min:8</span>
                    </p>
                    <p class="confirm_password">
                        <label>Confirm Password <input class="psw" type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>></label>
                        <label>&nbsp;<input type="button" value="Mostra/nascondi password" class="password_show"></label>
                        <span>Le password non coincidono</span>
                    </p>
                    <p>
                        <label>&nbsp;<input type='submit' value='Registrati' id="submit" disabled></label>
                    </p>
                </form>
                <div class="accedi">Hai già un account?<a class="accedi" href='login.php'>Accedi</a></div>
            </main>
        </div>
       
    </body>
</html>