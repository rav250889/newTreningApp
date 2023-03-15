<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
?>
<main class="container-fluid py-5 mt-sm-1">
    <form action="index.php?page=registration" method="post">
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="newlogin">Login</label>
            <input type="text" class="form-control col-sm-6 col-md-5" id="newlogin" name="newlogin">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="newpassword">Hasło</label>
            <input type="password" class="form-control col-sm-6 col-md-5" id="newpassword" name="newpassword">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="firstname">Imię</label>
            <input type="text" class="form-control col-sm-6 col-md-5" id="firstname" name="firstname">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="lastname">Nazwisko</label>
            <input type="text" class="form-control col-sm-6 col-md-5" id="lastname" name="lastname">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="email">Email</label>
            <input type="email" class="form-control col-sm-6 col-md-5" id="email" name="email">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="refresh"><small>Jeśli kod jest nieczytelny kliknij <a class="refresh-captcha font-weight-bold" id="refresh">tutaj</a></small></label>
            <img src="/modules/captcha.php" alt="CAPTCHA" id="captcha" class="captcha-image">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="captcha">Przepisz kod z obrazka</label>
            <input class="form-control col-sm-6 col-md-5" type="text" id="captcha" name="captcha" pattern="[A-Z]{6}" placeholder="Przepisz kod z obrazka">
        </div>
        <div class="text-center mt-3 mt-sm-3">
            <input type="submit" class="btn col-5 col-sm-3 col-md-2 col-xl-1" name="save-user" value="Zapisz" id="dupa">
            <input type="submit" class="btn col-5 col-sm-3 col-md-2 col-xl-1" name="cancel-user" value="Anuluj">
        </div>
    </form>
    <?php
        $check_user = new Db_query();
        $check_user->checkUserExist();
    ?>
</main>
<script>
    $(".refresh-captcha").click(function (){
        document.querySelector(".captcha-image").src = '/modules/captcha.php?' + Date.now();
    });
</script>

