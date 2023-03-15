<div class="col-12 col-md-2">
    <div class="text-center mt-3 mt-sm-3"><input type="button" class="btn" name="start" id="start_workout" value="Start"></div>
    <div id="counter-workout"></div>
    <div id="counter-series"></div>
    <div class="text-center mt-3 mt-sm-3"><input type="button" id="next" class="btn" value="Dalej"></div>
</div>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Db_query.php';
    
    $get_workout = new Db_query();
    $get_workout->getworkout();
?>
<script>
    let counterElementTR = 1; // aktualnie który element tr
    let counterButton = 0;
    $("#next").css({"display": "none"});
    
    try
    {
        let tableDay = document.getElementsByTagName("tr"); //wszystkie tagi tr w tabeli
        tableDay[counterElementTR].style.background = "rgba(240,128,0,0.3)"; //na starcie pierwsze ćwiczenie na pomarańczowo
        let series = tableDay[counterElementTR].childNodes.item(2); // wyświetla liczbę serii

        $("#start_workout").click(function ()
        {
            counterButton++;
            this.style.display = "none";

            $("#counter-workout").text("Ćwiczenie nr "+ counterElementTR);
            $("#counter-series").text("seria nr " + counterButton);
            $("#next").css({"display": "block"}).click(function ()
            {
                counterButton++;
                $("#counter-workout").text("Ćwiczenie nr "+ counterElementTR);
                $("#counter-series").text("seria nr " + counterButton);

                if(Number(counterButton) > Number($(series).text()))
                {
                    try
                    {
                        tableDay[counterElementTR].style.background = "rgba(13,166,0,0.3)";
                        counterElementTR++;
                        series = tableDay[counterElementTR].childNodes.item(2);
                        tableDay[counterElementTR].style.background = "rgba(240,128,0,0.3)";
                        counterButton = 1;
                        $("#counter-workout").text("Ćwiczenie nr "+ counterElementTR);
                        $("#counter-series").text("seria nr " + counterButton);
                    }
                    catch(err)
                    {
                        $("#next").css({"display": "none"}); 
                    }
                }
            });
        });
    }
    catch(err)
    {
        $("#start_workout").css({"display": "none"});
        $("tr").css({"display": "none"});
    }
</script>