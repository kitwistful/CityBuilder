/**
* scripts/game.js
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This file has the functions and such for running the game.
*
**/

var CityBuilder_outputDivName = "#testReload";

function CityBuilder_gotResult(text)
{
    $(CityBuilder_outputDivName).html("got: "+text+"<br />" );
}

function CityBuilder_gameLoop(currCity, currSector)
{
    // data to give database
    var data = {
        currcity: currCity,
        currsector: currSector
        };
    
    // about to post
    $(CityBuilder_outputDivName).html("getting info from database....");
    
    // ask for data
    $.post("../scripts/game_update.php",data, CityBuilder_gotResult,"text");
        
    // wait 1 minute and then go again
    setTimeout(function(){
        CityBuilder_gameLoop(currCity);
        }, 1000*60);
}