<?php
    session_start();
    session_destroy();
    $url = '../organization_login.html';
    header('Location: ' . $url);
?>