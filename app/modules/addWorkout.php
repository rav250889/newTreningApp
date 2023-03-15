<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/functions/success.php';
    
    $days = filter_input(INPUT_POST, 'days', FILTER_SANITIZE_STRING);
    $displayday = $days;
    
    if($displayday == "monday") $displayday = "Poniedziałek";
    if($displayday == "tuesday") $displayday = "Wtorek";
    if($displayday == "wednesday") $displayday = "Środa";
    if($displayday == "thursday") $displayday = "Czwartek";
    if($displayday == "friday") $displayday = "Piątek";
    if($displayday == "saturday") $displayday = "Sobota";
    if($displayday == "sunday") $displayday = "Niedziela";
?>
<div class="col-md-9 mb-5 mt-5">
    <form action="index.php?page=addWorkout" method="post">
        <div class="row form-group mx-1 mx-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="days-list">Wybierz dzień tygodnia</label>    
            <select class="form-control col-sm-6 col-md-5" name="days" id="days-list">
                <option id="first" value="<?php echo $days; ?>"><?php echo $displayday; ?></option>
                <option value="monday">Poniedziałek</option>
                <option value="tuesday">Wtorek</option>
                <option value="wednesday">Środa</option>
                <option value="thursday">Czwartek</option>
                <option value="friday">Piątek</option>
                <option value="saturday">Sobota</option>
                <option value="sunday">Niedziela</option>
            </select>
        </div>
        <div class="row form-group mx-1 mx-lg-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="workoutname">Ćwiczenie</label>
            <input type="text" id="workoutname" class="form-control col-sm-6 col-md-5" name="workoutname">
        </div>
        <div class="row form-group mx-1 mx-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="series">Ilość serii</label>
            <input type="text" id="series" class="form-control col-sm-6 col-md-5" name="series">
        </div>
        <div class="row form-group mx-1 mx-auto col-xl-6">
            <label class="col-sm-5 mt-1" for="repetitions">Ilość powtórzeń</label>
            <input type="text" id="repetitions" class="form-control col-sm-6 col-md-5" name="repetitions">
        </div>
        <div class="text-center mt-3 mt-sm-3">
            <input id="accetworkout" class="btn col-5 col-sm-3 col-md-2 col-xl-1" type="submit" name="accetworkout" value="Zapisz">
            <input id="cancelworkout" class="btn col-5 col-sm-3 col-md-2 col-xl-1" type="submit" name="cancelworkout" value="Anuluj">
        </div>
    </form>
    <?php
        if(isset($_POST['workoutname']) && isset($_POST['series']) && isset($_POST['repetitions']))
        {
            $workoutname = filter_var($_POST['workoutname'], FILTER_SANITIZE_STRING);
            $series = filter_var($_POST['series'], FILTER_SANITIZE_STRING);
            $repetitions = filter_var($_POST['repetitions'], FILTER_SANITIZE_STRING);
       
            if(!empty($workoutname) && !empty($series) && !empty($repetitions))
            {
     
                if(isset($_POST['accetworkout']))
                {
                    
                    if(is_numeric($series) && is_numeric($repetitions))
                    {
                        if($days != "")
                        {
                            $add_workout = new DB_query();
                            $add_workout->addworkout($workoutname, $series, $repetitions, $days);
                            success("Dodano nowe ćwiczenie");
                        }
                        else error ("Wybierz dzień tygodnia");
                    }
                    else error("Pole ilość serii oraz ilość powtórzeń musi być liczbą");
                }
            }
            else if(isset($_POST['cancelworkout']))
            {
                $url = "index.php";
                if (!headers_sent()) {
                    header('Location: '.$url);
                    exit;
                } else {
                        echo '<script type="text/javascript">';
                        echo 'window.location.href="'.$url.'";';
                        echo '</script>';
                        exit;
                }
            }
            else error("Uzupełnij wszytkie pola");
        }
    ?>
</div>
