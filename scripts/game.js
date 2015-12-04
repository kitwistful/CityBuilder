/**
* scripts/game.js
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This file has the functions and such for running the game.
*
**/
function gameLoop(name, number)
{
    // if no number assume it's the first iteration
    if(number == undefined)
        number = 1;
    
    // ask for data
    $.post("../scripts/game_update.php",
        {testmessage: "this is iter " + number
        },
        function(text){
        $(name).html("got: "+text+"<br />" );
        },
        "text");
        
    // wait and then go again
    setTimeout(function(){
        gameLoop(name, number+1);
        }, 1000);
}