<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Улучши свой город</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/slider.css">
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
</head>

<body class="bgimg-auth">



    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Городской портал</a>
                <?php
                require_once 'php/db.php';
                $userCountReq = $pdo->query("SELECT * FROM users");
                $usersArray = $userCountReq->fetchAll();
                $userCount = count($usersArray);
                ?>
                <div id="timer">На сайте <?php echo $userCount; ?> пользователей</div>
                <script>
                    $(document).ready(function() {
                        var interval; // переменная для хранения интервала

                        function updateTimer() {
                            $.ajax({
                                url: 'php/getCurrentUserCount.php',
                                success: function(data) {
                                    $('#timer').text(data);
                                }
                            });
                        }
                        // Запуск таймера с интервалом в 5 секунду
                        interval = setInterval(updateTimer, 5000);
                    });
                </script>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php

                    $requestsReq = $pdo->query("SELECT * FROM request WHERE decision = 2 ORDER BY id DESC");
                    $reustsArray = $requestsReq->fetchAll();
                    $reqCount = count($reustsArray);
                    if ($reqCount != 0) : ?>
                        <?php if ($reqCount == 1) : ?>
                            <li class=""><?= $reqCount ?> решённая заявка</li>
                        <?php else : ?>
                            <li class="active verticalAlg"><?= $reqCount ?> решённых заявок</li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <li class="active"><a href="index.php">Главная</a></li>
                    <li class="dropdown">
                        <?php
                        if (isset($_SESSION['login']) && isset($_SESSION['password'])) : ?>
                            <?php
                            $login = $_SESSION['login'];
                            $password = $_SESSION['password'];
                            $req1 = $pdo->query("SELECT * FROM users WHERE login = '$login' AND password = '$password'");
                            $array1 = $req1->fetchAll();
                            if (isset($login) && isset($login)) : ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?=
                                    $name = $array1[0]['name'];
                                    ?>
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="php/Requests/requests.php">Мои заявки</a></li>
                                    <li><a href="php/Requests/createReq.php">Новая заявка</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="php/exit.php">Выход</a></li>
                                </ul>
                            <?php endif; ?>
                        <?php else : ?>
                    <li><a href="php/AuthAndReg/Registration.php">Зарегистрироваться</a></li>
                    <li><a href="php/AuthAndReg/AuthOrReg.php">Войти</a></li>
                <?php endif; ?>
                </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="jumbotron">
        <div class="container">
            <h1>Привет, дорогой друг!</h1>
            <p>
                Вместе мы сможем улучшить наш любимый город. Нам очень сложно узнать обо всех проблемах города, поэтому мы
                предлагаем тебе помочь своему городу!
            </p>
            <p>
                Увидел проблему? Дай нам знать о ней и мы ее решим!
            </p>
            <p>
                <a class="btn btn-success btn-lg" href="php/Requests/createReq.php" role="button">Сообщить о проблеме</a>
                <a class="btn btn-primary btn-lg" href="php/AuthAndReg/AuthOrReg.php" role="button">Присоедениться к проекту</a>
            </p>
        </div>
    </div>
    <div class="container auth-block-bg">
        <h2>Последние решенные проблемы</h2>
        <br>
        <div class="row">
            <?php
            require_once 'php/db.php';
            $req1 = $pdo->query("SELECT * FROM request WHERE decision = 2 ORDER BY id DESC");
            $array1 = $req1->fetchAll();
            $req2 = $pdo->query("SELECT * FROM problemCategory ORDER BY id");
            $array2 = $req2->fetchAll();
            $count = count($array1) - 1;
            $idcount = 0;
            $catId = 0;
            for ($i = 0; $i < 8; $i++) : ?>
                <?php if (!empty($array1[$i])) : ?>
                    <div class="col-sm-6">
                        <div>
                            <div class="df">
                                <div>
                                    <p class="updatedName<?= $i ?>"><?= $array1[$i]['name'] ?> -</p>
                                </div>
                                <div>
                                    <p class="updatedCat<?= $i ?>">
                                        <?php for ($j = 0; $j < count($array2); $j++) : ?>
                                            <?php if ($array2[$j]['id'] == $array1[$i]['categoryId']) : ?>
                                                <?php $catId = $array2[$j]['id'] ?>
                                                <?= $array2[$catId - 1]['name'] ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="updatedDesc<?= $i ?>"><?= $array1[$i]['description'] ?></p>
                            </div>
                            <div class="df mt w250">
                                <div class="slider<?= $i ?> slider">
                                    <div class="before<?= $i ?> before">
                                        <img class="updatedPhoto<?= $i ?> request-img" src="img/<?= $array1[$i]['photo'] ?>" alt="">
                                    </div>
                                    <div>
                                        <img class="updatedProofPhoto<?= $i ?> request-img " src="img/<?= $array1[$i]['proofPhoto'] ?>" alt="">
                                    </div class="after<?= $i ?> after">
                                    <div class="change<?= $i ?> change"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col-sm-6">
                        <div>
                            <div class="df">
                                <div>
                                    <p class="updatedName<?= $i ?>"></p>
                                </div>
                                <div>
                                    <p class="updatedCat<?= $i ?>">

                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="updatedDesc<?= $i ?>">

                                </p>
                            </div>
                            <div class="df mt w250">
                                <div class="slider<?= $i ?> slider">
                                    <div class="before<?= $i ?> before">
                                        <img class="updatedPhoto<?= $i ?> request-img" src="" alt="">
                                    </div>
                                    <div>
                                        <img class="updatedProofPhoto<?= $i ?> request-img" src="" alt="">
                                    </div class="after<?= $i ?> after">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
                    </div>
        </div>
    </div>
    </div>
    <script src="js/updatePosts.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/slide.js"></script>
</body>

</html>