<?php
// session_start();
$db = new PDO('mysql:host=localhost;dbname=beans_app;charset=utf8mb4','root','');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
