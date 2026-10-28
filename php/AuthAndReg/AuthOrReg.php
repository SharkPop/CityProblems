<?php session_start();
if(!isset($_GET['Message']))
{
    session_start();        
    if(!empty($_POST['login']) && !empty($_POST['password']))
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        var_dump($login);
        var_dump($password);

        require_once '../db.php';
        $req = $pdo->query("select * from users order by id");
        $array = $req->fetchAll();

        foreach($array as $element)
        {
            if($element['login'] == $login && $element['password'] == $password)
            {
                //Записываем куки для того, чтобы запомнить логин и пароль
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                exit(header('Location: ../../index.php'));
                
            }
        }
        $message = "Логин или пароль не верны";
        exit(header("Location: AuthOrReg.php?Message=" . urldecode($message)));
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
    <title>Войти на сайт</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="bgimg-auth">
    <?php include '../../includes/AARPage/nav-bar-auth.php';?>
    <form class="parent-center" action="AuthOrReg.php" method="post">
        <div class="aar-child-vcenter auth-block-bg">
        <div class="mb">
            <p>Логин</p>
            <input type="text" name="login">
        </div>
        <div class="mb">
            <p>Пароль</p>
            <input type="text" name="password">
        </div>
        <button>Войти</button>
        </div>
    </form>
    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/bootstrap.js"></script>
</body>
</html>