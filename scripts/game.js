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

function CityBuilder_postForm(currcity, cityname)
{    
    // data for post
    var data = {
        cityIndex: currcity,
        cityName: cityname
        };
    $.post("../scripts/processGame.php",data, function(){location.reload();});
}

function CityBuilder_appendRadioInputs(name, inputname, checkedindex, labels, values)
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
        currElement.click(function(){CityBuilder_postForm();});
        
        // iterate
        currElement = $(currElement).next();
    }
}