<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/session.php';
    
    start_session();
    
    if($_SESSION['logged'] == 1)
    {
        require_once __DIR__.'/modules/theme.php';
    }
    else
        echo "Twoja sesja wygasła. <a href='../index.php'>Zaloguj</a> się ponownie.";
?>

