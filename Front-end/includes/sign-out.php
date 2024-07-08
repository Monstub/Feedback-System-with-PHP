<?php
session_start();

session_destroy();

header('Location:/feedback-proj/adminPage.php');
?>