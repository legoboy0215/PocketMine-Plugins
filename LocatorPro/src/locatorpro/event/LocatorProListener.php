<?php

namespace locatorpro\event;

use locatorpro\LocatorPro;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\Listener;

class LocatorProListener implements Listener{
    public function __construct(LocatorPro $plugin){
        $this->plugin = $plugin;
    }
    public function onPlayerDeath(PlayerDeathEvent $event){
        
    }
    public function onPlayerLogin(PlayerLoginEvent $event){

    }
    public function onPlayerMove(PlayerMoveEvent $event){

    }
    public function onPlayerRespawn(PlayerRespawnEvent $event){
        
    }
}
