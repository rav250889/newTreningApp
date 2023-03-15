<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Head.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Header.php';
?>
<html lang="PL">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="../js/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <header class="container-fluid">
            <?php
                $header = new Header("img/logo.png");
                $header->get_logo();
            ?>
        </header>
        <?php
            if(!is_file("config/settings.php"))
            {
                include __DIR__.'/createDatabase.php';
                $head = new Head("Tworzenie bazy danych", "/css/theme.css");
                $head->get_head();
            }
            else
            {
                include __DIR__.'/loginPanel.php';
                $head = new Head("Panel logowania", "/css/theme.css");
                $head->get_head();
            }
        ?>
        <footer class="container-fluid page-footer position-fixed fixed-bottom">
            <p class="footer-copyright text-center">&copy; Created by Rafał Wałach | RWDesigner</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
