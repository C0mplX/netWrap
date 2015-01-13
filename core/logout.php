<?php
require '../core/init.php';
$memID = $_SESSION['id'];

session_start();
session_destroy();

header('Location: ../index.php');
?>