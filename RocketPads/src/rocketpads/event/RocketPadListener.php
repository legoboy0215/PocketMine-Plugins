<?php

namespace rocketpads\event;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;
use rocketpads\RocketPads;

class RocketPadListener implements Listener{
    public function __construct(RocketPada $plugin){
        $this->plugin = $plugin;
    }
    public function getPlugin(){
        return $this->plugin;
    }
    public function onPlayerMove(PlayerMoveEvent $event){
        $this->getPlugin()->launchPlayer($event->getPlayer());
    }
}