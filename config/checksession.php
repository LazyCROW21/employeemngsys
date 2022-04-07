<?php
session_start();
if(!isset($_SESSION['UserId'])) {
    header('Location: ' . '/login.php', true, 302);
    die();
}
?>
