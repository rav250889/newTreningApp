<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
    
    $change = new Db_query();
?>
<div class="col-md-9 mb-5 mt-5">
    <form id="settings" action="index.php?page=settings" method="post">
        <div class="mt-1 mb-3 mt-sm-3">
            <input class="btn col-5 col-sm-3 col-md-2 col-xl-1" type="button" value="Zmień" id="change">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="name">Imię i nazwisko</label>
            <input id="name" class="change-data form-control col-sm-6 col-md-5" type="text" value="<?php echo $_SESSION['firstname']."".$_SESSION['lastname'];?>" name="names" disabled>
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="old-password">Obecne Hasło</label>
            <input id="old-password" class="change-data form-control col-sm-6 col-md-5" type="password" value="1234567890" name="old-password" disabled>
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6" style="display: none;">
            <label class="col-sm-5 mt-1" for="new-password1">Nowe Hasło</label>
            <input id="new-password1" class="change-data form-control col-sm-6 col-md-5" type="password" name="new-password1">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6" style="display: none;">
            <label class="col-sm-5 mt-1" for="new-password2">Powtórz nowe hasło</label>
            <input id="new-password2" class="change-data form-control col-sm-6 col-md-5" type="password" name="new-password2">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="email">Email</label>
            <input id="email" class="change-data form-control col-sm-6 col-md-5" type="email" value="<?php echo $_SESSION['email'];?>" name="email" disabled>
        </div>
        <div class="text-center mt-3 mb-5 mt-sm-3" id="buttons" style="display: none;">
            <input class="btn col-5 col-sm-3 col-md-2 col-xl-1" type="submit" value="Zapisz" name="save-changes">
            <input class="btn col-5 col-sm-3 col-md-2 col-xl-1" type="submit" value="Anuluj" name="decline-changes">
        </div>
    </form>

    <?php
        if(isset($_POST['save-changes']))
        {
            if(isset($_POST['names']))
            {
                $names = filter_var($_POST['names'], FILTER_SANITIZE_STRING);

                if(!empty($names))
                {
                    $firstname = strtok($names, " ");
                    $lastname = substr($names, strpos($names, " ") + 1);
                    $_SESSION['firstname'] = $firstname." ";
                    $_SESSION['lastname'] = $lastname." ";
                }
                else error ("Wprowadź imię i nazwisko");  
            }

            if(isset($_POST['email']))
            {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

                if(!empty($email))
                {
                    $_SESSION['email'] = $email;
                }
                else error ("Wprowadź adres email");
            }

            if(isset($_POST['old-password']) && isset($_POST['new-password1']) && isset($_POST['new-password2']))
            {
                $old_password = filter_var($_POST['old-password'], FILTER_SANITIZE_STRING);
                $new_password1 = filter_var($_POST['new-password1'], FILTER_SANITIZE_STRING);
                $new_password2 = filter_var($_POST['new-password2'], FILTER_SANITIZE_STRING);

                if(!empty($old_password) && !empty($new_password1) && !empty($new_password2))
                {
                    $result = mysqli_query($change->connectDb(), "SELECT password FROM users where login='".$_SESSION['login']."'");
                    $row = mysqli_fetch_assoc($result);
                    if(password_verify($old_password, $row['password']))
                    {
                        $actual_password = $old_password;

                        if($new_password1 == $new_password2)
                        {
                            $new_password = $new_password2;
                        }
                        else error ("Nowe hasła nie są identyczne");
                    }
                    else error("Obecne hasło jest niepoprawne. Jeśli nie pamiętasz hasła przejdź <a href='../index.php?page=resetPassword'>tutaj</a>");
                }
            }
            if(!empty($email) && !empty($names))
            {
                $change->change_user_data($firstname, $lastname, $email, $actual_password, $new_password);
                header("Location: index.php?page=settings");
            }
        }
        if(isset($_POST['decline-changes']))
        {
            header("Location: index.php?page=settings");
        } 
    ?>
</div>

