/**
* scripts/game.js
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* This file has the functions and such for running the game.
*
**/

function CityBuilder_makeUnhidden(name)
{
    $(name).css("display", "initial");
}

function CityBuilder_makeHidden(name)
{
    $(name).css("display", "none");
}

function CityBuilder_postForm(currcity, cityname, currsector, nBlocksToAdd)
{
    // data for post
    var data = {
        cityIndex: currcity,
        cityName: cityname,
        currentSector: currsector,
        growth: nBlocksToAdd
        
        };
    $.post("../scripts/processGame.php",data, function(ret){if(ret.len > 1){console.log(ret);} else {location.reload(); }});
}

function CityBuilder_appendRadioInputs(name, inputname, checkedindex, labels, values, cityIndex, cityNames, currentSector, growth)
{   
    if(labels == undefined)
        return;

    if(values == undefined)
        values = labels;
    
    // insert inputs
    for(var i = 0; i < values.length; i++)
    {
        var html = "<input class = 'radio_input' type = 'radio' name = '" + inputname + "' value = '" + values[i] + "'";
        if(i == checkedindex)
            html = html + "checked";
        html = html + "></input>" + labels[i] + "<br />";
        
        $(name).append(html);
        
    }
}