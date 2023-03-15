$(document).ready(function (){
       
    $("#change").click(function (){
        let inputs = document.getElementsByClassName("change-data");
        
        for(let i = 0; i < inputs.length; i++)
        {
            inputs[i].disabled = false;
        }
        
        $("#settings div").css({"display": "flex"});
        $("#buttons").css({"display": "block"});
        $("#settings div:nth-child(3) input").val("");
        
    });
});

