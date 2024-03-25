<?php session_start();
if(!isset($_GET['Message']))
{
    
}
else
{
    print ('<script type="text/javacript">alert("' . $_GET['Message'] . '")</script>');
}
    if(empty($_SESSION))
    {
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запросы</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?php include '../../includes/RPage/nav-bar.php';?>
    <h1 class="margin">Мои заявки</h1>
    <?php
        require_once '../db.php';
        $login = $_SESSION['login'];
        $password = $_SESSION['password'];

        $req2 = $pdo->query("SELECT * FROM problemCategory ORDER BY id");
        $array2 = $req2->fetchAll();
        $req3 = $pdo->query("SELECT * FROM users WHERE login = '$login'");
        $array3 = $req3->fetchAll();
        $userId = $array3[0]['id'];
        $req1 = $pdo->query("SELECT * FROM request WHERE request.userId = '$userId' ORDER BY addDate DESC");
        $array1 = $req1->fetchAll();
        $req4 = $pdo->query("SELECT * FROM decisions");
        $decisions = $req4->fetchAll();
    ?>
    <table>
        <?php
        if(!empty($array1)) :?>
            <tr>
                <td class="cool-cell-header">ID</td>
                <td class="cool-cell-header">Название</td>
                <td class="cool-cell-header">Описание</td>
                <td class="cool-cell-header">Категория</td>
                <td class="cool-cell-header">Фото до</td>
                <td class="cool-cell-header">Фото после</td>
                <td class="cool-cell-header">Решение</td>
                <td class="cool-cell-header">Причина отказа (если отказано)</td>
            </tr>
            <?php foreach($array1 as $element) : ?>
                    <tr>
                        <td class="cool-cell-info cool-cell-centerText"><?= $element['id'] ?></td>
                        <td class="cool-cell-info cool-cell-centerText"><?= $element['name']?></td>
                        <td class="cool-cell-info"><?= $element['description']?></td>
                        <?php
                            for($i = 0; $i < count($array2); $i++) :?>
                            <?php if($array2[$i]['id'] == $element['categoryId']) :?>
                                <td class="cool-cell-info cool-cell-centerText"><?= $array2[$i]['name']?></td>
                            <?php endif;?>
                            <?php endfor;?>
                        
                        <td class="cool-cell-info"> <img class="request-img" src="../../img/<?= $element['photo']?>" alt="Отсутствует"> </td>
                        <td class="cool-cell-info">
                            <?php if($element['proofPhoto'] != null):?>
                                <img class="request-img" src="../../img/<?= $element['proofPhoto']?>" alt="Отсутствует">
                            <?php else:?>
                                <p>Пока что не приложено</p>
                            <?php endif;?>
                        </td>
                        <td class="cool-cell-info cool-cell-centerText"><?= $decisions[$element['decision']-1]['name']?></td>
                        <td class="cool-cell-info">
                            <?php if($element['rejectionReason'] != null && $element['decision'] == 3):?>
                                <?= $element['rejectionReason']?>
                            <?php else:?>
                                <p class="cool-cell-centerText">--</p>
                            <?php endif;?>
                        </td>
                        <td>
                            <div>
                            <button>
                                <a href="removeReq.php?id=<?= $element['id']; ?>" onclick="return confirm('Вы уверены?')">Удалить</a>
                            </button>
                            </div>
                        </td>
                    </tr>
            <?php endforeach;?>
        <?php else :?>
            <p class="margin">У Вас нету заявок</p>
        <?php endif;?>
    </table>
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>
</html>