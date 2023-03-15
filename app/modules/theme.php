<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Head.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Header.php';
?>
<html lang="PL">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <?php
            $head = new Head("Plan ćwiczeń", "/css/theme.css");
            $head->get_head();
        ?>
        <script src="/app/js/jquery.js" type="text/javascript"></script>
        <script src="/app/js/layout.js" type="text/javascript"></script>
    </head>
    <body>       
        <header class="container-fluid">
            <nav class="navbar navbar-dark navbar-expand-md">  
                <?php
                
                    $header = new Header("/img/logo.png");
                    $header->get_logo();
                ?>
                <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expand="false" aria-label="Przełącznik nawigacyny">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-md-none" id="mainmenu">
                    <ul class="navbar-nav d-md-none">
                        <li class="nav-item"><a class="nav-link" href="?page=startWorkout">Zacznij ćwiczyć</a></li>
                        <li class="nav-item"><a class="nav-link" href="?page=workoutList">Lista ćwiczeń</a></li>
                        <li class="nav-item"><a class="nav-link" href="?page=addWorkout">Dodaj ćwiczenie</a></li>
                        <li class="nav-item"><a class="nav-link" href="?page=settings">Ustawienia</a></li>
                        <li class="nav-item"><a class="nav-link" href="?page=logout">Wyloguj</a></li>
                    </ul>
                </div>
                <form class="d-none d-md-block" id="logout-form" action="/index.php" method="post">
                    <input class="btn mt-md-3" type="submit" value="<?php echo $_SESSION['login']?>" name="logout">
                </form>
            </nav>
        </header>
        <main class="container-fluid" style="margin-bottom: 0;">
            <div class="row">
                <nav class="navbar navbar-dark col-3 col-xl-2 d-none d-md-block lead" style="height: 85vh;">
                    <ul class="navbar-nav mt-3 ml-3">
                        <li class="nav-item mt-3"><a class="nav-link" href="?page=startWorkout">Zacznij ćwiczyć</a></li>
                        <li class="nav-item mt-3"><a class="nav-link" href="?page=workoutList">Lista ćwiczeń</a></li>
                        <li class="nav-item mt-3"><a class="nav-link" href="?page=addWorkout">Dodaj ćwiczenie</a></li>
                        <li class="nav-item mt-3"><a class="nav-link" href="?page=settings">Ustawienia</a></li>
                    </ul>
                </nav>
                <?php
                    include __DIR__.'/workoutList.php'; 
                    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/logout.php';      
                    if($_GET['page'] == "logout" || isset($_POST['logout'])) logout();
                ?>
            </div>
        </main>
        <footer class="container-fluid page-footer position-fixed fixed-bottom">
            <p class="footer-copyright text-center">&copy; Created by Rafał Wałach | RWDesigner</p>
        </footer>   
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="/js/bootstrap.min.js"></script>
    </body>
</html>