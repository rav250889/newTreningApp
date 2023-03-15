<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/ConfigFile.php';
 
?>
<main class="container-fluid py-5 mt-sm-5">
    <form action="index.php" method="post">
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="host">Serwer</label>
            <input type="text" name="host" id="host" class="form-control col-sm-6 col-md-5">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="dbuser">Użytkownik</label>
            <input type="text" name="userdb" id="dbuser" class="form-control col-sm-6 col-md-5">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="dbpass">Hasło</label>
            <input type="password" name="passworddb" id="dbpass" class="form-control col-sm-6 col-md-5">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="dbname">Nazwa bazy danych</label>
            <input type="text" name="namedb" id="dbname" class="form-control col-sm-6 col-md-5">
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-4 mt-1" for="port">Port</label>
            <input type="text" name="portdb" placeholder="3306" id="port" class="form-control col-sm-6 col-md-5">
        </div>
        <div class="text-center mt-5 mt-sm-3">
            <input class="btn col-6 col-sm-3 col-md-2 col-xl-1" type="submit" name="acceptdb" value="Zapisz" onclick="this.disabled=true;this.value='Proszę czekać...';this.form.submit();">
        </div>
    </form>
<?php
        $config = new ConfigFile();

        $config->create_file();
?>
</main>
