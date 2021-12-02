<?php
    session_start();
    session_destroy();
    header('Location: stranka3_logged_out.php');
    exit;
