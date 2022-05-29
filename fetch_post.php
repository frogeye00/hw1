<?php
    require_once 'dbconfig.php';
    session_start();
    // Controllo che l'accesso sia legittimo
    if (!isset($_SESSION["7thArt_user_id"])) {
        echo "error";
        exit;
    }

    


    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $_SESSION["7thArt_user_id"]);

    $query = "SELECT users.id AS userid, users.name AS name, users.surname AS surname, users.username AS username, posts.id AS postid,
         posts.content AS content,posts.title as title, posts.time AS time, posts.nlikes AS nlikes, posts.ncomments AS ncomments,
        EXISTS(SELECT user FROM likes WHERE post = posts.id AND user = $userid ) AS liked, 
        EXISTS(SELECT user FROM posts WHERE posts.id=postid and posts.user = $userid ) as posted
        FROM posts JOIN users ON posts.user = users.id  ORDER BY postid DESC LIMIT 10";

    
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $postArray = array();
    while($entry = mysqli_fetch_assoc($res)) {
        
        $time = getTime($entry['time']);
        $postArray[] = array('userid' => $entry['userid'], 'name' => $entry['name'], 'surname' => $entry['surname'], 
                            'username' => $entry['username'],'postid' => $entry['postid'],
                            'content' => $entry['content'],'title'=>$entry['title'], 'nlikes' => $entry['nlikes'], 
                            'ncomments' => $entry['ncomments'], 'time' => "$time", 'liked' => $entry['liked'],'posted'=>$entry["posted"]);
    }

    echo json_encode($postArray);

    mysqli_close($conn);
    
    exit;

    function getTime($timestamp) {      
        // Calcola il tempo trascorso dalla pubblicazione del post       
        $old = strtotime($timestamp); 
        $diff = time() - $old;           
        $old = date('d/m/y', $old);

        if ($diff /60 <1) {
            return intval($diff%60)." secondi fa";
        } else if (intval($diff/60) == 1)  {
            return "Un minuto fa";  
        } else if ($diff / 60 < 60) {
            return intval($diff/60)." minuti fa";
        } else if (intval($diff / 3600) == 1) {
            return "Un'ora fa";
        } else if ($diff / 3600 <24) {
            return intval($diff/3600) . " ore fa";
        } else if (intval($diff/86400) == 1) {
            return "Ieri";
        } else if ($diff/86400 < 30) {
            return intval($diff/86400) . " giorni fa";
        } else {
            return $old; 
        }
    }

?>