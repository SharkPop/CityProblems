<?php
require_once '../db.php';
    if(isset($_POST['createCat']))
    {
        if(!empty($_POST['newCat']))
        $newCatName = $_POST['newCat'];
        $req1 = $pdo->query("INSERT INTO problemCategory(name) VALUES('$newCatName')");
        $message = "Категория создана!";
        exit(header("Location: Admin.php?Message=" . urldecode($message)));
    }
    if(isset($_POST['deleteCat']))
    {
        if(!empty($_POST['selectedCat']))
        {
            $selectedCat = $_POST['selectedCat'];
            $req2 = $pdo->query("DELETE FROM problemCategory WHERE id='$selectedCat'");
            $message = "Категория удалена!";
            exit(header("Location: Admin.php?Message=" . urldecode($message)));
        }
    }
?>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.js"></script>