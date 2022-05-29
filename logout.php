<?php
    include 'dbconfig.php';

    session_start();

    // Distruggo la sessione corrente
    session_destroy();

    header('Location: login.php');
?>