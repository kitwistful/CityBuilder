<?php
/**
* scripts/cityInfo.php
* Project: CityBuilder Application
* Author(s): Kathryn McKay
* Year: 2015
*
* Defines a data object containing game info.
*
**/
class CityInfo
{   
    function CityInfo($p_currSector, $p_nBlocks, $p_sectorBlocks, $p_nCoins)
    {
        $this->currSector = $p_currSector;
        $this->nBlocks = $p_nBlocks;
        $this->sectorBlocks = $p_sectorBlocks;
        $this->nCoins = $p_nCoins;
    }
}


?>