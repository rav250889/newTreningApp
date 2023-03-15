<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
    
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
?>
        <main class="container-fluid py-5 mt-sm-5">
            <form action="index.php" method="post">
                <div class="row form-group mx-1 mx-lg-auto col-xl-6">
                    <label class="col-sm-4 mt-1" for="login">Nazwa użytkownika</label>
                    <input type="text" class="form-control col-sm-6 col-md-5" id="login" name="login">
                </div>
                <div class="row form-group mx-1 mx-lg-auto col-xl-6">
                    <label class="col-sm-4 mt-1" for="password">Hasło</label>
                    <input type="password" class="form-control col-sm-6 col-md-5" id="password" name="password">
                </div>
                <div class="row mx-1 mt-4 mx-lg-auto col-xl-6">
                    <a class="col-sm-4" href="?page=resetPassword">Nie pamiętam hasła</a>
                </div>
                <div class="row mx-1 mt-3 mx-lg-auto col-xl-6">
                    <a class="col-sm-4" href="?page=registration">Zarejestruj się</a>
                </div>
                <div class="text-center mt-5 mt-sm-3">
                    <button class="btn col-6 col-sm-3 col-md-2 col-xl-1" name="acceptlogin">Zaloguj</button>
                </div>
            </form>

                <?php
    }
                    $authorization = new DB_query();

                    $authorization->authorization();
                ?>
        </main>