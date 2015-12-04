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
    $.post("../scripts/processGame.php",data, function(){/*location.reload();*/});//todo
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
        // value of i
        var currValueIndex = i;
        
        // set onclick
        currElement.click(function(){
            
            
            console.log("currindex:" + currValueIndex, "currcity:" + cityIndex, "currsector:" + currentSector, "growth:" + growth);
            
            if(!cityIndex)
                cityIndex = values[currValueIndex];
            if(!currentSector)
                currentSector = values[currValueIndex];
            if(!growth)
                growth = values[currValueIndex];
            
            
            CityBuilder_postForm(cityIndex, cityNames[cityIndex], currentSector, growth);
            });
        
        // iterate
        currElement = $(currElement).next();
    }
}