<?php

namespace rocketpad\event;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;
use rocketpad\RocketPad;

class RocketPadListener implements Listener{
    public function __construct(RocketPad $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onPlayerMove(PlayerMoveEvent $event){
        $this->getPlugin()->launchPlayer($event->getPlayer());
    }
}