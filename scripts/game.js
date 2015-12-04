/**
* scripts/game.js
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This file has the functions and such for running the game.
*
**/
function gameLoop(name, niters)
{
    $(name).append("prepost for iter " + niters + "<br />");
    $.post("../scripts/game_update.php",
        {testmessage: "this is iter " + niters
        },
        function(text){
        $(name).append("got: "+text+"<br />" );
        },
        "text");
    if(niters > 0)
    {
        setTimeout(function(){
            gameLoop(name, niters-1);
            }, 1000);
        
    } else {
        $(name).append("maxed out<br/>");
    }
}

gameLoop("#testReload", 10);
$(name).append("but does it block?");