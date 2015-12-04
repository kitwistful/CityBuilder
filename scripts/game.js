/**
* scripts/game.js
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This file has the functions and such for running the game.
*
**/

var CityBuilder_outputdivname = "#testReload";

function CityBuilder_gotResult(text)
{
    $(CityBuilder_outputdivname).html("got: "+text+"<br />" );
}

function gameLoop(name)
{
    // data to give database
    var data = {
        testmessage: "bread"
        };
    
    // about to post
    $(name).html("getting info from database....");
    
    // ask for data
    $.post("../scripts/game_update.php",data, CityBuilder_gotResult,"text");
        
    // wait 1 minute and then go again
    setTimeout(function(){
        gameLoop(name);
        }, 1000*60);
}