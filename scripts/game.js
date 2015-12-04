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

function CityBuilder_makeHidden(name)
{
    $(name).css("display", "none");
}

function CityBuilder_appendRadioInputs(name, inputname, checkedindex, labels, values)
{   
    if(labels == undefined)
        return;

    if(values == undefined)
        values = labels;
    
    for(var i = 0; i < values.length; i++)
    {
        var html = "<input class = 'radio_input' type = 'radio' name = '" + inputname + "' value = '" + labels[i] + "'";
        if(i == checkedindex)
            html = html + "checked";
        html = html + "></input>" + labels[i] + "<br />";
        
        $(name).append(html);
        
    }
}