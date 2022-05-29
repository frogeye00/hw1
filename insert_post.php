<?php

    require_once 'dbconfig.php';
    session_start();

    if(!isset($_SESSION['7thArt_user_id']))
    {
        header("Location: login.php");
        exit;
    }

    if (!isset($_POST["title"])) {
    echo "Non si può accedere a questa pagina se non da fetch lato client";
    exit;
    }


    if (!empty($_POST['content'])) {

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    
        $userid = mysqli_real_escape_string($conn, $_SESSION['7thArt_user_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);

        $query = "INSERT INTO posts(user,title, content) VALUES('$userid','$title','$content' )";
    
        if(mysqli_query($conn, $query)) {
            echo json_encode(array('ok' => true));
            exit;
        }
    }
    
    echo json_encode(array('ok' => false));

    mysqli_close();


?>