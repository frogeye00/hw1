<?php 
    require_once 'dbconfig.php';

    session_start();
    // Verifica se l'utente è loggato
    if(!isset($_SESSION['7thArt_user_id']))
    {
        // Vai alla login
        header("Location: login.php");
        exit;
    }


    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $_SESSION['7thArt_user_id']);
    $postid = mysqli_real_escape_string($conn, $_POST["postid"]);

    // Se la richiesta è di aggiunta del commento, faccio insert, altrimenti visualizzo soltanto
    if(isset($_POST["comment"])) {
        if (!empty($_POST["comment"])) {
            // Aggiungo il commento come entry
            $text = mysqli_real_escape_string($conn, $_POST["comment"]);
            $in_query = "INSERT INTO comments(user, post, text) VALUES($userid, $postid, '".$text."')";
            // Scatta il trigger che aggiorna il numero di commenti
            mysqli_query($conn, $in_query) or die (mysqli_error($conn));   
        }
    }

    // Prendo tutti gli user che hanno commentato quel post
    $out_query = "SELECT comments.id AS id, username, text, time
                    FROM comments LEFT JOIN users ON user = users.id 
                    WHERE comments.post = $postid ORDER BY id DESC LIMIT 30";


    $ncomms_query="SELECT posts.ncomments AS ncomments FROM posts where 
                    posts.id=$postid ";
    
    $res = mysqli_query($conn, $out_query) or die (mysqli_error($conn));
    $res1 = mysqli_query($conn, $ncomms_query) or die (mysqli_error($conn));
    $returnarray = array();
    if( $entry1=mysqli_fetch_assoc($res1) ){
        $ncomments=$entry1['ncomments'];
    }
    // $ncomments=0;
    // if($entry1['ncomments']!= 0){
    //     $ncomments=$entry1['ncomments'];
    //}
    //print_r($ncomments);


    while($entry = mysqli_fetch_assoc($res)) {
        // Per ogni utente, ritorno le informazioni
        $returnarray[] = array('id' => $entry['id'], 'username' => $entry['username'], 
        'text' => $entry['text'], 'time' => getTime($entry['time']),'ncomments'=>$ncomments);

    }
    

    echo json_encode($returnarray);

    mysqli_close($conn);

    exit;

    function getTime($timestamp) {      
        // Ritorna la data di pubblicazione del post, relativamente alla data attuale       
        $old = strtotime($timestamp); 
        $diff = time() - $old;           
        $old = date('d/m/y', $old);

        if ($diff /60 <1) {
            return intval($diff%60)." sec";
        } else if ($diff / 60 < 60) {
            return intval($diff/60)." min";
        } else if ($diff / 3600 <24) {
            return intval($diff/3600) . " h";
        } else if ($diff/86400 < 30) {
            return intval($diff/86400) . " g";
        } else {
            return $old; 
        }
    }
    
?>