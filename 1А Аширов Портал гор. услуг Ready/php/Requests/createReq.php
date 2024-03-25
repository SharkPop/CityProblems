<?php session_start();
if (empty($_SESSION)) {
    header("Location: ../../index.php");
}
    if(!isset($_GET['Message']))
    {
        
    }
    else
    {
        print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать запрос</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?php
        include '../../includes/RPage/nav-bar.php';
        require_once '../db.php';
        $req1 = $pdo->query("SELECT * FROM problemCategory ORDER BY id");
        $array1 = $req1->fetchAll();
    ?>
    <form class="margin parent-center" action="getRequestData.php" method="post" enctype="multipart/form-data">
        <div class="child-center">
        <div class="mb">
            <p>Название проблемы</p>
            <input required name="nameReq" type="text">
        </div>
        <div class="mb">
            <p>Описание проблемы</p>
            <input required name="descReq" type="text">
        </div>
        <div class="mb">
            <p>Категория проблемы</p>
            <select required name="selectedCategory" id="">
                <option disabled selected value></option>
                <?php foreach($array1 as $element) :?>
                    <option value="<?= $element['id']?>"><?= $element['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="mb">
            <p>Добавить фотографию</p>
            <input required type="file" required name="file">
        </div>
        <div class="mt">
            <button type="submit">Отправить запрос на решение проблемы</button>
        </div>
        </div>
    </form>
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>
</html>