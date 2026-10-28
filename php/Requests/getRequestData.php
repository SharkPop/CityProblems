<?php
session_start();
    if(!empty($_FILES['file']['name']) && !empty($_POST['nameReq']) && !empty($_POST['descReq']) && !empty($_POST['selectedCategory']))
    {
        require_once '../../img/imgPath.php';
        require_once '../db.php';
        $allowed = array("image/jpg","image/jpeg","image/png","image/bmp");
        if(in_array($_FILES['file']['type'],$allowed))
        {
            if($_FILES['file']['size'] <= 10485760)
            {
                move_uploaded_file($_FILES['file']['tmp_name'], $moveImageToPath."/".$_FILES['file']['name']);
                if(move_uploaded_file($_FILES['file']['tmp_name'], $moveImageToPath."/".$_FILES['file']['name']) == UPLOAD_ERR_OK)
                {
                    $login = $_SESSION['login'];
                    $req2 = $pdo->query("SELECT * FROM users WHERE login = '$login'");
                    $user = $req2->fetchAll();
                    var_dump($user);
        
                    $name = $_POST['nameReq'];
                    $desc = $_POST['descReq'];
                    $category = $_POST['selectedCategory'];
                    $filename = $_FILES['file']['name'];
                    $userId = (int)$user[0]['id'];
                    $req1 = $pdo->query("INSERT INTO request(userId,name,description,categoryId,photo,decision) VALUES('$userId','$name','$desc','$category','$filename',1)");
                    $message = "Запрос создан!";
                    exit(header("Location: requests.php?Message=" . urldecode($message)));
                }
            }
            else
            {
                $message = "Файл не должен превышать 10Мб !";
                exit(header("Location: createReq.php?Message=" . urldecode($message)));
            }
        }
        else
        {
            $message = "Файл может быть только таких форматов: png, jpg, jpeg или bmp !";
            exit(header("Location: createReq.php?Message=" . urldecode($message)));
        }
    }
    else
    {
        header("Location: createReq.php");
    }
?>