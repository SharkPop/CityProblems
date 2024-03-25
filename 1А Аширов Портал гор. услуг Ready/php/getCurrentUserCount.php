<?php 
    require_once 'db.php';
    $userCountReq = $pdo->query("SELECT * FROM users"); $usersArray = $userCountReq->fetchAll(); $userCount = count($usersArray);   echo("На сайте $userCount пользователей");
?>