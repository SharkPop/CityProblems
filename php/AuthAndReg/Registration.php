<?php session_start();
if(!isset($_GET['Message']))
{
    if(!empty($_POST['nameReg']) && !empty($_POST['loginReg']) && !empty($_POST['emailReg']) && !empty($_POST['passwordReg']) && !empty($_POST['repeatPassword']) && !empty($_POST['agreement']))
    {
        require_once '../db.php';
        $name = $_POST['nameReg'];
        $password = $_POST['passwordReg'];
        $login = $_POST['loginReg'];
        $email = $_POST['emailReg'];
        $repeatPassword = $_POST['repeatPassword'];
        $agreement = $_POST['agreement'];
        if($agreement == true)
        {
            $req2 = $pdo->query("SELECT * FROM users");
            $users = $req2->fetchAll();
            foreach($users as $element)
            {
                if($element['login'] == $login || $element['email'] == $email)
                {
                    $message = "Логин или почта уже существует!";
                    exit(header("Location: Registration.php?Message=" . urldecode($message)));
                }
            }
            if($password == $repeatPassword)
            {
                $req1 = $pdo->query("INSERT INTO users(name,login,email,password,userType) VALUES('$name','$login','$email','$password',2)");
                session_unset();
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                header("Location: ../../index.php");
            }
            else
            {
                $message = "Пароли не совпадают!";
                exit(header("Location: Registration.php?Message=" . urldecode($message)));
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
    <title>Регистрация</title>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="../../js/jquery-3.3.1.min.js"></script>
</head>
<body class="bgimg-auth bgFone">
    <?php include '../../includes/AARPage/nav-bar-reg.php';?>
    <form class="parent-center" action="Registration.php" method="post">
        <div class="aar-child-vcenter auth-block-bg">
        <h1>Регистрация</h1>
    <div>
        <p>ФИО</p>
        <input required type="text" name="nameReg">
    </div>
    <div class="mt">
        <p>Логин</p>
        <input required type="text" name="loginReg">
    </div>
    <div class="mt">
        <p>Email</p>
        <input required type="email" name="emailReg">
    </div>
    <div class="mt">
        <p>Пароль</p>
        <input required type="text" name="passwordReg">
    </div>
    <div class="mt">
        <p>Повторите пароль</p>
        <input type="text" name="repeatPassword">
    </div>
    <div class="mt">
        <p>Согласие на обработку персональных данных</p>
        <input required type="checkbox" name="agreement">
    </div>
    <button>Зарегестрироваться</button>
        </div>
    </form>
    <script src="../../js/bootstrap.js"></script>
</body>
</html>