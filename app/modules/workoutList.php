<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
                                      
    if(isset($_GET['page']))
    {
        $page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);

        if(!empty($page))
        {
            if(is_file("modules/".$page.".php"))
            {
                require_once "modules/".$page.".php";
            }
            else
                echo error("Taka strona nie istnieje");
        }  
    }
    else
    {
        $get_workout = new Db_query();
        $get_workout->getworkout(true);
    }

    if($_GET['page'] == "workoutList")
    {
        $get_workout = new Db_query();
        $get_workout->getworkout(true);
    }

    setcookie("id", $_GET['id']);
?>

