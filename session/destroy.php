<?php
    session_start();
    $_SESSION = [];
    session_destroy();

    header('Location: ../session/new.php');
    exit;