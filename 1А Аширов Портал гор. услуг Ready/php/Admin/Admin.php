<?php
    if(!isset($_GET['Message']))
    {
        session_start();
        require_once '../db.php';
        require_once '../../img/imgPath.php';
        $req2 = $pdo->query("SELECT * FROM problemCategory ORDER BY id");
        $array2 = $req2->fetchAll();
        $req3 = $pdo->query("SELECT * FROM users");
        $array3 = $req3->fetchAll();
        $req1 = $pdo->query("SELECT * FROM request");
        $array1 = $req1->fetchAll();
        $req4 = $pdo->query("SELECT * FROM decisions");
        $decisions = $req4->fetchAll();
            if(!empty($_POST['selectedDecision']) && !empty($selID = $_POST['selectedId'])){
                $decID = $_POST['selectedDecision'];
                $selID = $_POST['selectedId'];
                $refuseText = $_POST['refuse'];
                var_dump($decID);
                var_dump($selID);
        
                if($decID == 3 && !empty($refuseText))
                {
                    if($decID == 3 && !empty($refuseText))
                    {
                        $pdo->query("UPDATE request SET decision = '$decID', rejectionReason = '$refuseText' WHERE id = '$selID'");
                        $message = "Изменения применены!";
                        exit(header("Location: Admin.php?Message=" . urldecode($message)));
                    }
                    else
                    {
                        $message = "Поле причины отказа пустое!";
                        exit(header("Location: Admin.php?Message=" . urldecode($message)));
                    }
                }
                if($decID != 3)
                {
                    move_uploaded_file($_FILES['file']['tmp_name'], $moveImageToPath."/".$_FILES['file']['name']);
                    if(move_uploaded_file($_FILES['file']['tmp_name'], $moveImageToPath."/".$_FILES['file']['name']) == UPLOAD_ERR_OK)
                    {
                        $filename = $_FILES['file']['name'];
                        $pdo->query("UPDATE request SET decision = '$decID',proofPhoto = '$filename' WHERE id = '$selID'");
                        $message = "Изменения применены!";
                        exit(header("Location: Admin.php ?Alert=" . urldecode($message)));
                    }
                }
            }
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
    <title>Admin</title>
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
/>
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
<h1 class="margin">Все заявки</h1>
    <div class="margin">
        <div class="df">
        <form action="Admin.php" method="POST" enctype="multipart/form-data">
            <div>
                <p>Выберите ID заявки, у которой хотите изменить решение</p>
                <select class="width" required name="selectedId" id="">
                    <option disabled selected value=""></option>
                    <?php foreach($array1 as $element):?>
                        <?php if($element['decision'] == 1) :?>
                            <option value="<?= $element['id']?>"><?= $element['id']?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <p>Решение</p>
                <select class="width" name="selectedDecision" id="">
                    <?php foreach($decisions as $element) :?>
                            <?php if($element['id'] != 1) :?>
                                <option value="<?= $element['id']?>"><?= $element['name']?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                </select>
            </div>
            <div>
                <p>Причина отказа (если отказ)</p>
                <input class="input-size" type="text" name="refuse">
            </div>
            <div>
                <p>Фото решённой проблемы (если решено)</p>
                <input type="file" name="file">
            </div>
            <button>Изменить</button>
        </form>
        <form action="AddAndRemoveCat.php" method="POST">
            <div class="df">
                <div>
                    <p>Ввести новую категорию</p>
                    <input class="input-size" type="text" name="newCat">
                    <button class="width" type="submit" name="createCat">Создать новую категорию</button>
                </div>
                <div>
                    <p>Удалить категорию</p>
                    <select class="width" name="selectedCat" id="">
                        <option value=""></option>
                        <?php foreach($array2 as $element) :?>
                            <option value="<?= $element['id']?>"><?= $element['name']?></option>
                        <?php endforeach;?>
                    </select>
                    <button class="width" type="submit" name="deleteCat">Удалить категорию</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <table>
        <?php
        if(!empty($array1)) :?>
            <tr>
                <td>ID</td>
                <td>Название</td>
                <td>Описание</td>
                <td>Категория</td>
                <td>Фото до</td>
                <td>Фото после</td>
                <td>Решение</td>
                <td>Причина отказа (если отказано)</td>
            </tr>
            <?php foreach($array1 as $element) : ?>
                    <tr>
                        <td><?= $element['id'] ?></td>
                        <td><?= $element['name']?></td>
                        <td><?= $element['description']?></td>
                        <td><?= $array2[$element['categoryId']-1]['name']?></td>
                        <td> <img class="request-img" src="../../img/<?= $element['photo']?>" alt="Отсутствует"> </td>
                        <td>
                            <?php if($element['proofPhoto'] != null):?>
                                <img class="request-img" src="../../img/<?= $element['proofPhoto']?>" alt="Отсутствует">
                            <?php else:?>
                                <p>Пока что не приложено</p>
                            <?php endif;?>
                        </td>
                        <td><?= $decisions[$element['decision']-1]['name']?></td>
                        <td>
                            <?php if($element['rejectionReason'] != null && $element['decision'] == 3):?>
                                <?= $element['rejectionReason']?>
                            <?php else:?>
                                <p>--</p>
                            <?php endif;?>
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