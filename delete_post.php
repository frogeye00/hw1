<?php
    require_once 'dbconfig.php';

    if(!isset($_POST['postid']))
    {
       
        exit;
    }

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    //$userid = mysqli_real_escape_string($conn, $_SESSION['7thArt_user_id']);
    $postid = mysqli_real_escape_string($conn, $_POST["postid"]);
    $delete_query="DELETE FROM posts where posts.id =$postid";

    if(mysqli_query($conn, $delete_query)) {
        echo json_encode(array('ok' => true));
        mysqli_close($conn);
        exit;
    }
    else{
        echo json_encode(array('ok' => false));
        mysqli_close($conn);
        exit;
    }
    

?>