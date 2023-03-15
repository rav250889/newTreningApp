<div class="col-md-9 mb-5 mt-5">
    <form id="delete-form" action="index.php?page=deleteWorkout" method="post">
        <h1 class="text-center">Usunąć ćwiczenie?</h1>
        <div class="text-center mt-3 mt-sm-3">
            <input id="delete" type="submit" class="btn col-5 col-sm-3 col-md-2 col-xl-1 btn-danger" name="deleteworkout" value="Tak">
            <input id="cancel" type="submit" class="btn col-5 col-sm-3 col-md-2 col-xl-1" name="stillworkout" value="Nie">
        </div>
    </form>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';

        $id = $_COOKIE['id'];

        if(isset($_POST['deleteworkout']))
        {
             $delete = new DB_query();
             $delete->delete_workout($id);
             header("Location: index.php");
        }
        else if(isset($_POST['stillworkout'])) header("Location: index.php");
    ?>
</div>
