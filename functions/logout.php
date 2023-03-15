<?php
    function logout()
    {
        require_once __DIR__.'/session.php';
        
        start_session();
        
        unset($_SESSION["id"]);
        unset($_SESSION["name"]);
        unset($_SESSION["logged"]);
        
        session_destroy();

        header("Location: ../");
    }
?>

