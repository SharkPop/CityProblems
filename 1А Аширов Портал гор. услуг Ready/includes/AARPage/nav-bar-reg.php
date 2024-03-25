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
                <a class="navbar-brand" href="../../index.php">Городской портал</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="../../index.php">Главная</a></li>
                    <li class="dropdown">
                        <?php
                            if(isset($_SESSION['login']) && isset($_SESSION['password'])) : ?>
                                <?php
                                $login = $_SESSION['login'];
                                $password = $_SESSION['password'];
                                require_once '../../php/db.php';
                                $req1 = $pdo->query("SELECT * FROM users WHERE login = '$login' AND password = '$password'");
                                $array1 = $req1->fetchAll();
                                if(isset($login) && isset($login)) : ?>
                                <?php endif;?>
                                <?php else : ?>
                                    <li><a href="../AuthAndReg/AuthOrReg.php">Войти</a></li>
                                <?php endif;?>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>