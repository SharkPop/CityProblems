<?php
    if(isset($_GET['id']))
    {
        require_once '../db.php';
        $id = $_GET['id'];
        $req1 = $pdo->query("DELETE FROM request WHERE id='$id'");
        $message = "Запрос удалён!";
        exit(header("Location: requests.php?Message=" . urldecode($message)));
    }
    else
    {
        $message = "Ошибка!";
        exit(header("Location: requests.php?Message=" . urldecode($message)));
    }
?>