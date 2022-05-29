<?php 
    require_once 'dbconfig.php';

    session_start();

    if(!isset($_SESSION['7thArt_user_id']))
     {
         header("Location: login.php");
         exit;
     }
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
    $userid=mysqli_real_escape_string($conn, $_SESSION["7thArt_user_id"]);

    if(isset($_POST['title'])){
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $rating=mysqli_real_escape_string($conn,$_POST['rating']);
        $query="INSERT into favorites(user,title,rating) VALUES('$userid','$title','$rating')";
        if(mysqli_query($conn, $query)) {
            echo json_encode(array('ok' => true));
            exit;
        }
        else{
            echo json_encode(array('ok' => false));
            exit;
        }
    }

    if(isset($_GET['title'])){
        
        $title=mysqli_real_escape_string($conn,$_GET['title']);
        $query="DELETE from favorites where user=$userid and title='$title'";
        if(mysqli_query($conn, $query)) {
            echo json_encode(array('ok' => true));
            exit;
        }
        else{
            echo json_encode(array('ok' => false));
            exit;
        }
    }


    mysqli_close($conn);

?>