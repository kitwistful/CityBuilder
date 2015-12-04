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

function CityBuilder_makeUnhidden(name)
{
    $(name).css("display", "initial");
}

function GityBuilder_makeHidden(name)
{
    $(name).css("display", "none");
}

function CityBuilder_gameLoop(currCity, currSector)
{
    // data to give database
    var data = {
        currcity: currCity,
        currsector: currSector
        };
    
    // ask for data
    $.post("../scripts/game_update.php",data, CityBuilder_gotResult,"text");
        
    // wait 1 minute and then go again
    $n_seconds = 5;//60;
    setTimeout(function(){
        CityBuilder_gameLoop(currCity, currSector);
        }, 1000*$n_seconds);
}

function CityBuilder_appendRadioInputs(name, values)
{
    //todo
    $(name).append("hi");
}