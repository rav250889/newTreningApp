<div class="col-md-9 mb-5 mt-5">
    <h1 class="text-center mb-3 mb-md-5">Zmień ćwiczenie</h1>
    <form action="index.php?page=updateWorkout" method="post">
        <div class="row form-group mx-1 mx-auto col-xl-6">
            <label class="col-sm-5 mt-1">Ćwiczenie</label>
            <input class="form-control col-sm-6 col-md-5" type="text" name="workoutname">
        </div>
        <div class="row form-group mx-1 mx-auto col-xl-6">
            <label class="col-sm-5 mt-1">Ilość serii</label>
            <input class="form-control col-sm-6 col-md-5" type="text" name="series">
        </div>
        <div class="row form-group mx-1 mx-auto col-xl-6">
            <label class="col-sm-5 mt-1">Ilość powtórzeń</label>
            <input class="form-control col-sm-6 col-md-5" type="text" name="repetitions">
        </div>
        <div class="text-center mt-3 mt-sm-3">
            <input class="btn col-5 col-sm-3 col-md-2 col-xl-1" id="accetworkout" type="submit" name="accetworkout" value="Zapisz">
            <input class="btn col-5 col-sm-3 col-md-2 col-xl-1" id="cancelworkout" type="submit" name="cancelworkout" value="Anuluj">
        </div>
    </form>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
        require_once $_SERVER['DOCUMENT_ROOT'].'/functions/errors.php';
        
        function backToIndex()
        {
            $url = "index.php";

            if (!headers_sent())
            {
                header('Location: '.$url);
                exit;
            }
            else 
            {
                echo '<script type="text/javascript">';
                echo 'window.location.href="'.$url.'";';
                echo '</script>';
                exit;
            }
        }
        if(isset($_GET['id']))
        {
            $setElementId = new Db_query();
            mysqli_query($setElementId->connectDb(), "UPDATE addresses SET path=".$_GET['id']." WHERE id=3");
        }
        if(isset($_POST['cancelworkout']))
        {
            backToIndex();
        } 
        if(isset($_POST['workoutname']) || isset($_POST['series']) || isset($_POST['repetitions']))
        {
            $workoutname = filter_var($_POST['workoutname'], FILTER_SANITIZE_STRING);
            $series = filter_var($_POST['series'], FILTER_SANITIZE_STRING);
            $repetitions = filter_var($_POST['repetitions'], FILTER_SANITIZE_STRING);

            if(!empty($workoutname) || !empty($series) || !empty($repetitions))
            {
                if(isset($_POST['accetworkout']))
                {
                    if(((!is_numeric($repetitions)) && $repetitions != "") || ((!is_numeric($series)) && $series != ""))
                    {
                        error("Pole ilość serii oraz ilość powtórzeń musi być liczbą");
                    }
                    else
                    {
                        $getElementId = new Db_query();
                        $query = mysqli_query($getElementId->connectDb(), "SELECT path FROM addresses WHERE id=3");
                        $row = mysqli_fetch_assoc($query);
                        $getElementId->update_workout($workoutname, $series, $repetitions , $row['path']);
                        backToIndex();
                    }
                }
            }
            else
            {
                error("Wszystkie pola są puste");
            }  
        }
    ?>
</div>
