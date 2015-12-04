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
    $.post("../scripts/processGame.php",data, function(){location.reload();});
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
    
    // activate inputs
    var currElement = $(name).find("input");
    for(var i = 0; i < values.length; i++)
    {
        // set onclick
        currElement.click(function(){
            if(!cityIndex)
                cityIndex = values[i];
            if(!currentSector)
                currentSector = values[i];
            if(!growth)
                growth = values[i];
            
            CityBuilder_postForm(cityIndex, cityNames[cityIndex], currentSector, growth);
            });
        
        // iterate
        currElement = $(currElement).next();
    }
}