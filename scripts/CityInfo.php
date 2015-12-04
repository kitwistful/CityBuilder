<?php
/**
* scripts/CityInfo.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* Defines a data object containing game info.
*
**/
class CityInfo
{   
    function CityInfo($currSector, $nBlocks, $sectorBlocks, $cityID)
    {
        $this->currSector = $currSector;
        $this->nBlocks = $nBlocks;
        $this->sectorBlocks = $sectorBlocks;
        $this->cityID = $cityID;
    }
}


?>