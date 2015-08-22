<?php

namespace rocketpads\event;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;
use rocketpads\RocketPads;

class RocketPadsListener implements Listener{
    public function __construct(RocketPads $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onPlayerMove(PlayerMoveEvent $event){
        $this->getPlugin()->launchPlayer($event->getPlayer());
    }
}