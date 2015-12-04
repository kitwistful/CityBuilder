/**
* scripts/game.js
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This file has the functions and such for running the game.
*
**/
function gameLoop(name)
{
    // about to post
    $(name).html("getting info from database....");
    
    // ask for data
    $.post("../scripts/game_update.php",
        {testmessage: "bread"
        },
        function(text){
        $(name).html("got: "+text+"<br />" );
        },
        "text");
        
    // wait 1 minute and then go again
    setTimeout(function(){
        gameLoop(name);
        }, 1000*60);
}