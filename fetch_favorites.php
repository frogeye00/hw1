<?php
     require_once 'dbconfig.php';

     session_start();

     if(!isset($_SESSION['7thArt_user_id']))
     {
         header("Location: login.php");
         exit;
     }

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $_SESSION["7thArt_user_id"]);

    $query="SELECT favorites.title as title, favorites.rating as rating from favorites
            where favorites.user=$userid";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    
    $favoritesArray = array();

    while($entry = mysqli_fetch_assoc($res)) {
        $favoritesArray[] = array('title' => $entry['title'], 'rating' => $entry['rating']);
    }

    echo json_encode($favoritesArray);

    mysqli_close($conn);

?>